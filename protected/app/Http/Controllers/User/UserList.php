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

  public function __construct()
  {

  }

  public function getDetailById($id)
  {
    $userdata = array();
    $users = User::where('id', $id)->get();
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
        "image_profile" => $row->image_profile
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
}
