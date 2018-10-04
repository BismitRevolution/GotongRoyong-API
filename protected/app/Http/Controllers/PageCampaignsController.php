<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageCampaignsController extends Controller
{
    public function create() {
        $users = DB::table('users')
            ->join('users_pahlawan', 'users.id', '=', 'users_pahlawan.id_user')
            ->select('users.*', 'users_pahlawan.*')
            ->where('users_pahlawan.flag_verified','=',1)
            ->get();

        dd($users);
        return view('admin.campaigns.create');
    }

    public function list() {
        return view('admin.campaigns.list-campaign');
    }
}
