<?php

namespace App\Http\Controllers\AdsContent;

use App\Http\Controllers\Controller,
  Illuminate\Support\Facades\DB as DB,
  App\User,
  Illuminate\Http\Request;

  class AdsContentList extends Controller
  {

    public $id;
    public $id_advertiser;
    public $target_url;
    public $content_url;
    public $ads_category;
    public $description;
    public $bg_img_url;
    public $title_content;
    public $logo_url;
    public $duration;
    public $flag_active;
    public $created_at;
    public $exist;

    public function __construct($id = false)
    {
      if($id){
        $item = DB::table('ads_contents')
          ->where('id', $id)
          ->first();
          if($item){
              $this->id               = $item->id;
              $this->id_advertiser    = $item->id_advertiser;
              $this->target_url       = $item->target_url;
              $this->content_url      = $item->content_url;
              $this->ads_category     = $item->ads_category;
              $this->description      = $item->description;
              $this->bg_img_url       = $item->bg_img_url;
              $this->title_content    = $item->title_content;
              $this->logo_url         = $item->logo_url;
              $this->created_at       = $item->created_at;
              $this->duration         = $item->duration;
              $this->flag_active      = $item->flag_active;
              $this->exist            = true;
          }
          else{
              $this->exist    = false;
          }
    }
      else{

      }
    }

    public function adsRandom($id_user)
    {
      $data = array();
      $ads = DB::select(DB::raw("CALL ADS_CONTENTS_RANDOM($id_user)"));
      foreach($ads as $item){
        $content = array(
                "id"      => $item->id,
                "id_advertiser"  => $item->id_advertiser,
                "advertiser_name"  => $item->advertiser_name,
                "advertiser_desc"  => $item->advertiser_desc,
                "advertiser_no_hp"  => $item->no_hp,
                "advertiser_logo"  => $item->advertiser_logo,
                "advertiser_email"  => $item->email,
                "target_url" => $item->target_url,
                "content_url" => $item->content_url,
                "ads_category" => $item->ads_category,
                "description" => $item->description,
                "bg_img_url" => $item->bg_img_url,
                "title_content" => $item->title_content,
                "logo_url" => $item->logo_url,
                "flag_active" => $item->flag_active,
                "duration" => $item->duration,
                "created_at" => $item->created_at
        );
        $data = $content;
      }
      return $data;
    }
  }
