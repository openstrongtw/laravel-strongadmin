#### 介面版本：

|版本號|制定人|修訂日期|說明|
|:----|:----|:----   |:----|
|1.0 |Karen  |2021-10-25 |建立文件|

#### 請求URL:

- {{HOST}}/strongadmin/adminRole/assignPermissions

#### 請求方式：

- POST

#### 請求頭：

|參數名|是否必須|型別|說明|
|:----    |:---|:----- |-----   |
|Content-Type |是  |string |application/json   |
|Accept |是  |string |application/json   |
|Authorization|是|string|{token}|

#### 請求參數:

```
{
    "checkedData": [
        {
            "id": "1",
            "title": "許可權管理",
            "route_url": null,
            "children": [
                {
                    "id": "2",
                    "title": "菜單管理",
                    "route_url": "strongadmin/adminMenu/index",
                    "children": [
                        {
                            "id": "3",
                            "title": "列表檢視",
                            "route_url": "strongadmin/adminMenu/index"
                        }
                    ]
                }
            ]
        }
    ]
}
```


#### 返回示例:

**正確時返回:**

```
{
    "code": 200,
    "message": "common.Success"
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