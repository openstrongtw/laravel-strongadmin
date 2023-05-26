#### 介面版本：

|版本號|制定人|修訂日期|說明|
|:----|:----|:----   |:----|
|1.0 |Karen  |2021-10-22 |建立文件|

#### 請求URL:

- {{HOST}}/strongadmin/adminLog/index

#### 請求方式：

- GET

#### 請求頭：

|參數名|是否必須|型別|說明|
|:----    |:---|:----- |-----   |
|Content-Type |是  |string |application/json   |
|Accept |是  |string |application/json   |
|Authorization|是|string|{token}|

#### 搜索參數:

|參數名|是否必須|型別|說明|
|:----    |:---|:----- |-----   |
|page |否  |integer |第幾頁, 如果是 -1 表示不分頁   |
|route_url |否  |string |路由   |
|desc |否  |string |操作描述   |
|admin_user_id |否  |integer |操作使用者   |
|created_at_begin |否  |date |CREATED_AT 開始日期   |
|created_at_end |否  |date |CREATED_AT 結束日期   |

#### 返回示例:

**正確時返回:**

```
{
    "code": 200,
    "message": "common.Success",
    "data": {
        "data": [
            {
                "id": 1, //
                "route_url": "/strongadmin/login", //路由
                "desc": "登錄成功:admin", //操作描述
                "log_original": "", //欄位變更前內容
                "log_dirty": "", //欄位變更后內容
                "admin_user_id": 1, //操作使用者
                "created_at": "2021-09-27 05:33:24", //
                "updated_at": "2021-09-27 05:33:24" //
            },
            {
                "id": 2,
                "route_url": "/strongadmin/login",
                "desc": "登錄密碼錯誤：admin",
                "log_original": "",
                "log_dirty": "",
                "admin_user_id": 0,
                "created_at": "2021-10-21 02:50:55",
                "updated_at": "2021-10-21 02:50:55"
            }
        ],
        "current_page": 1, //目前頁
        "last_page": 1, //末頁/總頁數
        "per_page": 15, //每頁條數
        "total": 5 //數據總條數
    }
}
```

#### 返回CODE說明:

|參數名|說明|
|:----- |----- |
|200 |成功  |
|5001|服務內部錯誤|

#### 備註:

- 更多返回錯誤程式碼請看首頁的錯誤程式碼描述