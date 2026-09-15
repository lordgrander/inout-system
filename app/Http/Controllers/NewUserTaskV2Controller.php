<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewUserTaskV2Controller extends Controller
{
    public function dashboard()
    {
        return view('new-user-task-v2.dashboard', [
            'userName' => session('new_user_task_user_name'),
            'authUntil' => session('new_user_task_auth_until'),
            'userRole' => (string) session('new_user_task_is_admin'),
            'signMode' => session('new_user_task_sign_mode', 'system'),
            'statusOptions' => $this->visibleStatuses(),
            'mainRoads' => DB::table('beta_main_road')->orderBy('main_road_id')->get(['main_road_id', 'main_road_name']),
            'roadOptions' => DB::table('beta_road_select')->orderBy('road_id')->get(['road_id', 'road_name']),
            'roadLabel' => 'ທັງໝົດ',
        ]);
    }

    public function print($id)
    {
        if (session('new_user_task_user_id')) {
            Auth::onceUsingId((int) session('new_user_task_user_id'));
        }

        $beta_enter = DB::table('new_enters as ne')
            ->leftJoin('beta_main_road as m', 'm.main_road_id', '=', 'ne.main_road_id')
            ->where('ne.id', $id)
            ->select([
                'ne.id as enter_id',
                'ne.user_id',
                'ne.com_id',
                'ne.enter_number',
                'ne.status',
                'ne.date_make',
                'ne.date_in',
                'ne.date_out',
                'ne.address',
                'ne.district',
                'ne.province',
                'ne.feed_back_msg',
                'ne.slug',
                'ne.main_road_id',
                'm.main_road_name',
                DB::raw('ne.updated_at as date_sign'),
                DB::raw('NULL as boss_id'),
                DB::raw('NULL as sign_url'),
            ])
            ->get();

        abort_if($beta_enter->isEmpty(), 404);

        $company = DB::table('beta_company_group')->where('com_id', $beta_enter[0]->com_id)->first();
        $user = DB::table('users')->where('id', $beta_enter[0]->user_id)->first();

        $user_data = collect([$user ?: (object) ['id' => $beta_enter[0]->user_id, 'name' => '', 'email' => '']]);
        $com_name = $company->com_name ?? '';
        $com_owner_name = $company->com_owner ?? '';

        $beta_enter_detail = DB::table('new_enter_details as ned')
            ->leftJoin('beta_t_type as t', 't.t_type_id', '=', 'ned.vehicle_type_id')
            ->where('ned.new_enter_id', $id)
            ->select([
                'ned.id as enter_detail_id',
                'ned.plate_number',
                'ned.driver_name as d_name',
                'ned.import_product as p_import',
                'ned.weight_kg as weight',
                'ned.rounds',
                'ned.import_document_no as detail',
                't.t_type_name',
            ])
            ->get();

        $beta_enter_road_detail = DB::table('new_enter_road_details as nerd')
            ->leftJoin('beta_road_select as rs', 'rs.road_id', '=', 'nerd.road_id')
            ->where('nerd.new_enter_id', $id)
            ->select(['nerd.road_id', 'rs.road_name'])
            ->get();

        $beta_enter_file = DB::table('new_enter_files')
            ->where('new_enter_id', $id)
            ->select(['id as file_id', 'new_enter_id as enter_id', 'file_url', 'date'])
            ->get();

        return view('new-seeprint-preview.show', compact('beta_enter', 'beta_enter_detail', 'user_data', 'beta_enter_road_detail', 'beta_enter_file'))
            ->with('com_name', $com_name)
            ->with('com_owner_name', $com_owner_name)
            ->with('id', $id);
    }

    private function visibleStatuses(): array
    {
        switch ((string) session('new_user_task_is_admin')) {
            case '2':
                return ['WAITING', 'POINTING', 'READY', 'SUCCESS'];
            case '3':
                return ['POINTING', 'SIGNING', 'SIGNINED', 'READY'];
            case '4':
                return ['SIGNING', 'SIGNINED', 'READY', 'SUCCESS'];
            case '5':
                return ['WAITING', 'POINTING', 'SIGNING', 'SIGNINED', 'READY', 'SUCCESS'];
            default:
                return [];
        }
    }
}
