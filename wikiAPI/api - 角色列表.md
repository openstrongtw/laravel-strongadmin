#### 介面版本：

|版本號|制定人|修訂日期|說明|
|:----|:----|:----   |:----|
|1.0 |Karen  |2021-10-25 |建立文件|

#### 請求URL:

- {{HOST}}/strongadmin/adminRole/index

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
|name |否  |string |名稱   |
|desc |否  |string |角色描述   |
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
                "id": 1, //角色id
                "name": "管理員", //名稱
                "desc": "超級管理員，不可刪除", //角色描述
                "permissions": "", //擁有的許可權
                "created_at": "", //
                "updated_at": "" //
            },
            {
                "id": 2,
                "name": "demo",
                "desc": "僅作為演示",
                "permissions": "",
                "created_at": "",
                "updated_at": ""
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