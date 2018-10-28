<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller,
  Illuminate\Support\Facades\DB as DB,
  App\User,
  Illuminate\Http\Request;

class UserPahlawan extends Controller
{

  public $id;
  public $id_user;
  public $count_shares;
  public $count_campaigns;
  public $count_donations;
  public $about_me;
  public $my_url;
  public $instagram_link;
  public $twitter_link;
  public $fb_link;
  public $flag_verified;

  public function __construct()
  {


  }

  public function getUserPahlawan(User $user)
  {
      $data = array();
      $this->id_user = $user->id;
      $pahlawan_detail = DB::select(DB::raw("CALL USER_PAHLAWAN_DETAIL($this->id_user)"));
      foreach($pahlawan_detail as $row){
          $item = array(
              "id"              => $row->id,
              "count_shares"    => $row->count_shares,
              "count_campaigns" => $row->count_campaigns,
              "count_donations" => $row->count_donations,
              "about_me"        => $row->about_me,
              "my_url"          => $row->my_url,
              "instagram_link"  => $row->instagram_link,
              "twitter_link"    => $row->twitter_link,
              "fb_link"         => $row->fb_link,
              "flag_verified"   => $row->flag_verified
          );
          $data = $item;
      }
      return $data;
  }

  public function getUserPahlawanById($id_user)
  {
    $data = array();
    $pahlawan_detail = DB::select(DB::raw("CALL USER_PAHLAWAN_DETAIL($id_user)"));
    foreach($pahlawan_detail as $row){
        $item = array(
            "id"              => $row->id,
            "count_shares"    => $row->count_shares,
            "count_campaigns" => $row->count_campaigns,
            "count_campaign_owned" => $row->count_campaign_owned,
            "count_donations" => $row->count_donations,
            "about_me"        => $row->about_me,
            "my_url"          => $row->my_url,
            "instagram_link"  => $row->instagram_link,
            "twitter_link"    => $row->twitter_link,
            "fb_link"         => $row->fb_link,
            "flag_verified"   => $row->flag_verified
        );
        $data = $item;
    }
    return $data;
  }

  public function create()
  {
    return DB::unprepared(DB::raw("CALL USER_PAHLAWAN_CREATE($this->id_user,'$this->about_me','$this->my_url')"));
  }

  public function update()
  {
    $flag2 = $this->flag_verified;
    if($flag2 == null){
      $flag2 = 0;
    }
    return DB::unprepared(DB::raw("CALL USER_PAHLAWAN_UPDATE('$this->about_me','$this->my_url','$this->instagram_link','$this->twitter_link','$this->fb_link',$flag2,$this->id_user)"));
  }
}
