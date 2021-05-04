<?php

namespace Backpack\Base\app\Http\Middleware;

use Closure;

class CheckIfAdmin
{
	private function checkIfUserIsAdmin($user)
    {
        return ($user->role_id == 1);
    }
	
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (backpack_auth()->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response(trans('backpack::base.unauthorized'), 401);
            } else {
                return redirect()->guest(backpack_url('login'));
            }
        }
		if (!$this->checkIfUserIsAdmin(backpack_user())) {
             return response(trans('backpack::base.unauthorized'), 401);
        }

        return $next($request);
    }
}
