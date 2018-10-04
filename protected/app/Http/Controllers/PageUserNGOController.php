<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageUserNGOController extends Controller
{
    public function create() {
        return view('admin.user-ngo-verified.create');
    }

    public function list() {
        return view('admin.user-ngo-verified.list-user');
    }
}
