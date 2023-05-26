#### 介面版本：

|版本號|制定人|修訂日期|說明|
|:----|:----|:----   |:----|
|1.0 |Karen  |2021-10-22 |建立文件|

#### 請求URL:

- {{HOST}}/strongadmin/login

#### 請求方式：

- POST

#### 請求頭：

|參數名|是否必須|型別|說明|
|:----    |:---|:----- |-----   |
|Content-Type |是  |string |application/json   |
|Accept |是  |string |application/json   |

#### 請求參數:

|參數名|是否必須|型別|說明|
|:----    |:---|:----- |-----   |
|username |是  |string |登錄名   |
|password |是  |string |登錄密碼   |
|captcha_key |是  |string |驗證碼key （請檢視 `api - 01-登錄-圖片驗證碼` 獲取）  |
|captcha |是  |string |驗證碼   |

#### 返回示例:

**正確時返回:**

```
{
    "code": 200,
    "message": "登錄成功.",
    "data": {
        "token": "Bearer ST.zgM7ukzA4ri1BqnjMGHZGmrwgLZkElHD.1634900732.2342",//登錄token；放在 header 頭使用，參數名： Authorization
        // 管理員資訊
        "adminUser": {
            "id": 1,//管理員id
            "user_name": "admin",//管理登錄名稱
            "name": "",
            "email": "",
            "phone": "",
            "avatar": "",
            "introduction": "",
            "status": 1,//狀態：1 正常，2 禁用
            "last_ip": "127.0.0.1",
            "last_at": "2021-10-22 11:05:32",
            "created_at": null,
            "updated_at": "2021-10-22 11:05:32",
            //角色資訊
            "roles": [
                {
                    "id": 1,//角色id
                    "name": "管理員",//角色名稱
                    "pivot": {
                        "admin_user_id": 1,
                        "admin_role_id": 1
                    }
                }
            ]
        }
    },
    "log": "登錄成功:admin",
    "toUrl": "http://www.strongadmin.local/strongadmin"
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