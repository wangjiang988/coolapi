收货地址相关接口
============



1.收货地址-我的收货地址
---------------
####请求URL

> [http://xgtee.com/getUserReceiptAddrs](http://xgtee.com/getUserReceiptAddrs)
或者
> [http://xgtee.com/api?json=getUserReceiptAddrs](http://xgtee.com/api/?json=getUserReceiptAddrs)

#### 参数说明

p   ：   当前页数（get）      ``凡是有分页的的数据都有这个参数,如http://xgtee.com/api?json=getUserOrders&p=2  。就是读取第二页的数据``
 



#### 返回格式
>#####正确返回
>
      {
        "code": "200",
        "msg": "请求成功",
        "serverTime": 1472551567,
        "pager": {
            "pageSize": 10,
            "totalNum": "3",
            "totalPage": 1,
            "nowPage": 1
        },
        "data": [
            {
                "id": "1",
                "openid": "520215f41781038",
                "consignee": "收货人姓名",
                "phone": "18626210573",
                "address": "江苏省苏州市虎丘区龙景花园",
                "zip_code": "224500"
            },
       *****
         ],
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
      1.未登录获取
       {
         "code": "400",
          "msg": "未登录不允许操作",
         "serverTime": 1472551728,
         "data": "",
         "loginUser": null
       }
    2. 没有收获地址
        {
         "code": "203",
         "msg": "表中记录为空",
         "serverTime": 1472551870,
         "data": null,
         "loginUser": {
             "id": "1",
             "hand_img": "",
             "nickname": "sukai",
             "openid": "520215f41781038",
             "time": "1471059337"
            }
          }
          
2. 收货地址- 得到所有省市区信息    
--------------
http://xgtee.com/api/?json=getProvinceList  //得到省级数据
http://xgtee.com/api/?json=getCityList      //得到市级数据
http://xgtee.com/api/?json=getDistrictList  //得到区县级数据
http://xgtee.com/api/?json=getPCD           //得到所有地区信息

###说明
这几个接口是得到辅助数据，无需参数


3.收货地址- 添加用户地址
--------------
http://xgtee.com/api/?json=addReceiptAddress

###参数说明
以下是需要提交的表单数据，都是post提交，
`token` 隐藏域，       ，          
`consignee_name`  收件人名称       姓名昵称合法性，中英文，数字，还有‘-’，‘_’;     
`phone`   '收货人手机号',   支持国内手机格式   
`provinceId`  '省code',   
`cityId`  '市code',   
`districtId` '区code',   
`detailed_address`  '详细地址',   
`zip_code` varchar(6)  '邮政编码',   


###返回类型
    
####正确返回格式
    状态200的返回格式。
####错误返回
    这里只提供一个错误返回。其他返回格式。可以参照之前的接口
     1.提供的表单没有token返回。
        {
            "code": "600",
            "msg": "不安全表单提交",
            "serverTime": 1472642310,
            "data": "",
            "loginUser": {
                "id": "1",
                "hand_img": "",
                "nickname": "sukai",
                "openid": "520215f41781038",
                "time": "1471059337"
            }
        }

### 说明
    **后台对每个提交的字段都做了验证**
    

4.收货地址- 修改用户地址
--------------

http://xgtee.com/api/?json=modReceiptAddress

###参数说明
以下是需要提交的表单数据，都是post提交，
`token` 隐藏域，
`id`   地址ID           
`consignee_name`  收件人名称       姓名昵称合法性，中英文，数字，还有‘-’，‘_’;     
`phone`   '收货人手机号',   支持国内手机格式   
`provinceId`  '省code',   
`cityId`  '市code',   
`districtId` '区code',   
`detailed_address`  '详细地址',   
`zip_code` varchar(6)  '邮政编码',   


    ###返回类型
    
    ####正确返回格式
        {
            "code": "200",
            "msg": "获取成功",
            "serverTime": 1472641761,
            "data": {
            **具体看返回数据**
            },
            "loginUser": {
                "id": "1",
                "hand_img": "",
                "nickname": "sukai",
                "openid": "520215f41781038",
                "time": "1471059337"
            }
        }
    ####错误返回
        不提供 ，跟上面差不多

### 说明
    **后台对每个提交的字段都做了验证**
    
    
5.收货地址- 删除用户地址
--------------
http://xgtee.com/api/?json=removeReceiptAddress

###参数说明，
`id` --  地址ID   --- get or post       

    ###返回类型
    
    ####正确返回格式
        {
            "code": "200",
            "msg": "获取成功",
            "serverTime": 1472641761,
            "data": {
            **具体看返回数据**
            },
            "loginUser": {
                "id": "1",
                "hand_img": "",
                "nickname": "sukai",
                "openid": "520215f41781038",
                "time": "1471059337"
            }
        }
    ####错误返回
        不提供 

### 说明
   **只可以删除自己的地址**


          
6.收货地址--设置用户默认收货地址
------------
http://xgtee.com/api/?json=setDefaultReceiptAddress
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|id  |  yes |get or post| 要设置成当前用户默认收货地址的地址ID|

###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            "data": {
                "token": "MWNIDGtgvUcmwLGj50Wvd0pgcsIbQuX7D-WN-xbf9A6Qyw-SrycEfCBTeI3W8y_EgCI"
            },
            "loginUser": {
                "id": "1",
                "hand_img": "",
                "nickname": "sukai",
                "openid": "520215f41781038",
                "time": "1471059337"
            }
        }

     ####错误返回格式不再提供
### 说明
    **非当前登录账号的地址，不可设置**
            
7.收货地址- 得到用户默认收货地址
------------
http://xgtee.com/api/?json=getDefaultReceiptAddress

###参数说明
无

###返回类型
    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "data": {
                "id": "2",
                "openid": "520215f41781038",
                "consignee_name": "_az01-王明",
                "phone": "18626210573",
                "province": "1",
                "city": "2",
                "area": "1",
                "detailed_address": "hellow",
                "zip_code": "2245",
                "default_state": "1"
            },
            "loginUser": {
                "id": "1",
                "hand_img": "http://localhost/xiagao/Public/upload/head_img/05265738498443509.png",
                "nickname": "黄晓明",
                "openid": "520215f41781038",
                "time": "1471059337"
            },
            "serverTime": 1473240558
        }

     ####错误返回格式不再提供
### 说明
**需要登录后操作。**
          
