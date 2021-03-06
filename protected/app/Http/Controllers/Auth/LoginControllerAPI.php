<?php
namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController as UserController;

class LoginControllerAPI extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            // new rules here
        ]);
    }

    public function loginAPI(Request $request)
    {
//        dd('a');

        if($request->input('email') == null){
          return response()->json([
              'status' => 500,
              'success' => false,
              'message' => 'User login failure',
              'data' => 'Please input email'],
              500);
        }
        if($request->input('password') == null){
          return response()->json([
              'status' => 500,
              'success' => false,
              'message' => 'User login failure',
              'data' => 'Please input password'],
              500);
        }

        $this->validateLogin($request);
//        dd($this->attemptLogin($request));
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
//            dd($user);
            $user->generateToken();
            $userdata = $user->toArray();
            $detailuser = (new UserController)->getDetailsWithoutAuth($user);
            $userdata["data_pahlawan"] = $detailuser;
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'User login succesfully',
                'data' => $userdata],
                200);
        }
        //$email = $request->input('email');
        //return response if login failure
        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => 'User login failure',
            'data' => 'User/password wrong'],
            500);
    }

    public function logoutAPI(Request $request)
    {

        $user = Auth::guard('api')->user();
        //$user = $this->guard()->user();
        //$tok = $user->remember_token;
        if ($user) {
            //$user->generateToken();
//            Auth::logout();
            $user->api_token = null;
            $user->save();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'User logout success',
                'data' => 'User logged out'],
                200);
        }
        //return response if logout failure
        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => 'User logout failure',
            'data' => 'Already logged out/Token false'],
            500);
    }

    public function loginFB(Request $request)
    {
        $cekIDFB= User::where('id_fb', $request->input("id_fb"))->first();

        if($cekIDFB != null){

            $user = $cekIDFB;
            $user->generateToken();
            $userdata = $user->toArray();
            $detailuser = (new UserController)->getDetailsWithoutAuth($user);
            $userdata["data_pahlawan"] = $detailuser;
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'User login by FB succesfully',
                'data' => $userdata
            ],
                200);
        }

        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => 'User login failure',
            'data' => 'User data wrong'],
            500);
    }

    public function loginGoogle(Request $request)
    {
        $cekIDGoogle = User::where('id_google', $request->input("id_google"))->first();

        if($cekIDGoogle != null){

            $user = $cekIDGoogle;
            $user->generateToken();
            $userdata = $user->toArray();
            $detailuser = (new UserController)->getDetailsWithoutAuth($user);
            $userdata["data_pahlawan"] = $detailuser;
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'User login by Google succesfully',
                'data' => $userdata
            ],
                200);
        }

        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => 'User login failure',
            'data' => 'User data wrong'],
            500);
    }
}
