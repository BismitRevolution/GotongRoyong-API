<?php

namespace App\Http\Controllers\Campaigns;

use App\Http\Controllers\Controller,
  Illuminate\Support\Facades\DB as DB,
  App\User,
  Illuminate\Http\Request;

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
      $campaigns = DB::select(DB::raw("CALL `CAMPAIGNS_LIST`()"));
      foreach($campaigns as $row){
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
                "updated_by" => $row->updated_by
        );
        array_push($data,$campaign);
      }
      return $data;
    }

  public function getListActive()
  {
    $data = [];
    $campaigns = DB::select(DB::raw("CALL `CAMPAIGNS_LIST_ACTIVE`()"));
    foreach($campaigns as $row){
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
              "updated_by" => $row->updated_by
      );
      array_push($data,$campaign);
    }
    return $data;
  }

  public function getDetail($id)
  {
    $data = [];
    $campaigns = DB::select(DB::raw("CALL CAMPAIGNS_DETAIL($id)"));
    foreach($campaigns as $row){
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
              "updated_by" => $row->updated_by
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
}
