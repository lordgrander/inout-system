<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;


use Carbon\carbon;


Use App\Models\beta_enter;
Use App\Models\beta_enter_detail;
Use App\Models\beta_enter_file;
Use App\Models\beta_feed_back;
Use App\Models\beta_main_road;
Use App\Models\beta_sign;
Use App\Models\beta_enter_road_detail;
Use App\Models\beta_road_select;

Use App\Models\User;
session();

class RemarkController extends Controller
{
    
    public function index()
    {
        $check = User::find(auth()->id());

        $beta_enter = DB::table('beta_enter as e')
            ->select(
                'c.com_name',
                'c.com_phone',
                'u.name',
                'u.email',
                'e.*',
                'm.main_road_name'
            )
            ->leftJoin('beta_company_group as c', 'e.com_id', '=', 'c.com_id')
            ->leftJoin('users as u', 'e.user_id', '=', 'u.id')
            ->leftJoin('beta_main_road as m', 'e.main_road_id', '=', 'm.main_road_id')
            ->where('e.status', 'SUCCESS')
            ->whereDate('e.date_make', '>=', now()->subDays(30)->toDateString())
            ->whereDate('e.date_make', '<=', now()->toDateString())
            ->orderBy('e.enter_number', 'DESC')
            ->paginate(10, ['*'], 'page_name');

        $beta_enter_ids = $beta_enter->pluck('enter_id')->toArray();

        $beta_main_road = DB::table('beta_main_road')->get();
        $beta_road_select = DB::table('beta_road_select')->get();

        $beta_enter_detail = DB::table('beta_enter as e')
            ->select('ed.*', 't.t_type_name')
            ->leftJoin('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->leftJoin('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
            ->where('e.status', 'SUCCESS')
            ->whereIn('e.enter_id', $beta_enter_ids)
            ->get()
            ->groupBy('enter_id');

        $beta_enter_road_detail = DB::table('beta_enter_road_detail as r')
            ->select('e.status', 'r.*', 'rn.road_name')
            ->leftJoin('beta_road_select as rn', 'r.road_id', '=', 'rn.road_id')
            ->leftJoin('beta_enter as e', 'r.enter_id', '=', 'e.enter_id')
            ->where('e.status', 'SUCCESS')
            ->whereIn('e.enter_id', $beta_enter_ids)
            ->get()
            ->groupBy('enter_id'); 
          

        $beta_enter_file = DB::table('beta_enter_file as f')
            ->select('f.*', 'e.status')
            ->leftJoin('beta_enter as e', 'f.enter_id', '=', 'e.enter_id')
            ->where('e.status', 'SUCCESS')
            ->whereIn('e.enter_id', $beta_enter_ids)
            ->get()
            ->groupBy('enter_id');

        return view('notallow.remark.index', compact(
            'beta_enter',
            'beta_main_road',
            'beta_road_select',
            'beta_enter_detail',
            'beta_enter_road_detail',
            'beta_enter_file'
        ))->with('log', $check->log);
    }

    public function add(Request $request)
    {
        $request->validate([
            'enter_detail_id' => 'required|exists:beta_enter_detail,enter_detail_id',
        ]);

        beta_enter_detail::where('enter_detail_id', $request->enter_detail_id)
             ->update([
            'remark' => 'yes',
            'remark_created_at' => Carbon::now('Asia/Bangkok'),
            'remark_by' => auth()->id(),
        ]);

        return response()->json(['success' => 'Remark added successfully']);
    }


    public function search(Request $request)
    {
        $check = User::find(auth()->id());

        $remark = $request->get('remark'); // yes | no | empty/all
        $search = trim($request->get('search', ''));

        $sortBy = $request->get('sort_by', 'e.enter_number');
        $sortDir = strtolower($request->get('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSorts = [
            'e.enter_number',
            'e.date_make',
        ];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'e.enter_number';
        }

        $applyRemarkFilter = function ($q, $alias = 'ed') use ($remark) {
            if ($remark === 'yes') {
                $q->where($alias . '.remark', 'yes');
            } elseif ($remark === 'no') {
                $q->where(function ($x) use ($alias) {
                    $x->where($alias . '.remark', 'no')
                    ->orWhereNull($alias . '.remark');
                });
            }
        };

        $beta_enter_query = DB::table('beta_enter as e')
            ->select(
                'c.com_name',
                'c.com_phone',
                'u.name',
                'u.email',
                'e.*',
                'm.main_road_name'
            )
            ->leftJoin('beta_company_group as c', 'e.com_id', '=', 'c.com_id')
            ->leftJoin('users as u', 'e.user_id', '=', 'u.id')
            ->leftJoin('beta_main_road as m', 'e.main_road_id', '=', 'm.main_road_id')
            ->where('e.status', 'SUCCESS')
            ->whereExists(function ($q) use ($applyRemarkFilter) {
                $q->select(DB::raw(1))
                ->from('beta_enter_detail as ed')
                ->whereColumn('ed.enter_id', 'e.enter_id');

                $applyRemarkFilter($q, 'ed');
            });

        if ($search !== '') {
            $beta_enter_query->where(function ($q) use ($search, $applyRemarkFilter) {
                $q->where('e.enter_number', 'like', '%' . $search . '%')
                ->orWhereDate('e.date_make', $search)
                ->orWhereExists(function ($sub) use ($search, $applyRemarkFilter) {
                    $sub->select(DB::raw(1))
                        ->from('beta_enter_detail as eds')
                        ->whereColumn('eds.enter_id', 'e.enter_id')
                        ->where(function ($x) use ($search) {
                            $x->where('eds.plate_number', 'like', '%' . $search . '%')
                                ->orWhere('eds.end_plate_number', 'like', '%' . $search . '%')
                                ->orWhere('eds.d_name', 'like', '%' . $search . '%');
                        });

                    $applyRemarkFilter($sub, 'eds');
                });
            });
        }

        $beta_enter = $beta_enter_query
            ->orderBy($sortBy, $sortDir)
            ->paginate(20, ['*'], 'page_name')
            ->appends($request->all());

        $beta_enter_ids = $beta_enter->pluck('enter_id')->toArray();

        $beta_main_road = DB::table('beta_main_road')->get();
        $beta_road_select = DB::table('beta_road_select')->get();

        $beta_enter_detail_query = DB::table('beta_enter as e')
            ->select('ed.*', 't.t_type_name')
            ->leftJoin('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->leftJoin('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
            ->where('e.status', 'SUCCESS')
            ->whereIn('e.enter_id', $beta_enter_ids);

        $applyRemarkFilter($beta_enter_detail_query, 'ed');

        if ($search !== '') {
            $beta_enter_detail_query->where(function ($q) use ($search) {
                $q->where('e.enter_number', 'like', '%' . $search . '%')
                ->orWhereDate('e.date_make', $search)
                ->orWhere('ed.plate_number', 'like', '%' . $search . '%')
                ->orWhere('ed.end_plate_number', 'like', '%' . $search . '%')
                ->orWhere('ed.d_name', 'like', '%' . $search . '%');
            });
        }

        $beta_enter_detail = $beta_enter_detail_query
            ->get()
            ->groupBy('enter_id');

        $beta_enter_road_detail = DB::table('beta_enter_road_detail as r')
            ->select('e.status', 'r.*', 'rn.road_name')
            ->leftJoin('beta_road_select as rn', 'r.road_id', '=', 'rn.road_id')
            ->leftJoin('beta_enter as e', 'r.enter_id', '=', 'e.enter_id')
            ->where('e.status', 'SUCCESS')
            ->whereIn('e.enter_id', $beta_enter_ids)
            ->get()
            ->groupBy('enter_id');

        $beta_enter_file = DB::table('beta_enter_file as f')
            ->select('f.*', 'e.status')
            ->leftJoin('beta_enter as e', 'f.enter_id', '=', 'e.enter_id')
            ->where('e.status', 'SUCCESS')
            ->whereIn('e.enter_id', $beta_enter_ids)
            ->get()
            ->groupBy('enter_id');

        return view('notallow.remark.index', compact(
            'beta_enter',
            'beta_main_road',
            'beta_road_select',
            'beta_enter_detail',
            'beta_enter_road_detail',
            'beta_enter_file'
        ))->with('log', $check->log);
    }

    public function paper($enter_id, $enter_detail_id)
    {
        $data = DB::table('beta_enter as e')
            ->select(
                'e.*',
                'c.com_name',
                'ed.*',
                't.t_type_name'
            )
            ->leftJoin('beta_company_group as c', 'e.com_id', '=', 'c.com_id')
            ->leftJoin('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->leftJoin('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
            ->where('e.enter_id', $enter_id)
            ->where('ed.enter_detail_id', $enter_detail_id)
            ->first();

        if (!$data || $data->remark !== 'yes') {
            abort(403);
        }

        $pdf = Pdf::loadView('notallow.remark.paper', compact('data'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('paper.pdf'); // preview in browser
    }
 
}