<?php

namespace App\Http\Controllers;
use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CampaignAdsDonates\DonatesList as DList;
use App\Http\Controllers\AdsContentController as AdsContent;
use DateTime;


class CamAdsDonatesController extends Controller
{
  public function createDonates(Request $request)
  {

    $user = Auth::guard('api')->user();
    $donation = new DList();
    $content = $request->all();
    $donation->id_user = $user->id;
    $donation->id_campaign = $content['id_campaign'];

    $ads = new AdsContent();
    $arr = $ads->getRandom($user->id);

    $donation->id_ads = $arr['id'];
    $donation->device = $content['device'];

    $data_donation = $donation->create();
    $data = [];

    $data['donation_data'] = $data_donation;

    $data['ads_data'] = $arr;

    return response()->json([
        'success' => true,
        'message' => 'Campaign Donation and Random Ads Detail',
        'data' => $data,
    ],200);

  }

  public function updateDonations(Request $request)
  {
    $user = Auth::guard('api')->user();
    $donation = new DList();
    $donation->id_campaign = $request->input('id_campaign');
    $donation->id_user = $user->id;
    $donation->donateSuccess();

    return response()->json([
        'success' => true,
        'message' => 'Donation successful',
        'data' => '',
    ],200);
  }

  public function clickUrl(Request $request)
  {
    $donation = new DList();
    $donation->id = $request->input('id_donation');
    $donation->updateClickUrl();

    return response()->json([
        'success' => true,
        'message' => 'Click Target Url update successful',
        'data' => '',
    ],200);
  }

  public function getListByUser(Request $request)
  {
    $donation = new DList();
    $donation->id_user = $request->input('id_user');
    $data = $donation->getListUser();

    if($data){
      return response()->json([
          'success' => true,
          'message' => 'Campaigns Participation By User',
          'data' => $data,
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'No Campaign Participation By User',
      'data' => $data,
    ],500);
  }

  public function getListByCampaign(Request $request)
  {
    $donation = new DList();
    $donation->id_campaign = $request->input('id_campaign');
    $data = $donation->getListCampaign($request);

    if($data){
      return response()->json([
          'success' => true,
          'message' => 'Users Participated in Campaign',
          'data' => $data,
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'No User Participation',
      'data' => $data,
    ],500);
  }

  public function getListByCampaignSelf(Request $request)
  {
    $donation = new DList();
    $donation->id_campaign = $request->input('id_campaign');
    $data = $donation->getListCampaignSelf($request);

    if($data){
      return response()->json([
          'success' => true,
          'message' => 'This User Participation in This Campaign',
          'data' => $data,
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'No User Participation',
      'data' => $data,
    ],500);
  }

  public function countDonations(Request $request)
  {
    $data = (new DList())->countActive();
    if($data){
      return response()->json([
          'success' => true,
          'message' => 'Total Donations',
          'data' => $data,
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'No Donation',
      'data' => $data,
    ],500);
  }

  public function countMoney(Request $request)
  {
    $data = 100000000;

    if($data){
      return response()->json([
          'success' => true,
          'message' => 'Total Money Result',
          'data' => ['total' => $data],
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'No Money Result',
      'data' => $data,
    ],500);
  }


}
