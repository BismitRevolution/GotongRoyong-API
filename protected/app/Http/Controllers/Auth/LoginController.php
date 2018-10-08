<?php
namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController as UserController;

class LoginController extends Controller
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
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('admin/dashboard');
        }

        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();
            $userdata = $user->toArray();
            $detailuser = (new UserController)->getDetailsWithoutAuth($user);
            $userdata["data_pahlawan"] = $detailuser;
            return redirect('admin/dashboard')->with('response',
                response()->json([
                    'success' => true,
                    'message' => 'User login succesfully',
                    'data' => $userdata],
                    200)
                );
        }
        //$email = $request->input('email');
        //return response if login failure
        return response()->json([
            'success' => false,
            'message' => 'User login failure',
            'data' => 'User/password wrong'],
            500);
    }
    public function loginAPI(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();
            $userdata = $user->toArray();
            $detailuser = (new UserController)->getDetailsWithoutAuth($user);
            $userdata["data_pahlawan"] = $detailuser;
            return response()->json([
                'success' => true,
                'message' => 'User login succesfully',
                'data' => $userdata],
                200);
        }
        //$email = $request->input('email');
        //return response if login failure
        return response()->json([
            'success' => false,
            'message' => 'User login failure',
            'data' => 'User/password wrong'],
            500);
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

    public function logoutAPI(Request $request)
    {
        $user = Auth::guard('api')->user();
        //$user = $this->guard()->user();
        //$tok = $user->remember_token;
        if ($user) {
            //$user->generateToken();
            $user->api_token = null;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'User logout success',
                'data' => 'User logged out'],
                200);
        }
        //return response if logout failure
        return response()->json([
            'success' => false,
            'message' => 'User logout failure',
            'data' => 'Already logged out/Token false'],
            500);
    }
}