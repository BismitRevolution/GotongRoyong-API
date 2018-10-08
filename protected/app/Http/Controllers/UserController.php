<?php

namespace App\Http\Controllers;
use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserPahlawan as UserPahlawan;
use App\Http\Controllers\User\UserList as UList;

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

  public function createPahlawan(Request $request, $user)
  {
      $hero = new UserPahlawan();
      $hero->id_user = $user->id;
      $hero->about_me = $request->about_me;
      $hero->my_url = $request->my_url;
      $hero->instagram_link = $request->instagram_link;
      $hero->twitter_link = $request->twitter_link;
      $hero->fb_link = $request->fb_link;

      $hero->create();
      $result = array();
      $userdata = $user->toArray();
      if ($user) {
        $pahlawan_detail = $hero->getUserPahlawan($user);
        $userdata["data_pahlawan"] = $pahlawan_detail;

        return response()->json([
          'success' => true,
          'message' => 'User created successfully',
          'data' => $userdata,
        ],200);
      }

      return response()->json([
        'success' => false,
        'message' => 'User created fail',
        'data' => ''],
        500);
  }

  public function countUsers(Request $request)
  {
    $data = (new UList())->countActive();
    if($data){
      return response()->json([
          'success' => true,
          'message' => 'Total User Pahlawans',
          'data' => $data,
        ],200);
    }

    return response()->json([
      'success' => false,
      'message' => 'No User',
      'data' => $data,
    ],500);
  }

  public function getDetailById(Request $request)
  {
    $user = (new UList())->getDetailById($request->input("id"));
    if($user){
      $pahlawan_detail = (new UserPahlawan)->getUserPahlawanById($user["id"]);
      $user["data_pahlawan"] = $pahlawan_detail;
      return response()->json([
          'success' => true,
          'message' => 'User Detail',
          'data' => $user,
        ],200);
    }
    return response()->json([
      'success' => false,
      'message' => 'No User',
      'data' => $user,
    ],500);
  }

}
