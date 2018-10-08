<?php

namespace App\Http\Controllers\Campaigns;

use App\Http\Controllers\Controller,
  Illuminate\Support\Facades\DB as DB,
  App\User,
  Illuminate\Http\Request,
  App\Http\Controllers\Campaigns\CampaignsImage as CImage;
use Carbon\Carbon;


class CampaignsList extends Controller
  {

    public $id;
    public $title;
    public $id_user;
    public $description;
    public $count_donations;
    public $count_users;
    public $count_shares;
    public $target_donation;
    public $deadline;
    public $complete_sts;
    public $flag_active;
    public $campaign_link;
    public $created_at;
    public $updated_at;
    public $created_by;
    public $updated_by;
    public $exist;

    public function __construct($id = false)
    {
      if($id){
        $item = DB::table('campaigns')
          ->where('id', $id)
          ->first();
          if($item){
              $this->id               = $item->id;
              $this->title            = $item->title;
              $this->id_user          = $item->id_user;
              $this->description      = $item->description;
              $this->count_donations  = $item->count_donations;
              $this->count_users      = $item->count_users;
              $this->count_shares     = $item->count_shares;
              $this->target_donation  = $item->target_donation;
              $this->deadline         = $item->deadline;
              $this->complete_sts     = $item->complete_sts;
              $this->flag_active      = $item->flag_active;
              $this->campaign_link    = $item->campaign_link;
              $this->created_at       = $item->created_at;
              $this->updated_at       = $item->updated_at;
              $this->created_by       = $item->created_by;
              $this->updated_by       = $item->updated_by;
              $this->exist            = true;
          }
          else{
              $this->exist    = false;
          }
    }
    else{

    }
    }

    public function getList()
    {
      $data = [];
//      $campaigns = DB::select(DB::raw("CALL `CAMPAIGNS_LIST`()"));
    $campaigns = DB::table('campaigns')
        ->join('users', 'campaigns.id_user', '=', 'users.id')
        ->join('users_pahlawan', 'campaigns.id_user', '=', 'users_pahlawan.id_user')
        ->select('users_pahlawan.flag_verified','users.fullname', 'campaigns.id as id_campaign',
            'users.image_profile','campaigns.title','campaigns.count_donations','campaigns.count_users','campaigns.count_shares', 'campaigns.created_at',
            'campaigns.target_donation','campaigns.deadline','campaigns.complete_sts','campaigns.campaign_link')
        ->where('users.flag_active','=',1)
        ->where('campaigns.flag_active','=',1)
        ->orderBy('campaigns.created_at','desc')
        ->get();

        $item_id=1;
      foreach($campaigns as $row){
        $images = new CImage;
        $images->id_campaign = $row->id_campaign;
        $list_img = $images->getImage();
        $date_deadline = Carbon::parse($row->deadline);
        $now = Carbon::now();
        $diff_deadline = $date_deadline->diffInDays($now);

        $campaign = array(
                "item_id"           => $item_id,
                "id_campaign"       => $row->id_campaign,

                "title"             => $row->title,
                "campaigner_user"   => $row->fullname,
                "image_profile"     => $row->image_profile,
                "flag_verified_user" => $row->flag_verified,
                "count_donations"   => $row->count_donations,
                "count_users"       => $row->count_users,
                "count_shares"      => $row->count_shares,
                "target_donation"   => $row->target_donation,
                "deadline"          => $diff_deadline,
                "complete_sts"      => $row->complete_sts,
                "campaign_link" => $row->campaign_link,
                "created_at" => $row->created_at,
                "list_images" => $list_img
        );
        array_push($data,$campaign);
        $item_id++;
      }
      return collect($data);
    }

  public function getListActive()
  {
    $data = [];
    $campaigns = DB::select(DB::raw("CALL `CAMPAIGNS_LIST_ACTIVE`()"));
    foreach($campaigns as $row){
      $images = new CImage;
      $images->id_campaign = $row->id;
      $list_img = $images->getImage();
      $campaign = array(
              "id"      => $row->id,
              "title"   => $row->title,
              "id_user" => $row->id_user,
              "description" => $row->description,
              "count_donations" => $row->count_donations,
              "count_users" => $row->count_users,
              "count_shares" => $row->count_shares,
              "target_donation" => $row->target_donation,
              "deadline" => $row->deadline,
              "complete_sts" => $row->complete_sts,
              "flag_active" => $row->flag_active,
              "campaign_link" => $row->campaign_link,
              "created_at" => $row->created_at,
              "updated_at" => $row->updated_at,
              "created_by" => $row->created_by,
              "updated_by" => $row->updated_by,
              "list_images" => $list_img
      );
      array_push($data,$campaign);
    }
    return $data;
  }

  public function getDetail($id)
  {
    $data = array();
    $campaigns = DB::select(DB::raw("CALL CAMPAIGNS_DETAIL($id)"));
    foreach($campaigns as $row){
      $images = new CImage;
      $images->id_campaign = $row->id;
      $list_img = $images->getImage();
      $campaign = array(
              "id"      => $row->id,
              "title"   => $row->title,
              "id_user" => $row->id_user,
              "description" => $row->description,
              "count_donations" => $row->count_donations,
              "count_users" => $row->count_users,
              "count_shares" => $row->count_shares,
              "target_donation" => $row->target_donation,
              "deadline" => $row->deadline,
              "complete_sts" => $row->complete_sts,
              "flag_active" => $row->flag_active,
              "campaign_link" => $row->campaign_link,
              "created_at" => $row->created_at,
              "updated_at" => $row->updated_at,
              "created_by" => $row->created_by,
              "updated_by" => $row->updated_by,
              "list_images" => $list_img
      );
      $data = $campaign;
    }
    return $data;
  }

  public function getListByUser($idUser)
  {
    $data = [];
    $campaigns = DB::select(DB::raw("CALL CAMPAIGNS_LIST_USER($idUser)"));
    foreach($campaigns as $row){
      $images = new CImage;
      $images->id_campaign = $row->id;
      $list_img = $images->getImage();
      $campaign = array(
              "id"      => $row->id,
              "title"   => $row->title,
              "id_user" => $row->id_user,
              "description" => $row->description,
              "count_donations" => $row->count_donations,
              "count_users" => $row->count_users,
              "count_shares" => $row->count_shares,
              "target_donation" => $row->target_donation,
              "deadline" => $row->deadline,
              "complete_sts" => $row->complete_sts,
              "flag_active" => $row->flag_active,
              "campaign_link" => $row->campaign_link,
              "created_at" => $row->created_at,
              "updated_at" => $row->updated_at,
              "created_by" => $row->created_by,
              "updated_by" => $row->updated_by,
              "list_images" => $list_img

      );
      array_push($data,$campaign);
    }
    return $data;
  }

  public function create()
  {
    return DB::unprepared(DB::raw("CALL CAMPAIGNS_INSERT('$this->title', $this->id_user, '$this->description', $this->target_donation, '$this->deadline', '$this->campaign_link', $this->created_by)"));
  }

  public function delete()
  {
    return DB::unprepared(DB::raw("CALL CAMPAIGNS_DELETE($this->id)"));
  }

  public function countActive()
  {
    $datacount = array();
    $counts = DB::select(DB::raw("CALL COUNT_CAMPAIGNS()"));
    foreach($counts as $count){
      $data = array(
        "total" => $count->total
      );
      $datacount = $data;
    }
    return $datacount;
  }
}
