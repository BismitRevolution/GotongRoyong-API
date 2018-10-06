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
}
