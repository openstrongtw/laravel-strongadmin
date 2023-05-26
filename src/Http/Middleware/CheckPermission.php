<?php

namespace OpenStrong\StrongAdmin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use OpenStrong\StrongAdmin\Models\AdminRole;
use OpenStrong\StrongAdmin\Repositories\AppRepository;

/**
 * 許可權檢測
 */
class CheckPermission extends Auth
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
        if (!$this->checkPermission($request))
        {
            if ($request->expectsJson())
            {
                return response()->json(['code' => 403, 'message' => '暫無許可權']);
            }
            return abort(403, '暫無許可權');
        }
        return $next($request);
    }

    protected function checkPermission($request)
    {
        $current_route_url = $this->getCurrentRouteUrl($request);
        if (in_array($current_route_url, $this->getIgnoreUrl()))
        {
            return true;
        }
        if (AppRepository::isApi())
        {
            return true;
        }
        $user = auth()->guard(config('strongadmin.guard'))->user();
        if ($user->id == 1)
        {
            //超級管理員角色
            return true;
        }
        //獲取角色對應的route_url
        $roleModel = AdminRole::find($user->roles->pluck('id'));
        if (!$roleModel)
        {
            return false;
        }
        $permissionsMenuUrl = [];
        foreach ($roleModel as $perm)
        {
            $permissionsMenuUrl = array_merge_recursive($permissionsMenuUrl, $perm['permissions']['menu_route_url'] ?? []);
        }
        if (!in_array($current_route_url, $permissionsMenuUrl))
        {
            return false;
        }
        return true;
    }

    protected function getCurrentRouteUrl($request)
    {
        $current_route_url = Route::current()->uri;
        return $current_route_url;
    }

    protected function getIgnoreUrl()
    {
        $url = parent::getIgnoreUrl();
        return array_merge($url, config('strongadmin.ignore_permission_check_url'));
    }

}
