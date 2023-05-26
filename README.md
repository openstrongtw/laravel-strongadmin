<h1 align="center">Larevel-StrongAdmin</h1>
<h3 align="center">在1分鐘內構建一個功能齊全的管理後臺。</h3>

基於 layui 前端框架開發的 Laravel 後臺管理框架。同時擁有 api 介面，配合前端 VUE 開發。功能如下：
- 許可權管理
- 菜單管理
- 角色管理
- 日誌記錄
- 管理員賬號

# 演示站點
http://demo.strongadmin.strongshop.cn/strongadmin
```
演示賬號：admin
演示密碼：123456
```
## 檢視介面文件
[點選檢視](https://gitee.com/openstrong/laravel-strongadmin/tree/master/wikiAPI "點選檢視")

## 安裝
你可以使用 Composer 在 Laravel 5|6|7|8 專案中安裝 laravel-strongadmin 擴充套件：
```
composer require openstrong/laravel-strongadmin
```

安裝 laravel-strongadmin 后，可以在 Artisan 使用 `strongadmin:install` 命令來配置擴充套件實例。安裝 laravel-strongadmin 后，還應執行  `migrate` 命令：
```
php artisan strongadmin:install

php artisan migrate
```
### 瀏覽
http://你的域名/strongadmin

## 更新 laravel-strongadmin
更新 laravel-strongadmin 時，您應該重新配置載入 laravel-strongadmin 實例：
```
php artisan strongadmin:publish
```

## 配置
使用 laravel-strongadmin，其主要配置檔案將位於 config/strongadmin.php。每個配置選項都包含其用途說明，因此請務必徹底瀏覽此檔案。

```
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
    'web',
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
```

# 快速構建
### 使用 artisan 命令快速產生 CURD 增刪改查的控制器和檢視
> 此命令使用擴充套件包 `laravel-strongstub`，詳細文件：https://gitee.com/openstrong/laravel-strongstub 

1. 執行`strongstub:curd`命令：
    ```
    php artisan strongstub:curd Strongadmin/TesetAdminUserController -m App\\Models\\StrongadminUser --view
    ```
    結果：
    ```
     A App\Models\StrongadminUser model does not exist. Do you want to generate it? (yes/no) [yes]:
     >

    Model created successfully.
    Controller created successfully.

    Route::any('strongadmin/tesetAdminUser/index', 'Strongadmin\TesetAdminUserController@index');
    Route::any('strongadmin/tesetAdminUser/show', 'Strongadmin\TesetAdminUserController@show');
    Route::any('strongadmin/tesetAdminUser/create', 'Strongadmin\TesetAdminUserController@create');
    Route::any('strongadmin/tesetAdminUser/update', 'Strongadmin\TesetAdminUserController@update');
    Route::any('strongadmin/tesetAdminUser/destroy', 'Strongadmin\TesetAdminUserController@destroy');

    id:
    user_name:
    password:
    remember_token:
    name:
    email:
    phone:
    avatar:
    introduction:
    status:
    last_ip:
    last_at:
    created_at:
    updated_at:

    {"id":"","user_name":"","password":"","remember_token":"","name":"","email":"","phone":"","avatar":"","introduction":"","status":"","last_ip":"","last_at
    ":"","created_at":"","updated_at":""}

    Blade View`F:\phpstudy_pro\WWW_openstrong\strongadmin\resources\views/strongadmin/tesetAdminUser/form.blade.php` created successfully.
    Blade View`F:\phpstudy_pro\WWW_openstrong\strongadmin\resources\views/strongadmin/tesetAdminUser/index.blade.php` created successfully.
    Blade View`F:\phpstudy_pro\WWW_openstrong\strongadmin\resources\views/strongadmin/tesetAdminUser/show.blade.php` created successfully.
    ```
2. 新增路由:app/routes/web.php
```
Route::middleware(['strongadmin'])->group(function () {
    Route::any('strongadmin/tesetAdminUser/index', 'Strongadmin\TesetAdminUserController@index');
    Route::any('strongadmin/tesetAdminUser/show', 'Strongadmin\TesetAdminUserController@show');
    Route::any('strongadmin/tesetAdminUser/create', 'Strongadmin\TesetAdminUserController@create');
    Route::any('strongadmin/tesetAdminUser/update', 'Strongadmin\TesetAdminUserController@update');
    Route::any('strongadmin/tesetAdminUser/destroy', 'Strongadmin\TesetAdminUserController@destroy');
});
```
3. 把路由新增到 許可權菜單=》菜單管理

<img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD//gAUU29mdHdhcmU6IFNuaXBhc3Rl/9sA
QwADAgIDAgIDAwMDBAMDBAUIBQUEBAUKBwcGCAwKDAwLCgsLDQ4SEA0OEQ4L
CxAWEBETFBUVFQwPFxgWFBgSFBUU/9sAQwEDBAQFBAUJBQUJFA0LDRQUFBQU
FBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQU
/8AAEQgBBQMJAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgME
BQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQci
cRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZH
SElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqi
o6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq
8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//E
ALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGx
wQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZX
WFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ip
qrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5
+v/aAAwDAQACEQMRAD8A+Ov+EftP+eZ/76P+NH/CP2n/ADzP/fR/xrSor0rI
5zN/4R+0/wCeZ/76P+NH/CP2n/PM/wDfR/xrSoosgM3/AIR+0/55n/vo/wCN
H/CP2n/PM/8AfR/xrSoosgM3/hH7T/nmf++j/jR/wj9p/wA8z/30f8a0qKLI
DN/4R+0/55n/AL6P+NH/AAj9p/zzP/fR/wAa0qKLIDN/4R+0/wCeZ/76P+NH
/CP2n/PM/wDfR/xrSoosgM3/AIR+0/55n/vo/wCNH/CP2n/PM/8AfR/xrSoo
sgM3/hH7T/nmf++j/jR/wj9p/wA8z/30f8a0qKLIDN/4R+0/55n/AL6P+NH/
AAj9p/zzP/fR/wAa0qKLIDN/4R+0/wCeZ/76P+NH/CP2n/PM/wDfR/xrSoos
gM3/AIR+0/55n/vo/wCNH/CP2n/PM/8AfR/xrSoosgM3/hH7T/nmf++j/jXY
fBr4f6J4s+L/AIG0TVbQ3Wl6nrtjZXcHmunmQyXCI67lIYZViMggjsawa9B/
Z4/5L/8ADP8A7GfTP/SuOk1oNH6af8O6f2ef+iff+VrUf/kij/h3T+zz/wBE
+/8AK1qP/wAkV9I0Vwcz7m1kfN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T
7/ytaj/8kV9I0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrW
o/8AyRX0jRRzPuFkfN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T7/ytaj/8
kV9I0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrWo/8AyRX0
jRRzPuFkfN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T7/ytaj/8kV9I0Ucz
7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrWo/8AyRX0jRRzPuFk
fN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T7/ytaj/8kV9I0Ucz7hZHzd/w
7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrWo/8AyRX0jRRzPuFkfN3/AA7p
/Z5/6J9/5WtR/wDkij/h3T+zz/0T7/ytaj/8kV9I0Ucz7hZHzd/w7p/Z5/6J
9/5WtR/+SKP+HdP7PP8A0T7/AMrWo/8AyRX0jRRzPuFkfN3/AA7p/Z5/6J9/
5WtR/wDkij/h3T+zz/0T7/ytaj/8kV9I0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+
SKP+HdP7PP8A0T7/AMrWo/8AyRX0jRRzPuFkfN3/AA7p/Z5/6J9/5WtR/wDk
ij/h3T+zz/0T7/ytaj/8kV9I0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7
PP8A0T7/AMrWo/8AyRX0jRRzPuFkfN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+z
z/0T7/ytaj/8kV9I0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/
AMrWo/8AyRX0jRRzPuFkfN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T7/yt
aj/8kV9I0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrWo/8A
yRX0jRRzPuFkfN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T7/ytaj/8kV9I
0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrWo/8AyRX0jRRz
PuFkfN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T7/ytaj/8kV9I0Ucz7hZH
zd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrWo/8AyRX0jRRzPuFkfN3/
AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T7/ytaj/8kV9I0Ucz7hZHzd/w7p/Z
5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrWo/8AyRX0jRRzPuFkfN3/AA7p/Z5/
6J9/5WtR/wDkij/h3T+zz/0T7/ytaj/8kV9I0Ucz7hZHzd/w7p/Z5/6J9/5W
tR/+SKP+HdP7PP8A0T7/AMrWo/8AyRX0jRRzPuFkfN3/AA7p/Z5/6J9/5WtR
/wDkij/h3T+zz/0T7/ytaj/8kV9I0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+SKP+
HdP7PP8A0T7/AMrWo/8AyRX0jRRzPuFkfN3/AA7p/Z5/6J9/5WtR/wDkij/h
3T+zz/0T7/ytaj/8kV9I0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A
0T7/AMrWo/8AyRX0jRRzPuFkfN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T
7/ytaj/8kV9I0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrW
o/8AyRX0jRRzPuFkfN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T7/ytaj/8
kV9I0Ucz7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrWo/8AyRX0
jRRzPuFkfN3/AA7p/Z5/6J9/5WtR/wDkij/h3T+zz/0T7/ytaj/8kV9I0Ucz
7hZHzd/w7p/Z5/6J9/5WtR/+SKP+HdP7PP8A0T7/AMrWo/8AyRX0jRRzPuFk
fz80UV6F8KfHk3hBdRi/4WD4x8DwTFGC+FIjL9oYZBMo+124GBjB+bqenf0T
nOd8W+Cr7wfHok11LbXVrrGnRalZ3NnJvjeNiyspJAIdHR43UjhkPUYJ6jwL
8HLT4gX2i6bp/wAQfDMOt6rJHDDpVxb6p5yyucBGZLJowcnkhyo65xzX0d8d
fiqdJ0X4Zuvxi+Jejtd+E7a4D6baZa9JklHnz/8AEyTbK2MEfPwB8x6DkPgJ
4n8R658NtF0Pw9r+uadPB4xl1bxTfWd5c2UFvpjwQ75rq8QqiqfKmxl9xKnA
yRmYvm5nbRP8Oa34LVvpbYuaslbqk/8AyW/4vRep4t4i+GWjeH4tRA+JnhPU
ryz3r9jsYdUZ5nXI2Ru1ksZJIwCXC++Oa4GvrD4u694jj+E/xPg13XdX8QeH
NV8Q2cnha8l1WXWrIW6TXRMa3QeVI5AnlExyOshABKnFfJ9RBttp9LfjFP8A
C9mtdUVNJWt1/wA7foFFFFamYUUUUAFFFFABRRRQAUUUUAFFFFABRRRQBLFa
zTxTSxxPJHCoaV1UkICQAWPYZIHPciltbSe9mEVvDJcSkFgkSlmwASTgegBP
0FdB8P8A4gal8OtcN/YCK5t54zbX2nXa77a+t2+/DKn8Sn8wcEEEA13WufE7
wn4Q0O+tPhjp+o6Xfa4jDUdS1N1a4soG62Ns6/wdd0pw7jAOOczJtLTX/P8A
y8/Xra5HV2f9L/Py9Ol7eP16D+zx/wAl/wDhn/2M+mf+lcdefV6D+zx/yX/4
Z/8AYz6Z/wClcdN7DW5+4tFFFeabhXz/APtr+MNb8GfCawudC1S70i6uNYht
pLiylaKQxmGZyoZSCOUXoe1fQFfNH7fv/JHNG/7D0P8A6T3FdGHSdWKZ87xF
OVPKcRKDs1HofI2nfEf4r6vCJrDxR4yvYjPHaiS31C7kXznzsjyGPztg4Xqc
cVr6rq3x10LT5r/Ur34h6fYwjdLc3Ut/FFGM4yzMQByR1pfglokOuaXqkM0N
pFC99Z2cs895eJ9qEzMFtWt4CPPBMe5Rviw6qWfbkD1D4s+ELe+8Bvrtp4Q0
fRodEtUSwuXuJ70C0V12R7UmZBL5jsW3xyRMJf8AW5UlvbqzhTlytde3kn9/
6P0v+IYPCYrE4V4j2sm7N6Sl0bV/hdlZb31asuvL4defFn4l6c8aXXjPxXbP
JGsyLNqlyhZGGVYZfkEEEHoQar/8Lp+IX/Q9+Jv/AAcXH/xdfTdtqk3n3dw0
FlZa5o+mQW4u7CwhtJ7eQ6HcSSIHjRWADhSFzhSoAAxgeNfFCbQvEJ8JX/iv
xFryatN4es2eSDTY78yjL/O8kl1G27OeMHoOfRynGNRQcV0/FSa6a6L8Sa+E
rxoutSxMnq1Zu3w8qd25WTvK1vLucT/wun4hf9D34m/8HFx/8XXUadq3x21i
3SewvfiHfQOiyLLbS38isrDKsCCRgjkHuK5uCy8A2k8c8XiDXLuSJg62994e
iSCQg5CyFL4sEPQlQTjOBmvqPVNITxJBr3k2ulxprMmnLoaXGm3dumqXcbS3
AE7XaI7xyCIRqgd0jRkVWA5LqOMEmo9ddP6110XX8ll2FxGLc1UxDulolNXe
jfd2Wlr9L/f80y/Eb4sQa2dGk8T+Mo9XEnlHT21C7FwH/u+Xu3Z9sVVl+LXx
Lhs4LuTxn4rjtZ2ZIp21S5CSMuNwVt+CRuXOOmR619A+BvFBX4seN7bQtUt7
PUfNDx2jzay1s1/HsW4uZIoHKC3dy6lpZDsAQ42jB1fjNf61beBJ9GOtJZ39
7MsNimn6rr17neis1u05Vo7iWUDCwyKnlqwIzv3Vkqq09y7aW3md7yyq6dSr
HGO0XJbvpfS90ru3lq1bS7Xgdr4p+Md/LoMdt4n8WXJ10MdOMOszus+1irjc
JMKVIO4MQVGC2AQaw7j4xfESzuZIX8eeImeJyhMetzSISDjhlkKsPcEg19jn
xDq0uh+Knt9H8bKsNvYpCiaNqsbOQUVxAn2+ItjB3eWsGBkneOD8oftIfarn
4rahqE9jqVlFe29q8R1SzntZZAttHGx2TEvw6MMlmyQfmbqXSqKpPlcUjnzP
BV8Bho1oYicm2ur81ffuvxS3V3+jnws1W61z4Y+ENSvpjcXt5o9ncTzN1eR4
UZmP1JJr5P8A23/iV4r8K/E3RtM0TxHqmjWR0eO5aLTruS3DSNNMpZthGeEU
c9Me9fUvwW/5I54E/wCwDYf+k6V8bft+/wDJY9G/7AMP/pRcV5+FSeIaa7n6
TxPWqQyCM4Sab5Nb6nn+n678cdW0lNUsdR+IN5pjqXW9t576SEqM5IcHGBg5
Oexqk3jj4wIbAN4g8bqb9Glswb28/wBJQKHLR/N84CkMSM8EGvon4Q3d/Z/B
Kyv18Ovd3FnapDCrWd2RcI32s7tyac7HAmPMcrKM/fi3MH5zxdp0Vx8SPh34
XvNMl0u1uY7NYbzw/qVxE9lqEKLDIgEzzRt5RVRwiyH5Mydd3oymlWlT5Vo7
L8X+Vvvtofn7y6awNLF/WZ3lGLavKybaVrpO2vMte19TwmP4s/Euaznu4/Gf
it7SBlSWddUuTHGzZ2hm34BO1sA9cH0rc0TX/jh4msFvtH1L4garZMSq3NjP
fTRkjggMpIyK6OD4eazB8KvHKa6iWfiXVLyPUrbTlRFeYWoL3WFThdoujlAA
VMbqQNpA9A+DPhMa/wDCXwwk6afKDa6mbeK70rTLx/OeXy4WX7XKjA+btCqo
KOxAZlpznCN7JdP/AEm/53S80cuHwOKqVIQnUqe9Fu17NPn5dbvS0XGT8npe
6v5FPqXx4try2tJrr4ixXd1u8iB5L9Xl2jLbFJy2BycdKs/8ZCf9VM/8qFdz
8cdN0+w0Xwha3Glrq2gXLn7NH4dGm6ZJPfGKGOYg2zXAkw8bBgIQFZgokYbR
TPFmqeDX8c/F5W0fWLiaDTfKvJYdZhVJNlzaoyxg2hKEOByS/wB1hjkESpXe
kU9+na3p3/rp2VMB7Ko6c8RNNOK1k7+9GT6Ra+z+PS2vktn8SfitqOsDSbTx
T4xutVLtELGHUbt5y653LsDbsjByMcYNVD8YviMJ/JPjfxQJt2zy/wC1rndu
zjGN/XPavW/gda+H/EqJoujaPc+HRqkzQ3Gtx+MLBNV8tVLeUsTwCQRnAz5S
KW53MyjA0NB8SWv/AAtHQb620gaZ4hNtcyXOrWXja1uRexxxM8pvDaWsvJRM
ZVFdjlss3zLfMlJx5VovJdL366aPz6nn0sJWrUoVFiZe/Ky0m1ulbZXeqa2T
2vdHmNh4k+Nuq6le6dZap4/vNQsiBdWkFxfPLb56eYgOVz7gVq/Cb4s/EKH4
yeE9N1LxZ4hkD63bWV3Y6hfzOuGmWORHjdiM4JGCMg+4r36y8Rvr/hGLUbWx
1Pxtp0X2NrO0tdWuNSllKXTh5QLi0ik3q43ncGVhGo+RRXzR4S0uXRP2mNC0
+e/Gqz23iy2ikvl/5bsLtQXPJwSeSMnnPJrCnUVXmi4pWv8Ahb/P/gvW3bic
NUwFXD1KOIlNSlHW7tq3b120a33ajdX/AFEooorwj+hQooooAKKKKACiiigA
ooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACi
iigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAP5+a6fwt8UfGfg
ayls/Dfi7XfD9pNJ5skGlalNbRu+ANxVGAJwAMn0FcxRXpnOeg/8ND/FX/op
njH/AMH93/8AHKwPEvxG8WeM7S3tfEHifWddtbdzJDBqeoS3CRMerKrsQCe5
Fc7RU8q7DuzQ0zxDqmiW9/Bp2pXlhBfwm3u4rWd41uYicmOQKQHXIB2nIrPo
op+YgooopgFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABXoP7PH/Jf/hn
/wBjPpn/AKVx159XoP7PH/Jf/hn/ANjPpn/pXHSew1ufuLRRRXmm4V8//tr+
D9b8Z/CawttC0u71e6t9YhuZLeyiaWQRiGZCwVQSeXXoO9fQFFaU5unJSXQ8
/H4OOYYWphZuymrXR+XOj+C/i74fsUtNN8KeKrGJLxb9Wg0aZZBMqMitvEe7
AV3G3OPmPHNa91b/AByu7yC4/wCEf8V26wokaWlnoclvabFBAU28cSxFcEgg
qQQSDkV+l9Fd7xzbu4q58BHganCPJHFTS7fifm3BefHq1YPb+H/E1rN581yb
i38OGOZ5pUZHkeRYQzPtdgGYkrn5SMCub8U+CPi542voL3XvCvizVbyGBLZb
i50i4aQxrnaGbZljyeWyT3NfqRRUrGWaagi58FKrFwni5tPo9V+fkvuPyjtf
hB8SLK5huLfwT4pt7iFxJHLFpNyrowOQykJkEHkEV1q2/wAdE0efTV0LxasE
/m+bKNFl+0P5jBpSZ/K8wlyAGO75goU5AAr9L68y/aXW7/4UT4xmsLia0vLW
zF5FPbuUkjaJ1lDKw5BGzqKVXMXGDk4J21OnLfD6nVxVPDUsZOHtJKN10u7X
dmr2ufCGv6B8avFFq9tqmgeMrq3lWNZ4jpdwq3JjACPMFQebIAFHmPubCqM4
Awy/8NfGfUb/AFS9k8PeMop9UhW2vja6XcwLcxKgQJIsaKrLtAGCOe/U1698
Bv29ZIPs+i/ElTLHwkev28fzL/13jXr/ALyDPqp5Nfamj6zYeIdMt9R0y8g1
CwuF3w3NtIJI5F9Qw4Nc2GzeliY3pRXmup7ee+EuOyGv7PH152e0lrGVr7P5
vR2au9NT8vbD4c/FLS9I1TS7bwZ4misdTWNbuL+xJj5ojfenJjyMMM8EZ71n
D4K/EIkD/hBPEvPrpFx/8RX6wUV2/X5fyo+TfAOHkkniJabaL1/NnL/CzSrr
Q/hj4Q02+hNve2ej2dvPC3VJEhRWU/Qgivk/9t/4a+K/FXxN0bU9E8OaprNk
NHjtml060kuAsizTMVbYDjh1PPXPtX2xRXHSrOnP2iR9rmeT08ywKwM5NJW1
66H5r6RL8efD9npVppmheK9PttLI+yxWuhSRqvchgIhvBPzEPkM3Jyeax7Pw
v8ZdPsmtrbw74whVr06iJU0q4Ey3JUq0qy7N6swJDEMN3Gc4FfqBRXV9d39x
a/8AD/nqfJPglO18XPTReStbTXtp6H5gTeGPjHN4i07XP+EY8Vxanp0cUVnN
Bo00S20cYwiRosYVVAz8oGDuYkEsc6u343GSZn8H6xNHNbLaNbz+EUkgESyG
UKsTW5RfnYtwoOcegr9KqKf11u14LQI8Exhflxc1ffz/ABPzTjj+OMc0Fy3h
jxFPqMCsseq3Hhoy36gqV/4+ngM2QGIB3/LxtxgY5qw+GvxR0yLUo7bwZ4nR
dSg+zXWdFnYyx71kxkxkj5kU5GDx15NfqjRQsc1qoIUuCYztzYubtt5dO/bQ
/M/wzp/xj8Hpaf2R4Dv7Wa0z5N03gqGS4XOcnznti5PJGSx446U6G0+M9nf2
t9Y+CNS0m+ti5hutK8GxWcqb42jb54bZT91278HBGCAR+l1FH11tt8i1KjwX
yRjGOMqJLby9NdNl9x+Z+tWvx08SaDJo2r6J4w1SwkVVcXukTzSsFkMigytG
XOGJP3vbpxR8G/g348tviz4Nubnwbrtna22sWlzNcXenTQxxxpMrszMygDAU
96/TCipWM5U4xglca4JpyrQrVcTObjbfXRO9tegUUUV5x+lBRRRQAUUUUAFF
FFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUU
UAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAfz80UUV6Zz
hRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAV6D+zx
/wAl/wDhn/2M+mf+lcdefV6D+zx/yX/4Z/8AYz6Z/wClcdJ7DW5+4tFFFeab
hRRTJXMagj170APoqt9ob0FH2hvQUAWaKrfaG9BR9ob0FAFmuZ+J+lf258Nf
FmnY3G70m7gA92hYf1rd+0N6CmyyedG8bqrIwKsD3BqZLmTXc2oVXQqwqreL
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
Yf2GNNjtbSFRoVrrdxPbwIqp5k1zLGsb5Dcwwp1GScDGD8Z/H2heP9RvdQ0u
6nL3F89ytrN4asbFkRixw9zDK0kxGQPnHPJJzRJa6d3+LTX4XXlqVSfK232X
5ST/AEfnpbqeX0UUVZAUUUUAFFFFABRRRQAUUUUAFFFFABXo/wCzZ/ycX8LP
+xq0r/0rirzivR/2bP8Ak4v4Wf8AY1aV/wClcVD2A/e+iiiuI1CiiigAoooo
AKKKKACiiigAooooAKKKKACiiigAooooAxPG3g7TPiB4U1Pw9rEHn6dqEJhl
XuvoynsykBgexAr5Y/ZY8Tan8EvifrfwU8VzHy2ma50W5fhJCRuIXP8ADIo3
AdmVx1NfYVfP37XXwauvHXhe18XeGw8PjPwwftdpLAP3k0SneyD1ZSN6+4IH
3q87FU5JrEU170fxXVf5H2/DmOo1I1Mlx0rUa+zf2Ki+CfpfSXdb7H0DRXnf
wE+Ldr8aPhrpviCIol9j7PqFun/LG5UDeMehyGHswr0Su6E41IqcdmfJ4vC1
sDiJ4avG04NprzQUUUVZyBRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAU
UUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRR
RQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB/OTRRRXaZBRRRQAUUUUAFFFFA
BRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAV6P+zZ/wAnF/Cz/satK/8A
SuKvOK9H/Zs/5OL+Fn/Y1aV/6VxUPYD976KKK4jUKKKKACiiigAooooAKKKK
ACiiigAooooAKKKKACiiigAooooA+VNQtP8Ahlb9oKPVoh9n+G/jmYQXSjiL
T77JKt6KuSSOg2s/9wV9V1yvxO+HemfFXwPqnhnVk/0a9jwkoGWgkHKSL7q2
D78g8E1wH7NPjnVL3R9S8B+K22+MvCEgsrnccm6t8fuLhSeWBXAz9CfvVwU1
9Xqun9mWq8n1X6r5n2WOn/bWAjj969FKNTvKG0KnqtISf+F9We00UUV3nxoU
UUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRR
RQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFF
ABRRRQAUUUUAfzk0UUV2mQUV1vwq8J6Z448e6PomraodJs7y4jhMkcTSSSMz
hVjQAEBmJ+82FAyecBT9K6j8NfDGr6Tq+sXXwu1uNIWGm2VlY+Fbu2u0baTH
cMiahsmRQuHbahZmUkjNEvdjzf1/W36gld2/r+rJnx7RXvehfB/RPBPinxZc
arrGnX0vheK2uY9P1+xuYoZPNWJhJcxwrKdqNKq+UpJYg7iqg7tDxb8MPDev
6Do2n6S3hLTvGmqRSa0G05tWjheyEbuqRLMrplgjsS3l7doUKc5qZSUVf+v6
tdv073QR97b+v6uvvPnSivq74f8Ahr4Zn4SaBPq/huz1e3mCyXl+1/aW80d9
ubdC1xJfW7AeUARAFwuQ5LHNT+ONA+HUmgRXui+G9E0K+it5f7JvNTuLWa0u
zCyAQl4dSeJ5w0oYvMrhlGGUhTROSg2n0/T+tO6+4I+/a3X+v+H7fifJVFfa
umeF7OKKebUfD3g+626Ro0qLaposOJ5pEW4cuY3QBs/LkYcZERBOR5h+1Ho+
ladY2jafoumaS0eu6laA6c1ixaJFg2K32WNNmNzYjl3SLk5Y5FNv82vudv1K
hHnbS6K/4N/ofPNFFFMkKKKKACiiigAooooAKKKKACiiigAr0f8AZs/5OL+F
n/Y1aV/6VxV5xXo/7Nn/ACcX8LP+xq0r/wBK4qHsB+99FFFcRqFFFFABRRRQ
AUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFeJ/Hjw3e+E9b0r4teHLd5
tV0BDDq9nCPm1DTCcyr7tH99c+h64Ar2ykZVdSrAMpGCCMgisqtNVY8v9Jno
5fjZYDEKsldaqUekovSUX6r7nqtUUtE1qy8R6PZarp1wl1YXsKXEE6dHRgCp
/I1erh/hd8PZ/hpBrOkQXiTeG2vWudItNp32McnzSQZ6FA5Yr3AbBruKqDk4
pyVmY4uFGnXlHDy5odH1s9VfzWz6XvbQKKKKs5AooooAKKKKACiiigAooooA
KKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAo
oooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD+cmiiiu0yOr+F
3ifTfBfjfT9e1O3mvI9O33MFvCqnfcKp8ncSRhQ+0kjJ46Gu70H46RS+DLrR
dajsrW5uNTjuzdWXhPTLiJYlikBzAyxo0hdl+Y8gbsN2PjNFN6qz/rW4lo7/
ANbNfq/me4L8b9Lbx1421SC91zQbfXNPtbO11LSreNLu3eEQAt5SzIqhhEww
snAYDkUzTfi7FZ3iSXHxY+It7bENHNbz6dFKskbAq67Zb90yVJwSpwcHGRXi
VFS1dWfawRXKrL+tl+h7r8MfjX4d8CeDdW0GOXXbATay99bSwLK7fZ/LCKkj
W97aMX4yeSvt0xT+J3xT8I+OfD9nDKNe1bVLe9SRZrmW5iVLbB86NTcX94A7
HZhggxt5B6V4tRS5evp+BSfLt5/ie3WPxm8N3mo6dd3Fh/YY02O1tIVGhWut
3E9vAiqnmTXMsaxvkNzDCnUZJwMYPxn8faF4/wBRvdQ0u6nL3F89ytrN4asb
FkRixw9zDK0kxGQPnHPJJzXl9FOS5nd/1cE7f12vb8/6sFFFFMQUUUUAFFFF
ABRRRQAUUUUAFFFFABXo/wCzZ/ycX8LP+xq0r/0rirzivR/2bP8Ak4v4Wf8A
Y1aV/wClcVD2A/e+iiiuI1CiiigAooooAKKKKACiiigAooooAKKKKACiiigA
ooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACi
iigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKK
KACiiigAooooAKKKKACiiigAooooAKKKKAP5yaKKK7TIKKKKACiiigAooooA
KKKKACiiigAooooAKKKKACiiigAooooAKKKKACvR/wBmz/k4v4Wf9jVpX/pX
FXnFej/s2f8AJxfws/7GrSv/AErioewH730UUVxGoUUUUAFFFFABRRRQAUUU
UAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQ
AUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAB
RRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB/OTRRRX
aZHpf7Ofh+08S/F7QbO+0S416z84PLbxKGjjUMMyTKY3DRDOCDt6j5h3+gPD
XwqVPDum29j4T0YRPPJIl1LPa3ssyyO5VXnfSJo5NvlOAIXJAZcg5Br5m+EX
iXSPBnxA0nXtZe9Ftpsy3KR2NukzyupGEO6RAoIz82TjA+U549O8HfH/AMK+
C7G9tv8AhG49de509oHubrR9Ptyzlh+5IRCzIQPmkleQsVU+WOcxVbULw3X9
W+dv60FHeV/L9dfldevyZ0cXwbV/GfxD8R3+naDo9nbWm3TtOmGyzgnuIo8O
ySxRlVhSZXbdEu1mXjIrK8T+AfAOteF9B1nRdNlntUM2kiVvEmn6Kt19nK5u
cXEJLtIZGJ5JUBQccAcHJ8SdDivPE09vFceXq+gPpsUEelWdmLeZpkfa32fY
kigKR5uxWbj5ABxVh+LZ0r4Z+H/D2nWlpJfWN3dz3Emp6TaXsRWTy9gjMyOV
PytnAXt17LlasuiS/Nrfrp+fki3bmT83f05f1aXo/VnV+HdJmt/hTNeeHbHw
1Bd/8JJc2zTeI5NKncQLBEVjWe6UJJgknMYAOc4waPFOmzH4L3GpeIbHw1Ne
ReILWFJ/Da6YsnkGGUvGZLNSFyQPvg9AcHFcnp/j3w1P8Ov7C1/SNTv73+2Z
tTB0q6gsIVV4kTAzDIOqn5VRQBjB7CW48e+D4vh1J4d07Q9Zt2l1q31GaO91
GK4WWKON1ZRIkMZQnfj7jeueMG2m2/8At3/22/6/iJPWL/xflK36duh6F8PP
h14TltfEl3PoELWyaNPiS78c6RdCOR9qx42wjyHLEBZG4Unkc15P8QdC0TQb
e1j0/TpbW6lYsZR4psdYjKAcgrbRLsOSMFm5AOAeo73U/jnp/i3yr291LV/C
+pxXWoYj03TYNQgltLlYlELiSaIEKke3BUg4DcHpwvxC8dabr9vDomh6b9m8
OadNv0x7zc15EjIolQt5jDY8gaXbztZjtIBIM63T8l/X4ijs0+7/AOB9/wCB
w1FFFWAUUUUAFFFFABRRRQAUUUUAFFFFABXo/wCzZ/ycX8LP+xq0r/0rirzi
vR/2bP8Ak4v4Wf8AY1aV/wClcVD2A/e+iiiuI1CiiigAooooAKKKKACiiigA
ooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACi
iigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKK
KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAP5yaKKK7TI
KKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACvR/wBm
z/k4v4Wf9jVpX/pXFRRQ9gP3voooriNQooooAKKKKACiiigAooooAKKKKACi
iigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKK
KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAoooo
AKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD/9k=" />

# 開發

### 新增控制器
`app/Http/Controllers/Strongadmin/AdminUserController`

這裡一定要繼承控制器 '\OpenStrong\StrongAdmin\Http\Controllers\BaseController'
```
use \OpenStrong\StrongAdmin\Models\StrongadminUser;
class AdminUserController extends \OpenStrong\StrongAdmin\Http\Controllers\BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->expectsJson())
        {
            return $this->view('adminUser.index');
        }
        $model = StrongadminUser::query();
        $rows = $model->paginate();
        return ['code' => 200, 'message' => __('admin.Success'), 'data' => $rows];
    }
}
```

### 新增路由
```
Route::middleware(['strongadmin'])->group(function() {
    Route::any('strongadmin/product/index', 'Strongadmin\AdminUserController@index');
});
```

### 新增檢視 
`resources/views/strongadmin/adminUser/index.blade.php`

這裡一定要繼承檢視模板 `strongadmin::layouts.app`
```
@extends('strongadmin::layouts.app')

@push('styles')
    <style></style>
@endpush

@push('scripts')
    <script>
    //......
    </script>
@endpush

@section('content')
    <div class="st-h15"></div>
    <form class="layui-form st-form-search" lay-filter="ST-FORM-SEARCH">
        ...
    </form>
@endsection

@push('scripts_bottom')        
    <script>
    !function () {
        //...
    }();
    </script>
@endpush
```

# 重構

這裡以重構登錄為例

1. 重構控制器
新建 app/Http/Controllers/Strongadmin/AdminAuthController

    ```
    class AdminAuthController extends \OpenStrong\StrongAdmin\Http\Controllers\AdminAuthController
    {
        public function login(Request $request)
        {

        }
    }
    ```

2. 重構路由
    ```
    Route::middleware(['strongadmin'])->group(function() {
        Route::any('strongadmin/login', 'Strongadmin\AdminAuthController@login');
    });
    ```

# 使用此擴充套件包的開源專案
StrongShop 開源跨境商城 https://gitee.com/openstrong/strongshop

QQ群：557655631