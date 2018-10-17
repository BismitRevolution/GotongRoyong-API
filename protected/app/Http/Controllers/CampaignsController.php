<?php

namespace App\Http\Controllers;
use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Campaigns\CampaignsList as CList;
use DateTime;
use Illuminate\Support\Facades\Input;


class CampaignsController extends Controller
{
    function collection_paginate($items, $per_page)
    {
        $page   = Input::get('page', 1);
        $offset = ($page * $per_page) - $per_page;

        return new LengthAwarePaginator(
            $items->forPage($page, $per_page)->values(),
            $items->count(),
            $per_page,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    public function getCampaignsListPaginate(Request $request)
    {

        $data = (new CList)->getList();

        $page = Input::get('page', 1); // Get the ?page=1 from the url
        $perPage = 3; // Number of items per page
        $offset = ($page * $perPage) - $perPage;

        if($data) {
            return response()->json([
                'success' => true,
                'message' => 'Campaigns List',
                'data' =>
                    $this->collection_paginate($data,$perPage),
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No Campaigns',
            'data' => $data,
        ],500);

    }

  public function getCampaignsList(Request $request)
  {
    $data = (new CList)->getList();
    if($data){
      return response()->json([
          'success' => true,
          'message' => 'Campaigns List',
          'data' => $data,
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'No Campaigns',
      'data' => $data,
    ],500);
  }

  public function getCampaignsListActive(Request $request)
  {
    $data = (new CList)->getListActive();
    if($data){
      return response()->json([
          'success' => true,
          'message' => 'Active Campaigns List',
          'data' => $data,
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'No Active Campaigns',
      'data' => $data,
    ],500);
  }

  public function getCampaignsDetail(Request $request)
  {
    $data = (new CList)->getDetail($request->input('id'));
    if($data){
      return response()->json([
          'success' => true,
          'message' => 'Campaign Detail',
          'data' => $data,
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'Campaign not found',
      'data' => $data,
    ],500);
  }

  public function createCampaign(Request $request)
  {
    $campaign = new CList();
    $content = $request->all();
    $campaign->title = $content['title'];
    $campaign->id_user = $content['id_user'];
    $campaign->description = $content['description'];
    $campaign->target_donation = $content['target_donation'];

    $originalDate = $content['deadline'];
    $date = new DateTime($originalDate);
    $today = new DateTime();

    if($date < $today){
      return response()->json([
        'success' => false,
        'message' => 'Deadline date already passed',
        'data' => '',
      ],500);
    }

    $campaign->deadline = $date->format('Y-m-d');;

    $campaign->campaign_link = $content['campaign_link'];
    $campaign->created_by = $content['created_by'];

    $campaign->create();

    return response()->json([
      'success' => true,
      'message' => 'Campaign created successfully',
      'data' => '',
    ],201);
  }

  public function deleteCampaign(Request $request)
  {
    $campaign = new CList($request->input('id'));
    if($campaign->flag_active == 1) {
      $campaign->delete();
      return response()->json([
        'success' => true,
        'message' => 'Campaign deleted successfully',
        'data' => '',
      ],200);
    } else{
      return response()->json([
        'success' => false,
        'message' => 'Campaign id wrong',
        'data' => '',
      ],200);
    }
  }

  public function getCampaignsUser (Request $request)
  {
    $data = (new CList())->getListByUser($request->input('id_user'));
    if($data){
      return response()->json([
          'success' => true,
          'message' => 'User Campaigns List',
          'data' => $data,
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'No Campaigns',
      'data' => $data,
    ],500);
  }

  public function countCampaign (Request $request)
  {
    $data = (new CList())->countActive();
    if($data){
      return response()->json([
          'success' => true,
          'message' => 'Total Campaigns',
          'data' => $data,
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'No Campaigns',
      'data' => $data,
    ],500);
  }

  public function completeStatus(Request $request)
  {
      $campaign = new CList($request->input('id'));
      if($campaign){
        if($campaign->complete_sts == 0){
          $campaign->complete();
          return response()->json([
              'success' => true,
              'message' => 'Campaign is completed',
              'data' => '',
            ],200);
        }
        return response()->json([
          'success' => false,
          'message' => 'Campaign already completed',
          'data' => '',
        ],500);
      }

      return response()->json([
        'success' => false,
        'message' => 'No Campaign',
        'data' => '',
      ],500);
  }

}
