<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                'email'         => $request->email,
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

        $flag_verified_save = 0;
        if ($request->flagverified == "verified") {
            $flag_verified_save = 1;
        } else if($request->flagverified == "not") {
            $flag_verified_save = 0;
        }

        DB::table('users_pahlawan')->insert([
            'id_user'           => $id_user,
            'about_me'          => $request->about,
            'my_url'            => $request->link,
            'instagram_link'    => $request->instagram,
            'twitter_link'      => $request->twitter,
            'fb_link'           => $request->facebook,
            'flag_verified'     => $flag_verified_save
        ]);


        Session::flash('submit_create_success','Advertiser berhasil dibuat dan telah masuk ke database.');
        return redirect()->back();
    }

    public function create_content() {
        return view('admin.ads.create-content');
    }

    public function list_ads() {
        return view('admin.ads.list-ads');
    }
}
