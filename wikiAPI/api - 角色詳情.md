#### 介面版本：

|版本號|制定人|修訂日期|說明|
|:----|:----|:----   |:----|
|1.0 |Karen  |2021-10-25 |建立文件|

#### 請求URL:

- {{HOST}}/strongadmin/adminRole/show

#### 請求方式：

- GET

#### 請求頭：

|參數名|是否必須|型別|說明|
|:----    |:---|:----- |-----   |
|Content-Type |是  |string |application/json   |
|Accept |是  |string |application/json   |
|Authorization|是|string|{token}|

#### 請求參數:

|參數名|是否必須|型別|說明|
|:----    |:---|:----- |-----   |
|id |是  |integer |角色id   |

#### 返回示例:

**正確時返回:**

```
{
    "code": 200,
    "message": "common.Success",
    "data": {
        "id": 1, //角色id
        "name": "管理員", //名稱
        "desc": "超級管理員，不可刪除", //角色描述
        "permissions": "", //擁有的許可權
        "created_at": "", //
        "updated_at": "" //
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