<?php

namespace App\Http\Controllers\User;

use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth,
    Illuminate\Support\Facades\DB as DB;

class UserList extends Controller
{
  public $id;
  public $username;
  public $email;
  public $fullname;
  public $birthdate;
  public $birthplace;
  public $gender;
  public $role;
  public $flag_active;
  public $image_profile;
  public $id_fb;
  public $id_google;
  public $bg_image_profile;

  public function __construct()
  {

  }

  public function getDetailById($id)
  {
    $userdata = array();
    $users = User::where('id', $id)
        ->orderBy('id','asc')
        ->get();
    foreach($users as $row){
      $user = array(
        "id"      => $row->id,
        "username" => $row->username,
        "fullname" => $row->fullname,
        "birthplace" => $row->birthplace,
        "birthdate" => $row->birthdate,
        "gender" => $row->gender,
        "role" => $row->role,
        "flag_active" => $row->flag_active,
        "created_at" => $row->created_at,
        "image_profile" => $row->image_profile,
        "id_fb" => $row->id_fb,
        "id_google" => $row->id_google,
        "bg_image_profile" => $row->bg_image_profile
      );
      $userdata = $user;
    }
    return $userdata;
  }

  public function countActive()
  {
    $datacount = array();
    $counts = DB::select(DB::raw("CALL COUNT_USERS_PAHLAWAN()"));
    foreach($counts as $count){
      $data = array(
        "total" => $count->total
      );
      $datacount = $data;
    }
    return $datacount;
  }

  public function getUsername($username)
  {
    $userdata = array();
    $users = User::where('username', $username)->get();
    foreach($users as $row){
      $user = array(
        "id"      => $row->id,
        "username" => $row->username,
        "fullname" => $row->fullname,
        "birthplace" => $row->birthplace,
        "birthdate" => $row->birthdate,
        "gender" => $row->gender,
        "role" => $row->role,
        "flag_active" => $row->flag_active,
        "created_at" => $row->created_at,
        "image_profile" => $row->image_profile,
        "id_fb" => $row->id_fb,
        "id_google" => $row->id_google,
        "bg_image_profile" => $row->bg_image_profile
      );
      $userdata = $user;
    }
    return $userdata;
  }


}
