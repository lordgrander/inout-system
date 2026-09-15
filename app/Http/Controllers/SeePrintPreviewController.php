<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeePrintPreviewController extends Controller
{
    public function show($id)
    {
        if (session('user_task_user_id')) {
            Auth::onceUsingId((int) session('user_task_user_id'));
        }

        $beta_enter = DB::select("SELECT e.*,m.main_road_name FROM beta_enter e  LEFT JOIN beta_main_road m ON e.main_road_id = m.main_road_id WHERE e.enter_id = ?", [$id]);
        abort_if(empty($beta_enter), 404);

        $beta_enter_road_detail = DB::select("SELECT r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id WHERE r.enter_id = ?", [$id]);

        $user_data = DB::select("SELECT * FROM users WHERE id = ?", [$beta_enter[0]->user_id]);
        abort_if(empty($user_data), 404);

        $com_name_data = DB::select("SELECT * FROM beta_company_group WHERE com_id = ?", [$user_data[0]->com_id]);
        abort_if(empty($com_name_data), 404);

        $com_name = $com_name_data[0]->com_name;
        $com_owner_name = $com_name_data[0]->com_owner;

        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter_detail ed LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE ed.enter_id = ?", [$id]);
        $beta_enter_file = DB::select("SELECT * FROM beta_enter_file WHERE enter_id = ?", [$id]);

        return view('seeprint-preview.show', compact('beta_enter', 'beta_enter_detail', 'user_data', 'beta_enter_road_detail', 'beta_enter_file'))
            ->with('com_name', $com_name)
            ->with('com_owner_name', $com_owner_name)
            ->with('id', $id);
    }
}
