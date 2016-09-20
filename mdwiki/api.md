**接口文档**
=============

根据类别接口文档地址
http://xgtee.com/apidoc/#!all.md
每日跟新列表
http://xgtee.com/apidoc/#!20160831.md
http://xgtee.com/apidoc/#!20160901.md
http://xgtee.com/apidoc/#!20160902.md
http://xgtee.com/apidoc/#!20160905.md
http://xgtee.com/apidoc/#!20160906-07.md
http://xgtee.com/apidoc/#!20160908.md

## 概述
###1. 接口返回格式

    {
    "code": "101",
    "msg": "返回成功",
    "serverTime": 1472478824,  //请求时间
    "pager": {     //如果有分页就是有这个pager对象
        "pageSize": 10,
        "totalNum": "3",
        "totalPage": 1,
        "nowPage": 1
    },
    "data":[    
            **数据列表**
            ],
    "loginUser": {
        "id": "1",
        "hand_img": "",
        "nickname": "sukai",
        "openid": "520215f41781038",
        "time": "1471059337"
    }
     "category" [          //如果查询某个类目的商品，则类目信息会在这里
              **类目信息**  
            ],
    }

###2. 返回代码说明
 


 |code|msg|值说明|
 |:----:|:-----:|:-----|
 |10*|| 路由错误|
 |200 ||返回成功|
 |30*| | 参数错误|
 |40*|| 数据查询错误|
 |50*||程序内部错误|

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1514160-5eb5bbbc4ce7970f.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


 

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
 



#### 返回格式
>#####正确返回
>
     {
        "code": "200",
         "msg": "请求成功",
        "serverTime": 1472551137,
        "data": "",
        "loginUser": null
    }

>##### 错误返回
>
      暂无


## 3. 我的信息-收货地址
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

## 4. 我的信息-我的订单
####请求URL

> [http://xgtee.com/getUserOrders](http://xgtee.com/getUserOrders)
或者
> [http://xgtee.com/api?json=getUserOrders](http://xgtee.com/api/?json=getUserOrders)

#### 参数说明
p   ：   当前页数（get）      ``凡是有分页的的数据都有这个参数,如http://xgtee.com/api?json=getUserOrders&p=2  。就是读取第二页的数据``

 
 



#### 返回格式
>#####正确返回
>
      {
        "code": "200",
        "msg": "请求成功",
        "serverTime": 1472552070,
        "pager": {
            "pageSize": 10,
            "totalNum": "6",
            "totalPage": 1,
            "nowPage": 1
        },
        "data": [
            {
                "id": "1",
                "order_id": "201608120001",
                "openid": "520215f41781038",
                "generate_time": null,
                "preview_url": null,
                "goods_name": "窗帘",
                "style": "1",
                "price": "59",
                "num": "25",
                "order_state": "未付款",
                "preferential_code": "1001",
                "receipt_address": "苏州市东南大学305室",
                "receipt_people": "苏凯",
                "zip_code": "225000",
                "logistics": null,
                "logistics_id": "150215489808",
                "refund_status": null,
                "size": "M",
                "words": null,
                "technology": "数码喷绘：精细还原图形细节",
                "material": "标准版：日本进口150克纯棉",
                "gift_boxes": "是",
                "color": null,
                "updowncode": null,
                "leftrightcode": null,
                "rotationcode": null,
                "bigsmallcode": null,
                "font": null,
                "details": "袖部细节",
                "phone": "1352565256",
                "time": "1472260880"
            },
                ******
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


## 5. 我的信息-购物车
####请求URL

> [http://xgtee.com/getUserShopCart](http://xgtee.com/getUserShopCart)
或者
> [http://xgtee.com/api?json=getUserShopCart](http://xgtee.com/api/?json=getUserShopCart)

#### 参数说明
p   ：   当前页数（get）      ``凡是有分页的的数据都有这个参数,如http://xgtee.com/api?json=getUserShopCart&p=2  。就是读取第二页的数据``

 
 



#### 返回格式
>#####正确返回
>
      {
        "code": "200",
        "msg": "请求成功",
        "serverTime": 1472552070,
        "pager": {
            "pageSize": 10,
            "totalNum": "6",
            "totalPage": 1,
            "nowPage": 1
        },
        "data": [
               {
                  "id": "1",
                  "openid": "520215f41781038",
                  "count": "1",
                  "price": "20.00",
                  "collection": "",
                  "size": "s",
                  "literal": "",
                  "crafts": "",
                  "material": "",
                  "gift_boxes": "",
                  "color": "",
                  "updowncode": null,
                  "leftrightcode": null,
                  "rotationcode": null,
                  "bigsmallcode": null,
                  "font": "",
                  "goodsInfo": {
                      "id": "2",
                      "goods_name": "鞋子",
                      "goods_img": "2016-08-12/57ad72bfa4826.jpg",
                      "goods_price": "20",
                      "goods_stock": "100",
                      "freight": "6.00",
                      "details": null,
                      "agents_id": null,
                      "cate_id": "1",
                      "promotion": "0",
                      "promotion_price": "18.00",
                      "man_model": "1",
                      "female_model": "1",
                      "child_model": null,
                      "default_image": null,
                      "goods_cut": null,
                      "state": "1",
                      "goods_custom": null,
                      "custom_img": null,
                      "custom_gift": null,
                      "s_model": "0",
                      "m_model": "0",
                      "l_model": "0",
                      "xl_model": "1",
                      "xxl_model": "0",
                      "xxxl_model": "0",
                      "sales": "88"
                  }
              }
                ******
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
          
          
          
          
          
          
          
 *****2016-8-31更新*****
------------------------


1. 获取csrf Token接口
------------
http://xgtee.com/api/?json=getCsrfToken
###参数说明
无

###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "获取成功",
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

                   错误返回格式不在提供
### 说明
    **这个接口在进入凡是表单的页面中 ，需要将token写在隐藏域中的。**
    **不需要登录状态就可以获取**
    **用来防止csrf攻击和重复提交表单。**


2. 得到所有省市区信息    
--------------
http://xgtee.com/api/?json=getProvinceList  //得到省级数据
http://xgtee.com/api/?json=getCityList      //得到市级数据
http://xgtee.com/api/?json=getDistrictList  //得到区县级数据
http://xgtee.com/api/?json=getPCD           //得到所有地区信息

###说明
这几个接口是得到辅助数据，无需参数


3.添加用户地址
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
    

4.修改用户地址
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
    
    
5.删除用户地址
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




6.首页-幻灯片
--------------
http://xgtee.com/api/?json=getBannerList

###参数说明，
无    

###返回类型
  
    ####正确返回格式
      200
         
         
    ####错误返回
      203 无数据   


7.首页-首页显示分类
--------------
http://xgtee.com/api/?json=getCatorgyList

###参数说明，
无    

###返回类型
  
    ####正确返回格式
      200
         
         
    ####错误返回
      203 无数据   


###说明
**取的是后台启用的分类**

