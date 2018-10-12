<?php

namespace App\Http\Controllers\CampaignAdsDonates;

use App\Http\Controllers\Controller,
  Illuminate\Support\Facades\DB as DB,
  App\User,
  Illuminate\Http\Request,
  App\Http\Controllers\Campaigns\CampaignsList as CList,
  App\Http\Controllers\User\UserList as UList;
use Illuminate\Support\Facades\Auth;



  class DonatesList extends Controller
  {

    public $id;
    public $id_campaign;
    public $id_user;
    public $id_ads;
    public $device;
    public $click_target_url;
    public $created_at;
    public $updated_at;
    public $exist;

    public function __construct($id = false)
    {
      if($id){
        $item = DB::table('campaigns_ads_donates')
          ->where('id', $id)
          ->first();
          if($item){
              $this->id               = $item->id;
              $this->id_campaign      = $item->id_campaign;
              $this->id_user          = $item->id_user;
              $this->id_ads           = $item->id_ads;
              $this->click_target_url = $item->click_target_url;
              $this->device           = $item->device;
              $this->created_at       = $item->created_at;
              $this->updated_at       = $item->updated_at;
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
      $data = array();
      $datadonation = DB::select(DB::raw("CALL CAMPAIGNS_ADS_DONATES_INSERT($this->id_campaign,$this->id_user,$this->id_ads,'$this->device')"));
      foreach($datadonation as $row){
        $item = array(
                "id"      => $row->id,
                "id_campaign"   => $row->id_campaign,
                "id_user" => $row->id_user,
                "id_ads" => $row->id_ads,
                "device" => $row->device,
                "click_target_url" => $row->click_target_url,
                "created_at" => $row->created_at,
                "updated_at" => $row->updated_at
        );
        $data = $item;
      }
      return $data;
    }

    public function donateSuccess()
    {
      return DB::unprepared(DB::raw("CALL CAMPAIGNS_ADS_UPDATE_DONATES_SUCCESS($this->id_campaign,$this->id_user)"));
    }

    public function updateClickUrl()
    {
      return DB::unprepared(DB::raw("CALL CAMPAIGN_ADS_DONATES_CLICK_URL($this->id)"));
    }

    public function getListUser()
    {
      $data = [];
      $campaigns = DB::select(DB::raw("CALL CAMPAIGN_ADS_DONATES_BY_USER($this->id_user)"));
      foreach($campaigns as $row){
        $clist = (new CList)->getDetail($row->id_campaign);
        $clist["jumlah_donasi"] = $row->jumlahdonasi;
        array_push($data,$clist);
      }
      return $data;
    }

    public function getListCampaign(Request $request)
    {
      $id_self = Auth::guard('api')->user();
      $data = [];
      $users = DB::select(DB::raw("CALL CAMPAIGN_ADS_DONATES_BY_CAMPAIGN($this->id_campaign)"));
      foreach($users as $row){
        if($row->id_user != $id_self->id){
          $ulist = (new UList)->getDetailById($row->id_user);
          $ulist["jumlah_donasi"] = $row->jumlahdonasi;
          array_push($data,$ulist);
        }
      }
      return $data;
    }

    public function getListCampaignSelf(Request $request)
    {
      $id_self = Auth::guard('api')->user();
      $data = [];
      $users = DB::select(DB::raw("CALL CAMPAIGN_ADS_DONATES_BY_CAMPAIGN($this->id_campaign)"));
      foreach($users as $row){
        if($row->id_user == $id_self->id){
          $ulist = (new UList)->getDetailById($row->id_user);
          $ulist["jumlah_donasi"] = $row->jumlahdonasi;
          array_push($data,$ulist);
        }
      }
      return $data;
    }

    public function countActive()
    {
      $datacount = array();
      $counts = DB::select(DB::raw("CALL COUNT_DONATIONS()"));
      foreach($counts as $count){
        $data = array(
          "total" => $count->total
        );
        $datacount = $data;
      }
      return $datacount;
    }

    public function shareSuccess()
    {
      return DB::unprepared(DB::raw("CALL CAMPAIGN_ADS_UPDATE_SHARE_SUCCESS($this->id_campaign,$this->id_user)"));
    }

  }
