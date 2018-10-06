<?php

namespace App\Http\Controllers\CampaignAdsDonates;

use App\Http\Controllers\Controller,
  Illuminate\Support\Facades\DB as DB,
  App\User,
  Illuminate\Http\Request;

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
      return DB::unprepared(DB::raw("CALL CAMPAIGNS_ADS_DONATES_INSERT($this->id_campaign,$this->id_user,$this->id_ads,'$this->device')"));
    }
  }