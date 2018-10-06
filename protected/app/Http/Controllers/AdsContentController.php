<?php

namespace App\Http\Controllers;
use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdsContent\AdsContentList as ACList;
use DateTime;


class AdsContentController extends Controller
{
  public function __construct()
  {


  }

  public function getRandom($id_user)
  {
    $data = (new ACList)->adsRandom($id_user);
    return $data;
  }
}
