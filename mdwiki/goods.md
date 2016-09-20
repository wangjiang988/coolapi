商品相关接口
============


1.商品-首页显示商品分类
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

2. 商品-商品分类页
------------
http://xgtee.com/api/?json=getGoodsListByCategory
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|id  |  yes |get or post| 商品分类ID||

###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            "data": {
                **商品列表**
            },
            "loginUser": {
                "id": "1",
                "hand_img": "",
                "nickname": "sukai",
                "openid": "520215f41781038",
                "time": "1471059337"
            }
            "category":{
                 **类别列表**   
            }
        }

     ####错误返回格式不再提供
### 说明
    **下架了，则查询不出来**


3. 商品-商品详情页
------------
http://xgtee.com/api/?json=getGoods
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|id  |  yes |get or post| 商品ID||

###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            "data": {
                **商品明细**
            "loginUser": {
                "id": "1",
                "hand_img": "",
                "nickname": "sukai",
                "openid": "520215f41781038",
                "time": "1471059337"
            }
            "category":{
                **类别信息** 
            }
        }

     ####错误返回格式不再提供
### 说明
    **商品 或者商品所属类别下架的，不能查询**


 4.商品-搜索
------------
http://xgtee.com/api/?json=search
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|keywords  |  yes |get|查询的商品名称，模糊查询，只与商品名进行匹配|
|p  |  no |get|分页的页数|


###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            "pager":{
                .....
            }
            "data": {
                **商品列表**
            },
            "loginUser":  NULL
        }

     ####错误返回格式不再提供
### 说明
    无   
    
    
 5.商品-插入商品定制信息
------------
http://xgtee.com/api/?json=addGoodsInfo
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|token  |  yes |post|token|
|type  |  yes |post|定制信息类型  只能是三种 'crafts','detail','material' 其中一个|
|goods_id  |  yes |post|商品ID|
|content  |  yes |post|定制内容|
|price  |  yes |post|定制价格|

###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            "data": {
               "id": 4, //对应表中的记录ID
               "type": "material"
            },
            "loginUser":  NULL
        }

     ####错误返回格式不再提供
### 说明
    无   
  
  
6.商品-得到商品的定制信息
------------
http://xgtee.com/api/?json=getGoodsInfo
###参数说明
|字段名|是否必须|method|字段说明|
|   :|     :|     :|   :|
|goods_id  |  yes |get|商品ID|

###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
            "data": {
               "id": 4, //对应表中的记录ID
               "type": "material"
            },
            "loginUser":  NULL
        }

     ####错误返回格式不再提供
### 说明
    无   
    
7.商品-热销商品
------------
http://xgtee.com/api/?json=getHotGoodsList
###参数说明
无

###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "请求成功",
            "serverTime": 1472641761,
             "pager": {
                "pageSize": 10,
                "totalNum": "3",
                "totalPage": 1,
                "nowPage": 1
            },
            "data": {
               **
            },
            "loginUser":  NULL
        }

     ####错误返回格式不再提供
### 说明
    无   
      
        
