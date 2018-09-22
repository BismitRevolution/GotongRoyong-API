<?php

namespace App\Http\Controllers;

use App\campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = DB::table('campaigns_copy')->get();
        return json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(campaign $campaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, campaign $campaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(campaign $campaign)
    {
        //
    }
}
