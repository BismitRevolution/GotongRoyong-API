<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageAdsController extends Controller
{
    public function create_advertiser() {
        return view('admin.campaigns.create');
    }

    public function create_content() {
        return view('admin.campaigns.create');
    }

    public function list_ads() {
        return view('admin.campaigns.list-campaign');
    }
}
