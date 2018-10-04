<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageUserNGOController extends Controller
{
    public function create() {
        return view('admin.create-ngo-verified');
    }
}
