<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | StrongAdmin Routes
  |--------------------------------------------------------------------------
  |
 */
Route::any('captcha', 'IndexController@captcha')->name('strongadmin.captcha'); //圖片驗證碼
Route::any('login', 'AdminAuthController@login')->name('strongadmin.login'); //登錄
Route::any('logout', 'AdminAuthController@logout')->name('strongadmin.logout'); //退出
Route::any('/', 'IndexController@home')->name('strongadmin.home'); //home 主頁
Route::any('userinfo', 'AdminAuthController@userinfo'); //管理員資訊
Route::any('index/panel', 'IndexController@panel')->name('strongadmin.panel'); //面板
//操作日誌
Route::any('adminLog/index', 'AdminLogController@index');
Route::any('adminLog/destroy', 'AdminLogController@destroy');
//菜單管理
Route::any('adminMenu/index', 'AdminMenuController@index');
Route::any('adminMenu/show', 'AdminMenuController@show');
Route::any('adminMenu/create', 'AdminMenuController@create');
Route::any('adminMenu/update', 'AdminMenuController@update');
Route::any('adminMenu/destroy', 'AdminMenuController@destroy');
//角色管理
Route::any('adminRole/index', 'AdminRoleController@index');
Route::any('adminRole/show', 'AdminRoleController@show');
Route::any('adminRole/create', 'AdminRoleController@create');
Route::any('adminRole/update', 'AdminRoleController@update');
Route::any('adminRole/destroy', 'AdminRoleController@destroy');
Route::any('adminRole/assignPermissions', 'AdminRoleController@assignPermissions');
//賬號管理
Route::any('adminUser/index', 'AdminUserController@index');
Route::any('adminUser/show', 'AdminUserController@show');
Route::any('adminUser/create', 'AdminUserController@create');
Route::any('adminUser/update', 'AdminUserController@update');
Route::any('adminUser/destroy', 'AdminUserController@destroy');
//Layui
Route::any('layui/{name}', function ($name) {
    return view("strongadmin::layui.{$name}");
});
Route::any('layui/demo/table/{name}.html', function ($name) {
    return view("strongadmin::layui.table/{$name}");
});
Route::any('layui/demo/table/user', function () {
    return '{"code":0,"msg":"","count":1000,"data":[{"id":10000,"username":"user-0","sex":"女","city":"城市-0","sign":"簽名-0","experience":255,"logins":24,"wealth":82830700,"classify":"作家","score":57},{"id":10001,"username":"user-1","sex":"男","city":"城市-1","sign":"簽名-1","experience":884,"logins":58,"wealth":64928690,"classify":"詞人","score":27},{"id":10002,"username":"user-2","sex":"女","city":"城市-2","sign":"簽名-2","experience":650,"logins":77,"wealth":6298078,"classify":"醬油","score":31},{"id":10003,"username":"user-3","sex":"女","city":"城市-3","sign":"簽名-3","experience":362,"logins":157,"wealth":37117017,"classify":"詩人","score":68},{"id":10004,"username":"user-4","sex":"男","city":"城市-4","sign":"簽名-4","experience":807,"logins":51,"wealth":76263262,"classify":"作家","score":6},{"id":10005,"username":"user-5","sex":"女","city":"城市-5","sign":"簽名-5","experience":173,"logins":68,"wealth":60344147,"classify":"作家","score":87},{"id":10006,"username":"user-6","sex":"女","city":"城市-6","sign":"簽名-6","experience":982,"logins":37,"wealth":57768166,"classify":"作家","score":34},{"id":10007,"username":"user-7","sex":"男","city":"城市-7","sign":"簽名-7","experience":727,"logins":150,"wealth":82030578,"classify":"作家","score":28},{"id":10008,"username":"user-8","sex":"男","city":"城市-8","sign":"簽名-8","experience":951,"logins":133,"wealth":16503371,"classify":"詞人","score":14},{"id":10009,"username":"user-9","sex":"女","city":"城市-9","sign":"簽名-9","experience":484,"logins":25,"wealth":86801934,"classify":"詞人","score":75}]}';
});
Route::any('layui/demo/table/edit', function () {
    return '{
  "code": 0
  ,"msg": ""
  ,"count": 3000000
  ,"data": [{
    "id": "10001"
    ,"username": "杜甫"
    ,"email": "test@email.com"
    ,"sex": "男"
    ,"city": "浙江杭州"
    ,"sign": "點選此處，顯示更多。當內容超出時，點選單元格會自動顯示更多內容。"
    ,"experience": "116"
    ,"ip": "192.168.0.8"
    ,"logins": "108"
    ,"joinTime": "2016-10-14"
  }, {
    "id": "10002"
    ,"username": "李白"
    ,"email": "test@email.com"
    ,"sex": "男"
    ,"city": "浙江杭州"
    ,"sign": "君不見，黃河之水天上來，奔流到海不復回。 君不見，高堂明鏡悲白髮，朝如青絲暮成雪。 人生得意須盡歡，莫使金樽空對月。 天生我材必有用，千金散盡還復來。 烹羊宰牛且為樂，會須一飲三百杯。 岑夫子，丹丘生，將進酒，杯莫停。 與君歌一曲，請君為我傾耳聽。(傾耳聽 一作：側耳聽) 鐘鼓饌玉不足貴，但願長醉不復醒。(不足貴 一作：何足貴；不復醒 一作：不願醒/不用醒) 古來聖賢皆寂寞，惟有飲者留其名。(古來 一作：自古；惟 通：唯) 陳王昔時宴平樂，鬥酒十千恣歡謔。 主人何為言少錢，逕須沽取對君酌。 五花馬，千金裘，呼兒將出換美酒，與爾同銷萬古愁。"
    ,"experience": "12"
    ,"ip": "192.168.0.8"
    ,"logins": "106"
    ,"joinTime": "2016-10-14"
    ,"LAY_CHECKED": true
  }, {
    "id": "10003"
    ,"username": "王勃"
    ,"email": "test@email.com"
    ,"sex": "男"
    ,"city": "浙江杭州"
    ,"sign": "人生恰似一場修行"
    ,"experience": "65"
    ,"ip": "192.168.0.8"
    ,"logins": "106"
    ,"joinTime": "2016-10-14"
  }, {
    "id": "10004"
    ,"username": "李清照"
    ,"email": "test@email.com"
    ,"sex": "女"
    ,"city": "浙江杭州"
    ,"sign": "人生恰似一場修行"
    ,"experience": "666"
    ,"ip": "192.168.0.8"
    ,"logins": "106"
    ,"joinTime": "2016-10-14"
  }, {
    "id": "10005"
    ,"username": "冰心"
    ,"email": "test@email.com"
    ,"sex": "女"
    ,"city": "浙江杭州"
    ,"sign": "人生恰似一場修行"
    ,"experience": "86"
    ,"ip": "192.168.0.8"
    ,"logins": "106"
    ,"joinTime": "2016-10-14"
  }, {
    "id": "10006"
    ,"username": "賢心"
    ,"email": "test@email.com"
    ,"sex": "男"
    ,"city": "浙江杭州"
    ,"sign": "人生恰似一場修行"
    ,"experience": "12"
    ,"ip": "192.168.0.8"
    ,"logins": "106"
    ,"joinTime": "2016-10-14"
  }, {
    "id": "10007"
    ,"username": "賢心"
    ,"email": "test@email.com"
    ,"sex": "男"
    ,"city": "浙江杭州"
    ,"sign": "人生恰似一場修行"
    ,"experience": "16"
    ,"ip": "192.168.0.8"
    ,"logins": "106"
    ,"joinTime": "2016-10-14"
  }, {
    "id": "10008"
    ,"username": "賢心"
    ,"email": "test@email.com"
    ,"sex": "男"
    ,"city": "浙江杭州"
    ,"sign": "人生恰似一場修行"
    ,"experience": "106"
    ,"ip": "192.168.0.8"
    ,"logins": "106"
    ,"joinTime": "2016-10-14"
  }]
}  ';
});
