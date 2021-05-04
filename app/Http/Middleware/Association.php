<?php

namespace App\Http\Middleware;

use Closure;

class Association
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

	                        return $next($request);
	    /*if( auth("associations")->check() ){
		    
		    return $next($request);
	    
	    }else{
			  auth("associations")->logout();

		    redirect("/loginAssociation");


	    }*/
    }
}
