<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function checkLoginRole(Request $request) {
        if($request->username == 'superadmin') {
            return redirect('super-admin/dashboard');
        } else if($request->username == 'admin') {
            return redirect('admin/dashboard');
        }

        Session::flash('gagal','Gagal Login');
        return redirect('/');
    }
}
