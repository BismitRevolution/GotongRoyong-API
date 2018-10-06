<?php

namespace App\Http\Controllers\Campaigns;

use App\Http\Controllers\Controller,
  Illuminate\Support\Facades\DB as DB,
  App\User,
  Illuminate\Http\Request;

  class CampaignsImage extends Controller
  {

    public $id;
    public $id_campaign;
    public $img_url;
    public $exist;

    public function __construct($id = false)
    {
      if($id){
        $item = DB::table('campaign_images')
          ->where('id', $id)
          ->first();
          if($item){
              $this->id               = $item->id;
              $this->id_campaign      = $item->id_campaign;
              $this->img_url          = $item->img_url;
              $this->exist            = true;
          }
          else{
              $this->exist    = false;
          }
    }
      else{

      }
    }

    public function getImage()
    {
      $data = [];
      $imgs = DB::select(DB::raw("CALL CAMPAIGN_IMAGES_LIST($this->id_campaign)"));
      foreach($imgs as $row){
        $img = array(
                "id"      => $row->id,
                "img_url" => $row->img_url
        );
        array_push($data,$img);
      }
      return $data;
    }
  }
