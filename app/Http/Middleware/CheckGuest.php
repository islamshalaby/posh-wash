<?php

namespace App\Http\Middleware;
use App\Helpers\APIHelpers;

use Closure;

class CheckGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()){
            if (auth()->user()->active == 0) {
                $response = APIHelpers::createApiResponse(true , 401 ,  'user is not active', 'تم تعطيل هذا المستخدم', null,$request->lang );
                return response()->json($response , 401);
            }
            return $next($request);
        }else{
            $gusetkey = $request->header('Authorization');
            if($gusetkey == '$2y$12$ZtgKLOyfvyXH33JE67Ei0kqupt771t62d21M4wOJumBmsZ1bexxpCPiuhfdRKODMC'){
                return $next($request);
            }
            $response = APIHelpers::createApiResponse(true , 401 ,  'Guest token wrong', 'توكن زائر خاطيء', null,$request->lang );
            return response()->json($response , 401);
        }
    }
}
