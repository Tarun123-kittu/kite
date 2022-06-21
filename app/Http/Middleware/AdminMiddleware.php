<?php
namespace App\Http\Middleware;

use App\Helpers\Helpers;
use App\Http\Controllers\AuthAdmin;
use Closure;

class AdminMiddleware
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

        if (!AuthAdmin::isLoggedIn()) {
            return Helpers::response(['ajax' => $request->ajax(), 'status' => 'error', 'message' => "You Need To Login First To Perform This Action"],'show.login',401);
        } else {
            
            $check = AuthAdmin::check();
            if (!$check) {
                AuthAdmin::logout();
                return Helpers::response(['ajax' => $request->ajax(), 'status' => 'error', 'message' => "Unauthorized"],'show.login',401);
            }
            AuthAdmin::redo($check);
            view()->share('AdminUser',AuthAdmin::user());
        }
        return $next($request);
    }
}
