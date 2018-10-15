<?php

namespace App\Http\Controllers;
use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserPahlawan as UserPahlawan;
use App\Http\Controllers\User\UserList as UList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Carbon\Carbon;




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
      $hero->about_me = "Welcome to my GotongRoyong.in profile !";
      $hero->my_url = "myurlabc.com";
      //$hero->instagram_link = "instagram.com/myprofile";
      //$hero->twitter_link = $request->twitter_link;
      //$hero->fb_link = $request->fb_link;

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

    public function getUserByUsername(Request $request)
    {
      $user = (new UList())->getUsername($request->input("username"));
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

    public function updateUser(Request $request)
    {
      $user = Auth::guard('api')->user();
      if($user){
        if($user->email != $request->input("email")){
          $cekEmail= User::where('email', $request->input("email"))->get();
          if(count($cekEmail) > 0){
            return response()->json([
                'success' => false,
                'message' => 'Email already exist',
                'data' => ''
              ],500);
          }
        }

        if($user->username != $request->input("username")){
          $cekUsername= User::where('username', $request->input("username"))->get();
          if(count($cekUsername) > 0){
            return response()->json([
                'success' => false,
                'message' => 'Username already exist',
                'data' => ''
              ],500);
          }
        }

        $originalDate = $request->input("birthdate");
        $date = new DateTime($originalDate);
        $user->username = $request->input("username");
        $user->fullname = $request->input("fullname");
        $user->birthdate = $date->format('Y-m-d');
        $user->birthplace = $request->input("birthplace");
        $user->email = $request->input("email");
        $user->password = Hash::make($request->input("password"));
        $user->gender = $request->input("gender");
        $user->save();

        $hero = new UserPahlawan();
        $hero->id_user = $user->id;
        $hero->about_me =  $request->input("about_me");
        $hero->my_url =  $request->input("my_url");
        $hero->instagram_link = $request->input("instagram_link");
        $hero->twitter_link = $request->input("twitter_link");
        $hero->fb_link = $request->input("fb_link");
        $hero->flag_verified = $request->input("flag_verified");
        $hero->update();

        return response()->json([
            'success' => true,
            'message' => 'Update user successfull',
            'data' => '',
          ],500);
      }

      return response()->json([
        'success' => false,
        'message' => 'Update user failure',
        'data' => 'Already logged out/Token false'],
        500);

    }

  public function updateImgProfile(Request $request)
  {
    if ($request->has('image_profile')) {

      $destinationPath = 'Uploads/user-photo-profile/'.Carbon::now()->timestamp;

      $moves = $request->file('image_profile')
          ->move($destinationPath,
              $request->file('image_profile')
                  ->getClientOriginalName());
      $url_file = $destinationPath."/".$request->file('image_profile')->getClientOriginalName();

      $user = Auth::guard('api')->user();
      if($user){
        $user->image_profile = $url_file;
        $user->save();

        return response()->json([
          'success' => true,
          'message' => 'Update user image profile success',
          'data' => $user->image_profile],
          200);
      }
      return response()->json([
        'success' => false,
        'message' => 'Update user image failure',
        'data' => 'Already logged out/Token false'],
        500);
    }

    return response()->json([
      'success' => false,
      'message' => 'Update user image failure',
      'data' => 'No file image'],
      500);
  }

  public function updateBgImgProfile(Request $request)
  {
    if ($request->has('bg_image_profile')) {

      $destinationPath = 'Uploads/bg-profile/'.Carbon::now()->timestamp;

      $moves = $request->file('bg_image_profile')
          ->move($destinationPath,
              $request->file('bg_image_profile')
                  ->getClientOriginalName());
      $url_file = $destinationPath."/".$request->file('bg_image_profile')->getClientOriginalName();

      $user = Auth::guard('api')->user();
      if($user){
        $user->bg_image_profile = $url_file;
        $user->save();

        return response()->json([
          'success' => true,
          'message' => 'Update user background image profile success',
          'data' => $user->bg_image_profile],
          200);
      }
      return response()->json([
        'success' => false,
        'message' => 'Update user background image failure',
        'data' => 'Already logged out/Token false'],
        500);
    }

    return response()->json([
      'success' => false,
      'message' => 'Update user background image failure',
      'data' => 'No file image'],
      500);
  }

    // public function updateUserPahlawan(Request $request)
    // {
    //   $user = Auth::guard('api')->user();
    //   if($user) {
    //     $hero = new UserPahlawan();
    //     $hero->id_user = $user->id;
    //     $hero->about_me =  $request->input("about_me");
    //     $hero->my_url =  $request->input("my_url");
    //     $hero->instagram_link = $request->input("instagram_link");
    //     $hero->twitter_link = $request->input("twitter_link");
    //     $hero->fb_link = $request->input("fb_link");
    //     $hero->flag_verified = $request->input("flag_verified");
    //     $hero->update();
    //
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Update user pahlawan successfull',
    //         'data' => '',
    //       ],500);
    //   }
    //
    //   return response()->json([
    //     'success' => false,
    //     'message' => 'Update user pahlawan failure',
    //     'data' => 'Already logged out/Token false'],
    //     500);
    // }

}
