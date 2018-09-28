<?php

namespace App\Http\Controllers\Test;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{

  public function test(Request $request)
  {
      //$user = Auth::guard('api')->user();

      return response()->json([
        'success' => true,
        'message' => 'test success',
        'data' => 'test success'],
        500);
  }

  public function details(Request $request)
  {
      $user = Auth::guard('api')->user();
      if ($user) {
        return response()->json([
          'success' => true,
          'message' => 'User detail',
          'data' => $user->toArray(),
        ],200);
      }

      return response()->json([
        'success' => false,
        'message' => 'User logout failure',
        'data' => 'Already logged out/Token false'],
        500);
  }


}
