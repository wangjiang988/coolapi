购物车相关接口
============


1.购物车-我的购物车
-------------
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
          
2.购物车 -添加到我的购物车
------------

http://xgtee.com/api/?json=addToShopCart
###参数说明
购物车表的字段和token字段，并且提交方法为post 

`购物车字段`

![Paste_Image.png](http://xgtee.com/apidoc/image/20160912224404.png)    


token  字段必须

 `红箭头指向的字段，不是必须传的字段`。

###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            "data": {
                **订单明细**
            },
            "loginUser":  {
                "id": "1",
                "hand_img": "",
                "nickname": "sukai",
                "openid": "520215f41781038",
                "time": "1471059337"
            }
        }

     ####错误返回格式不再提供
### 说明
   **需要是登录后操作** 


3. 购物车 -  编辑我的购物车(数量必须)
------------
http://xgtee.com/api/?json=editUserShopCart
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|id  |  yes |get or post|查询的商品在购物车表的ID，注  不是商品ID|
|count|  yes |get or post|修改后的数量 必须|
|size  |  no |get or post|修改后的尺码|
|collection|no|get or post|修改后的款式|


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
    无    

4. 购物车 -  删除我的购物车商品
------------
http://xgtee.com/api/?json=delUserShopCart
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|id  |  yes |get or post|查询的商品在购物车表的ID，注  不是商品ID|


###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            "data": {
                result : true
            },
            "loginUser":  
               **用户信息**
        }

     ####错误返回格式不再提供
### 说明
    无    
