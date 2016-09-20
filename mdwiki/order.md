订单相关接口
============


1. 订单-生成订单号
------------
http://xgtee.com/api/?json=generateOrderId
###参数说明
无


###返回类型
    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            
            "data": {
                ***orderid***
            },
            "loginUser":  
               **用户信息**
        }

     ####错误返回格式不再提供
### 说明
**此接口需登录后操作**
**这个接口的应用场景是在一个订单里边提交有多个商品的时候，先在通过这个接口申请一个订单ID，由于订单表一个记录只能记录一个商品，**
**所以这边多个商品的订单需要一次一次请求http://xgtee.com/api/?json=createOrder  这个接口。在多次请求的时候，将这个请求的订单ID一起发送过去，并为一个订单。**


2.订单-修改订单状态
-----------
http://xgtee.com/api/?json=changOrderState
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|order_id |  yes | get or post |订单编号|
|order_state |  yes | get or post |修改后的状态 (0未付款1已接单2已生产3已发货4已签收5已退款) 注：只能是这5个数字|

###返回类型
    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            
            "data": {
               
            },
            "loginUser":  
               **用户信息**
        }
     ####错误返回格式不再提供
### 说明
**使用场景：支付成功，收货等等**
**需登录后操作，非登录账户订单不能操作，无需token**


## 3. 订单-我的订单列表
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

4. 订单 - 我的订单明细
------------
http://xgtee.com/api/?json=getUserOrderDetail
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|order_id  |  yes |get or post|查询的订单ID|


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
    

5. 订单 - 生成（创建）订单
------------
http://xgtee.com/api/?json=createOrder

###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|order_id  |  no | post|如果是多个产品一起提交的订单，则需要去http://xgtee.com/api/?json=generateOrderId 这个接口去申请一个order_id,然后在生成订单的时候一起提交过来|
|token  |  yes | post|token|
|preview_url  |  yes | post|预览图URL|
|goods_id  |  yes | post|商品ID,传递过来用来判断库存|
|goods_name  |  yes | post|商品名称|
|style  |  yes | post|款式|
|price  |  yes | post|订单价格|
|num  |  yes | post|订单数量|
|preferential_code  |  yes | post|优惠码|
|receipt_address  |  yes | post|收货地址|
|receipt_people   |  yes | post|收货人姓名|
|phone   |  yes | post|收货人电话|
|receipt_people   |  yes | post|收货人姓名|
|zip_code  |  yes | post|邮政编码|
|size  |  yes | post|尺码|
|words  |  yes | post|文字|
|technology  |  yes | post|工艺|
|material  |  yes | post|材质|
|gift_boxes  |  yes | post|礼品盒|
|color  |  yes | post|颜色|
|updowncode  |  yes | post|上下值|
|leftrightcode  |  yes | post|左右值|
|rotationcode  |  yes | post|旋转值|
|bigsmallcode  |  yes | post|大小值|
|font  |  yes | post|字体|
|details  |  yes | post|细节|
|rotationcode  |  yes | post|旋转值|

###返回类型
    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            
            "data": {
                id :  '订单ID',
                'order_id' : '订单编号',
            },
            "loginUser":  
               **用户信息**
        }

     ####错误返回格式不再提供
### 说明
**需要登录后操作。**


6.订单- 确认退款
------------
http://xgtee.com/api/?json=refundOrder

###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|order_id  |  yes | get or post|订单编号|
|total_fee  |  yes | post|订单金额  单位分|
|refund_fee  |  yes | post|退款金额 单位分|

###返回类型
    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "data": "退款结果",
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
**需要登录后操作。不需要token，只退款，不修改订单状态**


7.订单- 微信支付
------------
http://xgtee.com/api/?json=jsapi

###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|order_id  |  yes |  post|订单编号|
|price  |  yes |  post|付款金额，单位为分，如10块钱，则传入1000|
|goods_attach  |  yes |  post| 商品附属信息。不能为空，字符串|
|goods_name  |  yes |  post| 商品名称。不能为空，字符串|





###返回类型
    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "data": null,
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
**需要登录后操作。不需要token**


8.订单- 优惠码接口
------------
http://www.xgtee.com/api/?json=getPercentCode&code=Y0012

###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|code  |  yes |  post or get|优惠码 字符串|





###返回类型
    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "data": **,
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
**需要登录后操作。不需要token**
