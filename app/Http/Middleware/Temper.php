<?php

namespace App\Http\Middleware;

use App\Exceptions\NotAllowedException;
use App\Exceptions\NotLoginException;
use Closure;
use Psy\Exception\ThrowUpException;

class Temper
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

//            fixme throw proper exceptions
        if(auth()->check()){
            if(in_array(auth()->user()->email,config('temper'))){
                return $next($request);
            }else{
                Throw new NotAllowedException();
            }
        }else{
            Throw new NotLoginException();
        }

    }
}
