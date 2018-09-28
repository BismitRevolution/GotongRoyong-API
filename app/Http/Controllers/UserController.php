<?php

namespace App\Http\Controllers;
use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserPahlawan as UserPahlawan;

class UserController extends Controller
{

  public function __construct()
  {


  }

  public function getDetails(Request $request)
  {
      $user = Auth::guard('api')->user();
      $result = array();
      $userdata = $user->toArray();
      if ($user) {
        $pahlawan_detail = (new UserPahlawan)->getUserPahlawan($user);
        $userdata["data_pahlawan"] = $pahlawan_detail;

        return response()->json([
          'success' => true,
          'message' => 'User detail',
          'data' => $userdata,
        ],200);
      }

      return response()->json([
        'success' => false,
        'message' => 'Get user detail failure',
        'data' => 'Already logged out/Token false'],
        500);
  }

  public function getDetailsWithoutAuth(User $user)
  {
      return $pahlawan_detail = (new UserPahlawan)->getUserPahlawan($user);
  }

}
