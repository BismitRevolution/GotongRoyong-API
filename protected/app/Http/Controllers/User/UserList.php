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
    $user = User::where('id', $id)->get();
    $userdata = $user->toArray();
    return $user;
  }
}
