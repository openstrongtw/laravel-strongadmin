#### 介面版本：

|版本號|制定人|修訂日期|說明|
|:----|:----|:----   |:----|
|1.0 |Karen  |2021-10-22 |建立文件|

#### 請求URL:

- {{HOST}}/strongadmin/adminMenu/index

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
|level |否  |integer |等級 1 一級菜單, 2 二級菜單, 3 三級菜單   |
|parent_id |否  |integer |上級菜單   |
|name |否  |string |菜單名稱   |
|route_url |否  |string |菜單跳轉地址   |
|status |否  |integer |狀態 1開啟,2禁用   |
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
            },
            {
                "id": 2,
                "level": 2,
                "parent_id": 1,
                "name": "菜單管理",
                "route_url": "strongadmin/adminMenu/index",
                "status": 1,
                "sort": 200,
                "created_at": "2021-01-06 03:38:18",
                "updated_at": "2021-09-18 03:06:27",
                "delete_allow": 2
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