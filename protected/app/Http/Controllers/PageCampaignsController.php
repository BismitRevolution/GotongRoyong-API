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
            ->get();


        return view('admin.campaigns.create')->with('data_users',$data_users);
    }

    public function list_campaign() {
        return view('admin.campaigns.list-campaign');
    }
    public function submit_create(Request $request) {

//        dd($request);

        //start create campaign link
        $title_lower = str_limit(strtolower($request->title),50);
        $title_trf = str_replace(' ', '-',$title_lower);
        $title_trf2 = str_replace('.', '',$title_trf);
        $campaign_link = '/'.$request->campaigner.'/'.$title_trf2;
        //end create campaign link

        $id_campaign = DB::table('campaigns')->insertGetId(
            [
                'title'         => $request->title,
                'id_user'       => $request->campaigner,
                'description'   => $request->description,
                'target_donation' => $request->target,
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


        Session::flash('submit_create_success','Campaign berhasil dibuat dan telah masuk ke database.');
        return redirect()->back();
    }
}
