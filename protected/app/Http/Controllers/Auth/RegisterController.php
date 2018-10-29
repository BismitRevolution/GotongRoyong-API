<?php

namespace App\Http\Controllers\Auth;

use App\User as User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use DateTime;
use App\Http\Controllers\UserController as UserController;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // $originalDate = $data['birthdate'];
        // $date = new DateTime($originalDate);
        $lastuser = DB::table('users')
            ->orderBy('id', 'desc')
            ->first();

        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'fullname' => $data['fullname'],
            'username' => 'user'.($lastuser->id +1),
            //'birthdate' => $date->format('Y-m-d'),
            //'birthplace' => $data['birthplace'],
            //'gender' => $data['gender'],
            'role' => 1,
            'flag_active' => 1,
        ]);
    }

    public function register(Request $request) 
    {

//      $this->validator($request->all())->validate();



      $cekEmail= User::where('email', $request->input("email"))->get();
      if(count($cekEmail) > 0){
        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => 'Email already exist',
            'data' => ''
          ],500);
      }


      $cekUsername= User::where('username', $request->input("username"))->where('flag_active', 1)->get();
      if(count($cekUsername) > 0){
        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => 'Username already exist',
            'data' => ''
          ],500);
      }


      // Here the request is validated. The validator method is located
      // inside the RegisterController, and makes sure the name, email
      // password and password_confirmation fields are required.

    // Start Send Email Token
//        $dataEmail = array(
//            'name'=>'Luthfi',
//            'newpass'=>'123456'
//        );
//
//        $user = User::where('id',112)->first();
//
//        Mail::send(['html'=>'email.view-verify'],
//            $dataEmail, function($message) use($user) {
//                $message->to('luthviar.b@gmail.com', $user->fullname)->subject
//                ('[GotongRoyong] Informasi Ganti Password');
//                $message->from('luthviar.a@gmail.com','Admin GotongRoyong');
//            });
//
//        return 'Email was sent';
    // End Send Email Token


      // $cekUsername= User::where('username', $request->input("username"))->get();
      // if(count($cekUsername) > 0){
      //   return response()->json([
      //       'success' => false,
      //       'message' => 'Username already exist',
      //       'data' => ''
      //     ],500);
      // }


      // A Registered event is created and will trigger any relevant
      // observers, such as sending a confirmation email or any
      // code that needs to be run as soon as the user is created.
      //event(new Registered($user = $this->create($request->all())));
      //

//        dd(count($request->all()) = 5);
//        dd((
//            (count($request->all()) == 5) &&
//            ($request->email != null ||
//                $request->password != null ||
//                $request->password_confirmation != null ||
//                $request->username != null ||
//                $request->fullname != null)
//        ));

        if (
                (count($request->all()) == 4) &&
                ($request->email != null ||
                $request->password != null ||
                $request->password_confirmation != null ||
                $request->fullname != null)
        ) {
            $user = $this->create($request->all());
            //return response()->json(['data' => $user->toArray()], 201);

            $this->guard()->login($user);
        } else {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'All field should not empty',
                'data' => ''
            ],500);
        }
      // And finally this is the hook that we want. If there is no
      // registered() method or it returns null, redirect him to
      // some other URL. In our case, we just need to implement
      // that method to return the correct response.
      return $this->registered($request, $user);
      //?:redirect($this->redirectPath());
  }

  public function createByFB(array $data){
      // $originalDate = $data['birthdate'];
      // $date = new DateTime($originalDate);

      return User::create(
          [
              'username'      => "yourusername",
              'email'         => $data['email'],
              'id_fb'         => $data['id_fb'],
              'fullname'      => $data['fullname'],
              'role'          => 1,
              'birthdate'     => $data['birthdate'],
              'birthplace'    => $data['birthplace'],
              'gender'        => $data['gender'],
              'image_profile' => $data['image_profile'],
              'flag_active'   => 1,
              'created_at'    => Carbon::now(),
              'updated_at'    => Carbon::now()
          ]);
  }

  public function registerByFB(Request $request) {
      $cekEmail= User::where('email', $request->input("email"))->get();
      if(count($cekEmail) > 0) {
          return response()->json([
              'success' => false,
              'message' => 'Email already exist',
              'data' => ''
          ], 500);
      }

      $cekIDFB= User::where('id_fb', $request->input("id_fb"))->get();
      if(count($cekIDFB) > 0){
          return response()->json([
              'success' => false,
              'message' => 'ID FB already exist',
              'data' => ''
          ],500);
      }

      $user = $this->createByFB($request->all());

      $this->guard()->login($user);

      // And finally this is the hook that we want. If there is no
      // registered() method or it returns null, redirect him to
      // some other URL. In our case, we just need to implement
      // that method to return the correct response.
      return $this->registered($request, $user);
  }

    public function createByGoogle(array $data){
        // $originalDate = $data['birthdate'];
        // $date = new DateTime($originalDate);

        return User::create(
            [
                'username'      => "yourusername",
                'email'         => $data['email'],
                'id_google'         => $data['id_google'],
                'fullname'      => $data['fullname'],
                'role'          => 1,
                'birthdate'     => $data['birthdate'],
                'birthplace'    => $data['birthplace'],
                'gender'        => $data['gender'],
                'image_profile' => $data['image_profile'],
                'flag_active'   => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
    }

    public function registerByGoogle(Request $request) {
        $cekEmail= User::where('email', $request->input("email"))->get();
        if(count($cekEmail) > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Email already exist',
                'data' => ''
            ], 500);
        }

        $cekIDGoogle = User::where('id_google', $request->input("id_google"))->get();
        if(count($cekIDGoogle) > 0){
            return response()->json([
                'success' => false,
                'message' => 'ID Google already exist',
                'data' => ''
            ],500);
        }

        $user = $this->createByGoogle($request->all());

        $this->guard()->login($user);

        // And finally this is the hook that we want. If there is no
        // registered() method or it returns null, redirect him to
        // some other URL. In our case, we just need to implement
        // that method to return the correct response.
        return $this->registered($request, $user);
    }

  protected function registered(Request $request, $user)
  {
      $user->generateToken();
      return (new UserController())->createPahlawan($request,$user);

      //return response if successfully registered
      // return response()->json([
      //   'success' => true,
      //   'message' => 'User created succesfully',
      //   'data' => $user->toArray()]
      //   ,201);
  }

}
