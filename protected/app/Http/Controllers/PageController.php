<?php

namespace App\Http\Controllers;

use App\Mail\SendMailable;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;

class PageController extends Controller
{
    public function checkLoginRole(Request $request) {
        if($request->username == 'superadmin') {
            return redirect('super-admin/dashboard');
        } else if($request->username == 'admin') {
            return redirect('admin/dashboard');
        }

        Session::flash('gagal','Gagal Login');
        return redirect('/');
    }

    public function mail() {

//        dd('a');


        $user = User::where('id',112)->first();

        for ($i=0;$i<1000;$i++) {
            $dataEmail = array(
                'name'=>'Luthfi',
                'newpass'=>'123456'.$i
            );
            Mail::send(['html'=>'email.view-verify'],
                $dataEmail, function($message) use($user) {
                    $message->to('luthviar.a@gmail.com', $user->fullname)->subject
                    ('[GotongRoyong] Informasi Ganti Password');
                    $message->from('support@gotongroyong.in','Admin GotongRoyong');
                });
        }

        return 'Email was sent';
    }
}
