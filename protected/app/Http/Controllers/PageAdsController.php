<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PageAdsController extends Controller
{
    public function create_advertiser() {
        return view('admin.ads.create-advertiser');
    }

    public function submit_advertiser(Request $request) {

        $destinationPath = 'Uploads/advertiser-photo-profile/'.Carbon::now()->timestamp;

        $moves = $request->file('photo')
            ->move($destinationPath,
                $request->file('photo')
                    ->getClientOriginalName());
        $url_file = "Uploads/advertiser-photo-profile/".Carbon::now()->timestamp."/{$request->file('photo')->getClientOriginalName()}";


        $role_save = 0;
        if ($request->role == "advertiser") {
            $role_save = 3;
        }


        $id_user = DB::table('users')->insertGetId(
            [
                'username'      => $request->username,
                'email'         => $request->email_pic,
                'password'      => bcrypt($request->password),
                'fullname'      => $request->fullname,
                'role'          => $role_save,
                'birthdate'     => $request->birthdate,
                'birthplace'    => $request->birthplace,
                'gender'        => $request->gender,
                'flag_active'   => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
                'image_profile' => $url_file,


            ]
        );

        $desc_trf1 = str_replace('’',"'",$request->advertiser_desc);
        $desc_trf = str_replace('"',"'",$desc_trf1);

        DB::table('advertisers')->insert([
            'id_user'           => $id_user,
            'advertiser_name'   => $request->advertiser_name,
            'advertiser_desc'   => $desc_trf,
            'no_hp'             => $request->no_hp,
            'email'             => $request->email_ads,
            'kuota_ads'         => $request->kuota
        ]);


        Session::flash('submit_create_success','Advertiser berhasil dibuat dan telah masuk ke database.');
        return redirect()->back();
    }

    public function create_content() {
        $data_advertisers = DB::table('advertisers')->get();

        return view('admin.ads.create-content')
            ->with('data_advertisers',$data_advertisers);
    }

    public function submit_content(Request $request) {

        $destContent = 'Uploads/ads-content/'.$request->id_advertiser.'/'.Carbon::now()->timestamp;
        $destBG = 'Uploads/ads-bg-img/'.$request->id_advertiser.'/'.Carbon::now()->timestamp;
        $destLogo = 'Uploads/ads-logo/'.$request->id_advertiser.'/'.Carbon::now()->timestamp;

        $movesContent = $request->file('ads_content')
            ->move($destContent,
                $request->file('ads_content')
                    ->getClientOriginalName());

        $movesBG = $request->file('bg_img')
            ->move($destBG,
                $request->file('bg_img')
                    ->getClientOriginalName());

        $movesLogo = $request->file('logo_ads')
            ->move($destLogo,
                $request->file('logo_ads')
                    ->getClientOriginalName());


        $content_url = "Uploads/ads-content/".$request->id_advertiser.'/'.Carbon::now()->timestamp."/{$request->file('ads_content')->getClientOriginalName()}";

        $bg_img_url = "Uploads/ads-bg-img/".$request->id_advertiser.'/'.Carbon::now()->timestamp."/{$request->file('bg_img')->getClientOriginalName()}";

        $logo_url = "Uploads/ads-logo/".$request->id_advertiser.'/'.Carbon::now()->timestamp."/{$request->file('logo_ads')->getClientOriginalName()}";

        $desc_trf1 = str_replace('’',"'",$request->description);
        $desc_trf = str_replace('"',"'",$desc_trf1);

        $id_ads_content = DB::table('ads_contents')->insertGetId(
            [
                'id_advertiser' => $request->id_advertiser,
                'target_url'    => $request->target_url,
                'content_url'   => $content_url,
                'ads_category'  => $request->category,
                'description'   => $desc_trf,
                'bg_img_url'    => $bg_img_url,
                'title_content' => $request->title_ads,
                'logo_url'      => $logo_url,
                'duration'      => $request->duration,
                'flag_active'   => 1,
                'created_at'    => Carbon::now()

            ]
        );


        Session::flash('submit_create_success',
            'Ads Content berhasil dibuat dan telah masuk ke database.');
        return redirect()->back();
    }

    public function list_ads() {


        $data_ads_contents = DB::table('ads_contents')
            ->join('advertisers', 'ads_contents.id_advertiser', '=', 'advertisers.id')
            ->select('ads_contents.*', 'advertisers.*','ads_contents.id as id_ads_contents')
            ->where('ads_contents.flag_active','=',1)
            ->orderBy('created_at','desc')
            ->get();

//        dd($data_ads_contents);
        return view('admin.ads.list-ads')
            ->with('data_ads_contents',$data_ads_contents);
    }

    public function edit_content($id_ads_content) {


        $data_ads_contents = DB::table('ads_contents')
            ->join('advertisers', 'ads_contents.id_advertiser', '=', 'advertisers.id')
            ->select('ads_contents.*', 'advertisers.*',
                'ads_contents.id as id_ads_contents',
                'advertisers.id as id_advertiser')
            ->where('ads_contents.flag_active','=',1)
            ->where('ads_contents.id','=',$id_ads_content)
            ->first();



        $data_advertisers = DB::table('advertisers')
            ->where('advertisers.id','<>',$data_ads_contents->id_advertiser)
            ->get();


        return view('admin.ads.edit-content')
            ->with('data_advertisers',$data_advertisers)
            ->with('data_ads_contents',$data_ads_contents);
    }

    public function update_content(Request $request) {

        //start file ads content
        if (!is_null($request->file('ads_content'))) {
            $destContent = 'Uploads/ads-content/'.$request->id_advertiser.'/'.Carbon::now()->timestamp;

            $movesContent = $request->file('ads_content')
                ->move($destContent,
                    $request->file('ads_content')
                        ->getClientOriginalName());

            $content_url = "Uploads/ads-content/".$request->id_advertiser.'/'.Carbon::now()->timestamp."/{$request->file('ads_content')->getClientOriginalName()}";

            $data_content = DB::table('ads_contents')
                ->where('ads_contents.id','=',$request->id_ads_contents)
                ->update([
                    'ads_contents.updated_at'    => Carbon::now(),
                    'ads_contents.content_url'   => $content_url
                ]);
        }
        //end file ads content

        //start file bg image ads content
        if (!is_null($request->file('bg_img'))) {
            $destBG = 'Uploads/ads-bg-img/'.$request->id_advertiser.'/'.Carbon::now()->timestamp;

            $movesBG = $request->file('bg_img')
                ->move($destBG,
                    $request->file('bg_img')
                        ->getClientOriginalName());

            $bg_img_url = "Uploads/ads-bg-img/".$request->id_advertiser.'/'.Carbon::now()->timestamp."/{$request->file('bg_img')->getClientOriginalName()}";

            $data_bg_img = DB::table('ads_contents')
                ->where('ads_contents.id','=',$request->id_ads_contents)
                ->update([
                    'ads_contents.updated_at'    => Carbon::now(),
                    'ads_contents.bg_img_url'   => $bg_img_url
                ]);
        }
        //end file bg image ads content

        //start file logo ads content
        if (!is_null($request->file('logo_ads'))) {
            $destLogo = 'Uploads/ads-logo/'.$request->id_advertiser.'/'.Carbon::now()->timestamp;

            $movesLogo = $request->file('logo_ads')
                ->move($destLogo,
                    $request->file('logo_ads')
                        ->getClientOriginalName());

            $logo_url = "Uploads/ads-logo/".$request->id_advertiser.'/'.Carbon::now()->timestamp."/{$request->file('logo_ads')->getClientOriginalName()}";

            $data_logo = DB::table('ads_contents')
                ->where('ads_contents.id','=',$request->id_ads_contents)
                ->update([
                    'ads_contents.updated_at'    => Carbon::now(),
                    'ads_contents.logo_url'   => $logo_url
                ]);
        }
        //end file logo ads content

        $desc_trf3 = str_replace('”',"'",$request->description);
        $desc_trf2 = str_replace('“',"'",$desc_trf3);
        $desc_trf1 = str_replace('’',"'",$desc_trf2);
        $desc_trf = str_replace('"',"'",$desc_trf1);

        $data_ads_content = DB::table('ads_contents')
            ->where('ads_contents.id','=',$request->id_ads_contents)
            ->update([
                'ads_contents.updated_at'       => Carbon::now(),
                'ads_contents.id_advertiser'    => $request->id_advertiser,
                'ads_contents.title_content'    => $request->title_ads,
                'ads_contents.ads_category'     => $request->category,
                'ads_contents.target_url'       => $request->target_url,
                'ads_contents.description'      => $desc_trf,
                'ads_contents.duration'         => $request->duration,
            ]);

        $data_ads_content_success = DB::table('advertisers')->where('id',$request->id_advertiser)->first();
        Session::flash("submit_update_success","Content Ads milik $data_ads_content_success->advertiser_name berhasil di-update dan telah masuk ke database.");
        return redirect(url(action('PageAdsController@list_ads')));
    }
}
