<?php

namespace App\Http\Controllers;
use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserPahlawan as UserPahlawan;
use App\Http\Controllers\User\UserList as UList;
use Illuminate\Support\Facades\DB;

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
    $data = (new UList())->getDetailById($request->input("id"));
    if($data){
      return response()->json([
          'success' => true,
          'message' => 'Total User Pahlawans',
          'data' => $data,
        ],200);
    }
  }

    public function getUserPaginate(){
        $data_users = DB::table('users')
            ->join('users_pahlawan', 'users.id', '=', 'users_pahlawan.id_user')
//            ->select('users.*', 'users_pahlawan.*')
            ->select(
                'users.id as id_user',
                'users.fullname',
                'users_pahlawan.flag_verified',
                'users.image_profile',
                'users_pahlawan.fb_link',
                'users_pahlawan.twitter_link',
                'users_pahlawan.instagram_link',
                'users_pahlawan.count_donations',
                'users_pahlawan.count_campaign_owned')
            ->where('users.flag_active','=',1)
            ->orderBy('created_at','desc')
            ->paginate(10);

        if($data_users) {
            return response()->json([
                'success' => true,
                'message' => 'Users Active List Pagination',
                'data' => $data_users
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No Users',
            'data' => $data_users,
        ],500);
    }

}
