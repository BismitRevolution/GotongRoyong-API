<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PageCampaignsController extends Controller
{
    public function create() {
        $data_users = DB::table('users')
            ->join('users_pahlawan', 'users.id', '=', 'users_pahlawan.id_user')
            ->select('users.*', 'users_pahlawan.*')
            ->where('users_pahlawan.flag_verified','=',1)
            ->where('users.flag_active','=',1)
            ->get();


        return view('admin.campaigns.create')->with('data_users',$data_users);
    }

    public function edit_campaign($id_campaign) {
        $data_users = DB::table('users')
            ->join('users_pahlawan', 'users.id', '=', 'users_pahlawan.id_user')
            ->join('campaigns', 'users.id', '=', 'campaigns.id_user')
            ->select('users.*', 'users_pahlawan.*','campaigns.id as id_campaign')
            ->where('users_pahlawan.flag_verified','=',1)
            ->where('users.flag_active','=',1)
            ->where('campaigns.id','<>',$id_campaign)
            ->get();

        $data_campaign = DB::table('campaigns')
            ->join('users', 'users.id', '=', 'campaigns.id_user')
            ->select('campaigns.*','users.fullname','users.image_profile','campaigns.id as id_campaign','users.id as id_user')
            ->where('campaigns.flag_active','=',1)
            ->where('campaigns.id','=',$id_campaign)
            ->first();

        $data_campaign_images = DB::table('campaign_images')
            ->select('campaign_images.*')
            ->where('campaign_images.id_campaign','=',$id_campaign)
            ->get();

        return view('admin.campaigns.edit')
            ->with('data_users',$data_users)
            ->with('data_campaign',$data_campaign)
            ->with('data_campaign_images',$data_campaign_images);
    }

    public function list_campaign() {

        $data_campaigns = DB::table('campaigns')
            ->join('users', 'users.id', '=', 'campaigns.id_user')
            ->select('campaigns.*','users.fullname','users.image_profile','campaigns.id as id_campaign')
            ->where('campaigns.flag_active','=',1)
            ->orderBy('created_at', 'desc')
            ->get();

        $data_campaign_images = DB::table('campaign_images')
            ->join('campaigns', 'campaigns.id', '=', 'campaign_images.id_campaign')
            ->select('campaign_images.*','campaigns.*')
            ->where('campaigns.flag_active','=',1)
            ->get();

        return view('admin.campaigns.list-campaign')
            ->with('data_campaigns', $data_campaigns)
            ->with('data_campaign_images', $data_campaign_images);
    }
    public function submit_create(Request $request) {

//        dd($request);

        //start create campaign link
        $title_lower = str_limit(strtolower($request->title),50);
        $title_trf = str_replace(' ', '-',$title_lower);
        $title_trf2 = str_replace('.', '',$title_trf);
        $campaign_link = '/'.$request->campaigner.'/'.$title_trf2;
        //end create campaign link

        $target_donation = str_replace('.','',$request->target);



        $desc_trf3 = str_replace('”',"'",$request->description);
        $desc_trf2 = str_replace('“',"'",$desc_trf3);
        $desc_trf1 = str_replace('’',"'",$desc_trf2);
        $desc_trf = str_replace('"',"'",$desc_trf1);


        $id_campaign = DB::table('campaigns')->insertGetId(
            [
                'title'         => $request->title,
                'id_user'       => $request->campaigner,
                'description'   => $desc_trf,
                'target_donation' => $target_donation,
                'deadline'      => $request->deadline,
                'complete_sts'  => 1,
                'flag_active'   => 1,
                'campaign_link' => $campaign_link,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
                'created_by'    => 1,
                'updated_by'    => 1

            ]
        );

        if (!is_null($request->file('photo'))) {
            for ($i=0;$i<count($request->file('photo'));$i++) {
                if (!is_null($request->file('photo')[$i])) {

                    //start save campaign images
        $destinationPath = 'Uploads/campaign-images/'.$request->campaigner.
            '/'.Carbon::now()->timestamp;

        $moves = $request->file('photo')[$i]
            ->move($destinationPath,
                $request->file('photo')[$i]
                    ->getClientOriginalName());
        $url_file = "Uploads/campaign-images/".$request->campaigner.
            "/".Carbon::now()->timestamp.
            "/{$request->file('photo')[$i]->getClientOriginalName()}";

        DB::table('campaign_images')->insert([
            'id_campaign'       => $id_campaign,
            'img_url'           => $url_file
        ]);
                    //end of save campaign images

                }
                //end if
            }
            //end for
        }
        //end if

        DB::table('users_pahlawan')
            ->where('users_pahlawan.id_user', $request->campaigner)
            ->update([
                'count_campaign_owned'=> DB::raw('count_campaign_owned+1')
            ]);

        Session::flash('submit_create_success','Campaign berhasil dibuat dan telah masuk ke database.');
        return redirect()->back();
    }

    public function delete_campaign(Request $request) {
//        dd($request);
        DB::table('campaigns')
            ->where('campaigns.id','=',$request->id_campaign)
            ->update([
                'flag_active'   => 0,
                'updated_at'    => Carbon::now(),
                'updated_by'    => 1
            ]);

        DB::table('users_pahlawan')
            ->where('users_pahlawan.id_user', $request->id_user)
            ->update([
                'count_campaign_owned'=> DB::raw('count_campaign_owned-1')
            ]);

        $data_campaign_success = DB::table('campaigns')
            ->where('id',$request->id_campaign)->first();

        Session::flash("submit_delete_success","Campaign berjudul: $data_campaign_success->title . Berhasil di-hapus.");
        return redirect(url(action('PageCampaignsController@list_campaign')));
    }

    public function update_campaign(Request $request){

        if (!is_null($request->file('photo'))) {
            for ($i=0;$i<count($request->file('photo'));$i++) {
                if (!is_null($request->file('photo')[$i])) {
                    //start save campaign images
                    $destinationPath = 'Uploads/campaign-images/'.$request->campaigner.
                        '/'.Carbon::now()->timestamp.'/'.$i;
                    $moves = $request->file('photo')[$i]
                        ->move($destinationPath,
                            $request->file('photo')[$i]
                                ->getClientOriginalName());
                    $url_file = "Uploads/campaign-images/".$request->campaigner.
                        "/".Carbon::now()->timestamp.'/'.$i.
                        "/{$request->file('photo')[$i]->getClientOriginalName()}";
                    DB::table('campaign_images')->insert([
                        'id_campaign'       => $request->id_campaign,
                        'img_url'           => $url_file
                    ]);
                    //end of save campaign images
                }
                //end if
            }
            //end for
        }
        //end if
        $target_donation = str_replace('.','',$request->target);
        //start create campaign link
        $title_lower = str_limit(strtolower($request->title),50);
        $title_trf = str_replace(' ', '-',$title_lower);
        $title_trf2 = str_replace('.', '',$title_trf);
        $campaign_link = '/'.$request->campaigner.'/'.$title_trf2;
        //end create campaign link
        $desc_trf3 = str_replace('”',"'",$request->description);
        $desc_trf2 = str_replace('“',"'",$desc_trf3);
        $desc_trf1 = str_replace('’',"'",$desc_trf2);
        $desc_trf = str_replace('"',"'",$desc_trf1);
        $data_campaign = DB::table('campaigns')
            ->where('campaigns.id','=',$request->id_campaign)
            ->update([
                'title'         => $request->title,
                'id_user'       => $request->campaigner,
                'description'   => $desc_trf,
                'target_donation' => $target_donation,
                'deadline'      => $request->deadline,
                'complete_sts'  => 1,
                'flag_active'   => 1,
                'campaign_link' => $campaign_link,
                'updated_at'    => Carbon::now(),
                'updated_by'    => 1
            ]);

        $data_campaign_success = DB::table('campaigns')
            ->where('id',$request->id_campaign)->first();

        Session::flash("submit_update_success","Campaign berjudul $data_campaign_success->title . Berhasil di-update dan telah masuk ke database.");
        return redirect(url(action('PageCampaignsController@list_campaign')));


    }
}
