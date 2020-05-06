<?php

namespace App\Http\Middleware;

use Closure;

class SetLang
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
        if(request()->getHost() == 'bandaihobbytw.com'){
            echo "<script>location.href='http://bandaihobby.tw'</script>";
        }
        if(!session('lang')) session(['lang'=>'CH']);
        return $next($request);
    }
}
