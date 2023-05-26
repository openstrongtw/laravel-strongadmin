#### 介面版本：

|版本號|制定人|修訂日期|說明|
|:----|:----|:----   |:----|
|1.0 |Karen  |2021-10-22 |建立文件|

#### 請求URL:

- {{HOST}}/strongadmin/userinfo

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

#### 返回示例:

**正確時返回:**

```
{
    "code": 200,
    "message": "success",
    "data": {
        "id": 1,
        "user_name": "admin",
        "name": "",
        "email": "",
        "phone": "",
        "avatar": "",
        "introduction": "",
        "status": 1,
        "last_ip": "127.0.0.1",
        "last_at": "2021-10-22 11:23:21",
        "created_at": null,
        "updated_at": "2021-10-22 11:23:21",
        "roles": [
            {
                "id": 1,
                "name": "管理員",
                "pivot": {
                    "admin_user_id": 1,
                    "admin_role_id": 1
                }
            }
        ]
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