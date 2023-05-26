#### 介面版本：

|版本號|制定人|修訂日期|說明|
|:----|:----|:----   |:----|
|1.0 |Karen  |2021-10-22 |建立文件|

#### 請求URL:

- {{HOST}}/strongadmin/adminUser/update

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
|id |是  |integer |管理員id   |
|user_name |是  |string |登錄名   |
|password |否  |string |登錄密碼   |
|remember_token |否  |string |記住登錄   |
|name |否  |string |姓名   |
|email |否  |string |郵箱   |
|phone |否  |string |手機號   |
|avatar |否  |string |頭像   |
|introduction |否  |string |介紹   |
|status |是  |integer |狀態 1 啟用, 2 禁用   |
|role_id |是  |array |角色id： [1,2]|

#### 返回示例:

**正確時返回:**

```
{
    "code": 200,
    "message": "common.Success",
    "data": {
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