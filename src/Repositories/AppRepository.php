<?php

namespace OpenStrong\StrongAdmin\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Admin\WebConfig;

class AppRepository
{

    /**
     * 是否是`api`路由組
     * @return bool
     */
    public static function isApi(): bool
    {
        $guard = self::getGuard();
        return $guard === 'api' ? true : false;
    }

    /**
     * 是否是`web`路由組
     * @return bool
     */
    public static function isWeb(): bool
    {
        $guard = self::getGuard();
        return $guard === 'web' ? true : false;
    }

    /**
     * 獲取登錄使用者資訊
     * @return type
     */
    public static function getUser()
    {
        $guard = config('strongadmin.guard');
        return Auth::guard($guard)->check() ? Auth::guard($guard)->user() : null;
    }

    /**
     * 獲取登錄守護名稱
     * @return string
     */
    public static function getGuard()
    {
        if (!request()->route())
        {
            return null;
        }
        $data = config('strongadmin.middleware', []) ?: [];
        if (is_string($data))
        {
            $data = [$data];
        }
        if (array_search('api', $data) !== false)
        {
            return 'api';
        } elseif (array_search('web', $data) !== false)
        {
            return 'web';
        } else
        {
            return $data[0] ?? null;
        }
    }

    /**
     * 魔術方法
     * @param type $name
     * @return type
     */
    public function __get($name)
    {
        $action = 'get' . ucfirst($name);
        return $this->$action();
    }

}
