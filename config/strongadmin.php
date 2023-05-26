<?php

return [
    /*
      |--------------------------------------------------------------------------
      | 啟用 StrongAdmin
      |--------------------------------------------------------------------------
     */
    'enabled' => env('STRONGADMIN_ENABLED', true),
    
    /*
      |--------------------------------------------------------------------------
      | StrongAdmin 子域名
      |--------------------------------------------------------------------------
      |
      | 設定后即可支援域名訪問
      |
     */
    'domain' => env('STRONGADMIN_DOMAIN', null),
    
    /*
      |--------------------------------------------------------------------------
      | StrongAdmin Path
      |--------------------------------------------------------------------------
      |
      | StrongAdmin 訪問路徑（也是路由字首），如果修改此項，請記得修改以下配置 `ignore_auth_check_url`、`ignore_permission_check_url`
      |
     */
    'path' => env('STRONGADMIN_PATH', 'strongadmin'),
    
    /*
      |--------------------------------------------------------------------------
      | StrongAdmin 數據配置
      |--------------------------------------------------------------------------
      |
      | 1.在這可以自定義 StrongAdmin 數據庫連線的數據庫
      | 2.修改預設 後臺超級管理員 賬號資訊（僅安裝初始化有效）
      | 3.修改圖片驗證碼配置
      |
     */
    'storage' => [
        //數據庫
        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'), //數據庫連線
        ],
        //後臺超級管理員（僅安裝初始化有效）
        'super_admin' => [
            'user_name' => 'admin', //賬號名稱
            'password' => '123456', //賬號密碼
        ],
        //登錄限制
        'throttles_logins' => [
            'maxAttempts' => 5, //允許嘗試登錄最大次數
            'decayMinutes' => 10, //登錄錯誤超過 maxAttempts 次, 禁止登錄 decayMinutes 分鐘
        ],
        //圖片驗證碼
        'captcha'=>[
            'length' => 4, //字元長度
            'width' => 120, //寬
            'height' => 44, //高
            'expire' => 60, //有效期 秒
        ],
    ],
    
    /*
      |--------------------------------------------------------------------------
      | StrongAdmin 中介軟體
      |--------------------------------------------------------------------------
      |
     */
    'middleware' => [
        config('auth.guards.strongadmin.driver') == 'session' ? 'web' : 'api',
        OpenStrong\StrongAdmin\Http\Middleware\Auth::class, //登錄認證檢測
        OpenStrong\StrongAdmin\Http\Middleware\CheckPermission::class, //許可權檢測
        OpenStrong\StrongAdmin\Http\Middleware\Log::class, //日誌記錄
    ],
    
    /*
      |--------------------------------------------------------------------------
      | StrongAdmin Auth Guard 登錄認證看守器名稱。不建議修改此項，如果修改此項則必須修改相對應的 `config/auth.php` 里的 `guards` 配置項
      |--------------------------------------------------------------------------
      | auth('strongadmin')->user() --- 獲取登錄使用者資訊
      | auth('strongadmin')->id()   --- 獲取登錄使用者id
     */
    'guard' => 'strongadmin',
    
    /*
      |--------------------------------------------------------------------------
      | 忽略登錄檢測的路由
      |--------------------------------------------------------------------------
     */
    'ignore_auth_check_url' => ['strongadmin/login', 'strongadmin/logout', 'strongadmin/captcha'],
    
    /*
      |--------------------------------------------------------------------------
      | 忽略許可權檢測的路由
      |--------------------------------------------------------------------------
     */
    'ignore_permission_check_url' => ['strongadmin'],
    
];
