用户相关接口
============


##个人中心
## 1. 登录
####请求URL

> [http://xgtee.com/login](http://xgtee.com/login)
或者
> [http://xgtee.com/api?json=login](http://xgtee.com/api/?json=login)

#### 参数说明
id 或（openid）  :  用户ID 或者openid : GET
**通过请求openid获取，目前写死,暂时不需要这个参数**
 



#### 返回格式
>#####正确返回
>
     {
      "code": "201",
      "msg": "登录成功",
      "serverTime": 1472550917,
      "data": "",
      "loginUser": {
          "id": "1",
          "hand_img": "",
          "nickname": "sukai",
          "openid": "520215f41781038",
          "time": "1471059337"
        }
    }

>##### 错误返回
>
      暂无

## 2. 登出
####请求URL

> [http://xgtee.com/logout](http://xgtee.com/logout)
或者
> [http://xgtee.com/api?json=logout](http://xgtee.com/api/?json=logout)

#### 参数说明

**无**


3. 微信-  微信授权登录
------------
http://xgtee.com/api/?json=getUserWxInfo
###参数说明
无



###返回类型
    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            "data": {
                id :  1  //表中的用户ID
                *****    //其余为微信用户信息.
            },
            "loginUser":  
               **用户信息**
        }

     ####错误返回格式不再提供
### 说明
          获取用户微信账号，如果没有在本系统中注册，则注册并返回。如果已经注册 直接返回，并返回用户ID

 
 
4. 用户-编辑用户信息   
------------
http://xgtee.com/api/?json=editUserInfo
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|hand_img  |  no |  post|头像链接，地址要写全|
|nickname  |no   | post|昵称|
|token  |no   | post|token|


###返回类型
    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            
            "data": {
                true
            },
            "loginUser":  
               **用户信息**
        }

     ####错误返回格式不再提供
### 说明
**此接口需登录后操作**

5. 用户-上传用户头像
------------
http://xgtee.com/api/?json=uploadHeadImg
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|head_img  |  yes |  file|intput file  文件名|



###返回类型
    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            
            "data": {
                true
            },
            "loginUser":  
               **用户信息**
        }

     ####错误返回格式不再提供
### 说明
**此接口  不需要token。但是需要登录后操作。**

 