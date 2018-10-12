<?php

namespace App\Http\Controllers\LogUsers;

use App\Http\Controllers\Controller,
  Illuminate\Support\Facades\DB as DB,
  App\User,
  Illuminate\Http\Request;
use Carbon\Carbon;


class LogUsersList extends Controller
  {

    public $id;
    public $id_user;
    public $from_page;
    public $to_page;
    public $created_at;
    public $device;
    public $exist;

    public function __construct($id = false)
    {
      if($id){
        $item = DB::table('log_users')
          ->where('id', $id)
          ->first();
          if($item){
              $this->id               = $item->id;
              $this->id_user          = $item->id_user;
              $this->device           = $item->device;
              $this->from_page        = $item->from_page;
              $this->to_page          = $item->to_page;
              $this->created_at       = $item->created_at;
              $this->exist            = true;
          }
          else{
              $this->exist    = false;
          }
      }
      else{

      }
    }

    public function create()
    {
      return DB::unprepared(DB::raw("CALL LOG_USERS_CREATE($this->id_user, '$this->from_page', '$this->to_page', '$this->device')"));
    }

  }
