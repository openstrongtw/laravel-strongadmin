#### 介面版本：

|版本號|制定人|修訂日期|說明|
|:----|:----|:----   |:----|
|1.0 |Karen  |2021-10-22 |建立文件|

#### 請求URL:

- {{HOST}}/strongadmin/adminUser/index

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
|user_name |否  |string |登錄名   |
|password |否  |string |登錄密碼   |
|name |否  |string |姓名   |
|email |否  |string |郵箱   |
|phone |否  |string |手機號   |
|avatar |否  |string |頭像   |
|introduction |否  |string |介紹   |
|status |否  |integer |狀態 1 啟用, 2 禁用   |
|last_ip |否  |string |最近一次登錄ip   |
|last_at |否  |date |最近一次登錄時間   |
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
                "id": 1, //管理員id
                "user_name": "admin", //登錄名
                "name": "", //姓名
                "email": "", //郵箱
                "phone": "", //手機號
                "avatar": "", //頭像
                "introduction": "", //介紹
                "status": 1, //狀態 1 啟用, 2 禁用
                "last_ip": "127.0.0.1", //最近一次登錄ip
                "last_at": "2021-10-21 07:17:35", //最近一次登錄時間
                "created_at": "", //
                "updated_at": "2021-10-21 07:17:35" //
            },
            {
                "id": 2,
                "user_name": "demo",
                "name": "",
                "email": "",
                "phone": "",
                "avatar": "",
                "introduction": "",
                "status": 1,
                "last_ip": "",
                "last_at": "",
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