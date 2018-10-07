<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PageUserNGOController extends Controller
{
    public function create() {
        return view('admin.user-ngo-verified.create');
    }

    public function submit_create(Request $request) {

        $destinationPath = 'Uploads/user-photo-profile/'.Carbon::now()->timestamp;

        $moves = $request->file('photo')
            ->move($destinationPath,
                $request->file('photo')
                    ->getClientOriginalName());
        $url_file = "Uploads/user-photo-profile/".Carbon::now()->timestamp."/{$request->file('photo')->getClientOriginalName()}";


        $role_save = 0;
        if ($request->role == "userpahlawan") {
            $role_save = 1;
        } else if ($request->role == "admin") {
            $role_save = 2;
        } else if ($request->role == "advertiser") {
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

//        $about_trf = str_replace('"',"'",$request->about);
        $about_trf1 = str_replace('’',"'",$request->about);
        $about_trf = str_replace('"',"'",$about_trf1);

        DB::table('users_pahlawan')->insert([
            'id_user'           => $id_user,
            'about_me'          => $about_trf,
            'my_url'            => $request->link,
            'instagram_link'    => $request->instagram,
            'twitter_link'      => $request->twitter,
            'fb_link'           => $request->facebook,
            'flag_verified'     => $flag_verified_save
        ]);


        Session::flash('submit_create_success','User Pahlawan (NGO User) berhasil dibuat dan telah masuk ke database.');
        return redirect()->back();
    }

    public function list_user() {
        $data_users = DB::table('users')
            ->join('users_pahlawan', 'users.id', '=', 'users_pahlawan.id_user')
            ->select('users.*', 'users_pahlawan.*')
            ->where('users.flag_active','=',1)
            ->where('users_pahlawan.flag_verified','=',1)
            ->orderBy('created_at','desc')
            ->get();

        return view('admin.user-ngo-verified.list-user')
            ->with('data_users',$data_users);
    }

    public function edit($id_user) {

        $data_user = DB::table('users')
            ->join('users_pahlawan', 'users.id', '=', 'users_pahlawan.id_user')
            ->select('users.*', 'users_pahlawan.*')
            ->where('users.flag_active','=',1)
            ->where('users_pahlawan.flag_verified','=',1)
            ->where('users.id','=',$id_user)
            ->first();



        return view('admin.user-ngo-verified.edit')
            ->with('data_user',$data_user);
    }

    public function update(Request $request) {


        if (!is_null($request->file('photo'))) {
            $destinationPath = 'Uploads/user-photo-profile/'.Carbon::now()->timestamp;

            $moves = $request->file('photo')
                ->move($destinationPath,
                    $request->file('photo')
                        ->getClientOriginalName());
            $url_file = "Uploads/user-photo-profile/".Carbon::now()->timestamp."/{$request->file('photo')->getClientOriginalName()}";

            $data_user = DB::table('users')
                ->join('users_pahlawan', 'users.id', '=', 'users_pahlawan.id_user')
                ->select('users.*', 'users_pahlawan.*')
                ->where('users_pahlawan.flag_verified','=',1)
                ->where('users.id','=',$request->id_user)
                ->update([
                    'users.updated_at'    => Carbon::now(),
                    'users.image_profile' => $url_file
                ]);


        }


        if(!is_null($request->password)) {
            $data_user = DB::table('users')
                ->join('users_pahlawan', 'users.id', '=', 'users_pahlawan.id_user')
                ->select('users.*', 'users_pahlawan.*')
                ->where('users_pahlawan.flag_verified','=',1)
                ->where('users.id','=',$request->id_user)
                ->update([
                    'users.updated_at'    => Carbon::now(),
                    'users.password'      => bcrypt($request->password)
                ]);
        }


        $role_save = 0;
        if ($request->role == "userpahlawan") {
            $role_save = 1;
        } else if ($request->role == "admin") {
            $role_save = 2;
        } else if ($request->role == "advertiser") {
            $role_save = 3;
        }

        $flag_verified_save = 0;
        if ($request->flagverified == "verified") {
            $flag_verified_save = 1;
        } else if($request->flagverified == "not") {
            $flag_verified_save = 0;
        }

        $about_trf1 = str_replace('’',"'",$request->about);
        $about_trf = str_replace('"',"'",$about_trf1);

//        dd($request);
        $data_user = DB::table('users')
            ->where('users.id','=',$request->id_user)
            ->update([
                'users.username'      => $request->username,
                'users.email'         => $request->email,
                'users.fullname'      => $request->fullname,
                'users.role'          => $role_save,
                'users.birthdate'     => $request->birthdate,
                'users.birthplace'    => $request->birthplace,
                'users.gender'        => $request->gender,
                'users.flag_active'   => 1,
                'users.updated_at'    => Carbon::now(),
            ]);

        $data_user_pahlawan = DB::table('users_pahlawan')
            ->where('users_pahlawan.id_user','=',$request->id_user)
            ->update([
                'users_pahlawan.id_user'           => $request->id_user,
                'users_pahlawan.about_me'          => $about_trf,
                'users_pahlawan.my_url'            => $request->link,
                'users_pahlawan.instagram_link'    => $request->instagram,
                'users_pahlawan.twitter_link'      => $request->twitter,
                'users_pahlawan.fb_link'           => $request->facebook,
                'users_pahlawan.flag_verified'     => $flag_verified_save
            ]);

//        dd($request);
        $data_user_success = DB::table('users')
            ->join('users_pahlawan', 'users.id', '=', 'users_pahlawan.id_user')
            ->select('users.*', 'users_pahlawan.*')
            ->where('users.id','=',$request->id_user)
            ->first();


        Session::flash("submit_update_success","User Pahlawan (NGO User) bernama $data_user_success->fullname berhasil di-update dan telah masuk ke database.");


        return redirect(url(action('PageUserNGOController@list_user')));
    }

    public function delete_user(Request $request) {

        DB::table('users')
            ->where('users.id','=',$request->id_user)
            ->update([
                'flag_active'   => 0,
                'updated_at'    => Carbon::now()
            ]);

        $data_users_success = DB::table('users')
            ->where('id',$request->id_user)->first();

        Session::flash("submit_delete_success","User bernama: $data_users_success->fullname . Berhasil di-hapus.");
        return redirect(url(action('PageUserNGOController@list_user')));
    }
}
