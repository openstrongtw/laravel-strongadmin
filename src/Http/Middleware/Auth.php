<?php

namespace OpenStrong\StrongAdmin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use OpenStrong\StrongAdmin\Repositories\AppRepository;

/**
 * 登錄認證檢測
 */
class Auth
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
        if (in_array(Route::current()->uri, $this->getIgnoreUrl()))
        {
            return $next($request);
        }

        if (!auth()->guard(config('strongadmin.guard'))->check())
        {
            if (AppRepository::isWeb())
            {
                return redirect(route('strongadmin.login'));
            } else
            {
                return response()->json(['code' => 401, 'msg' => '請登錄']);
            }
        }
        if (AppRepository::isApi())
        {
            $user = auth(config('strongadmin.guard'))->user();
            if ($user->api_token_at && now()->gte($user->api_token_at))
            {
                return response()->json(['code' => 431, 'message' => __('token expired 已過期')]);
            }
            if ($user->api_token_refresh_at && now()->gte($user->api_token_refresh_at))
            {
                //return response()->json(['code' => 432, 'message' => __('token must be refreshed 請重新整理token')]);
            }
        }
        return $next($request);
    }

    protected function getIgnoreUrl()
    {
        return config('strongadmin.ignore_auth_check_url');
    }

}
