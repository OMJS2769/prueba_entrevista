<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {

            $now = Carbon::now();

            $api_token = $user->email.$now.Str::random(200,500);
            $user->api_token = sha1($api_token);
            $user->last_session = $now;
            $user->save();

            return json_encode([
                'status' => 'success',
                'message' => 'success login',
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'api_token' => $user->api_token,
                'last_session' => $user->last_session
            ]);
        }else{
            return json_encode([
                'status' => 'error',
                'message' => 'wrong credentials'
            ]);
        }
    }
}
