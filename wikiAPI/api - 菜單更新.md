#### 介面版本：

|版本號|制定人|修訂日期|說明|
|:----|:----|:----   |:----|
|1.0 |Karen  |2021-10-22 |建立文件|

#### 請求URL:

- {{HOST}}/strongadmin/adminMenu/update

#### 請求方式：

- POST

#### 請求頭：

|參數名|是否必須|型別|說明|
|:----    |:---|:----- |-----   |
|Content-Type |是  |string |application/json   |
|Accept |是  |string |application/json   |
|Authorization|是|string|{token}|

#### 請求參數:

|參數名|是否必須|型別|說明|
|:----    |:---|:----- |-----   |
|id |是  |integer |菜單id   |
|level |是  |integer |等級 1 一級菜單, 2 二級菜單, 3 三級菜單   |
|parent_id |是  |integer |上級菜單   |
|name |是  |string |菜單名稱   |
|route_url |否  |string |菜單跳轉地址   |
|status |否  |integer |狀態 1開啟,2禁用   |
|sort |否  |integer |排序   |
|delete_allow |是  |integer |是否允許刪除：1 允許，2 不允許   |


#### 返回示例:

**正確時返回:**

```
{
    "code": 200,
    "message": "common.Success",
    "data": {
        "id": 1, //菜單id
        "level": 1, //等級 1 一級菜單, 2 二級菜單, 3 三級菜單
        "parent_id": 0, //上級菜單
        "name": "許可權管理", //菜單名稱
        "route_url": "", //菜單跳轉地址
        "status": 1, //狀態 1開啟,2禁用
        "sort": 2001, //排序
        "created_at": "2021-01-06 03:37:40", //
        "updated_at": "2021-05-21 20:10:57", //
        "delete_allow": 2 //是否允許刪除：1 允許，2 不允許
    }
}
```

#### 返回CODE說明:

|參數名|說明|
|:----- |----- |
|200 |成功  |
|3001 |欄位驗證錯誤  |
|5001|服務內部錯誤|

#### 備註:

- 更多返回錯誤程式碼請看首頁的錯誤程式碼描述