<?php

namespace App\Http\Controllers;
use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\Http\Controllers\LogUsers\LogUsersList as LogUsers;


class LogUsersController extends Controller
{
    public function createLog(Request $request)
    {
      $user = Auth::guard('api')->user();
      if($user){
        $log = new LogUsers();
        $log->id_user = $user->id;
        $log->from_page = $request->input("from_page");
        $log->to_page = $request->input("to_page");
        $log->device = $request->input("device");

        $log->create();

        return response()->json([
          'status' => 201,
          'success' => true,
          'message' => 'Log user created successfully',
          'data' => '',
        ],201);
      }

      return response()->json([
        'status' => 500,
        'success' => true,
        'message' => 'Please Login first',
        'data' => 'User logged out',
      ],500);

    }
}
