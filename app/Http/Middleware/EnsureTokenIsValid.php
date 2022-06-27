<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->api_token)
        {
            $user = User::where('api_token',$request->api_token)->first();
            if($user)
            {
                $last_session = new \Carbon\Carbon($user->last_session);
                $now = new \Carbon\Carbon(date('Y-m-d H:i:s'));
                $diff=$last_session->diffInMinutes($now);
                if($diff <= env('SESSION_LIFETIME',120))
                {
                    return $next($request);
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'expired token.'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'invalid token.'
                ]);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'token not found.'
            ]);
        }

        return $next($request);
    }
}
