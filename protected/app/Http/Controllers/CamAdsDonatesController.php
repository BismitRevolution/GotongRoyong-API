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
    $donation = new DList();
    $content = $request->all();
    $donation->id_user = $content['id_user'];
    $donation->id_campaign = $content['id_campaign'];

    $ads = new AdsContent();
    $arr = $ads->getRandom($content['id_user']);
    $donation->id_ads = $arr['id'];

    $donation->device = $content['device'];

    $donation->create();

    $data = [];
    array_push($data,$arr);
    return response()->json([
        'success' => true,
        'message' => 'Campaigns List',
        'data' => $data,
    ],200);

  }

}
