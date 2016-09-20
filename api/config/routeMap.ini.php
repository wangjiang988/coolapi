<?php
return array(
    ###个人中心接口
    'login'                =>    array( "act"=>"user", "op"=>"login"),
    'logout'               =>    array( "act"=>"user", "op"=>"logout"),
    'getUser'              =>    array( "act"=>"user", "op"=>"getUser"),
    //个人信息修改
    'editUserInfo'         =>    array( "act"=>"user", "op"=>"editUserInfo"),
    //上传个人头像
    'uploadHeadImg'        =>    array( "act"=>"user", "op"=>"uploadHeadImg"),
    
    'getUserReceiptAddrs'  =>    array( "act"=>"user", "op"=>"getUserReceiptAddrs"),
    //我的订单列表
    'getUserOrders'        =>    array( "act"=>"user", "op"=>"getUserOrders"),
    //查看订单明细   
    'getUserOrderDetail'   =>    array( "act"=>"user", "op"=>"getUserOrderDetail"),
    //得到优惠码
    'getPercentCode'       =>    array( "act"=>"order", "op"=>"getPercentCode"),
    //查看购物车
    'getUserShopCart'      =>    array( "act"=>"user", "op"=>"getUserShopCart"),
    //加入购物车 
    'addToShopCart'        =>    array( "act"=>"user", "op"=>"addToShopCart"),
    
    //编辑购物车
    'editUserShopCart'     =>    array( "act"=>"user", "op"=>"editUserShopCart"),
    //删除购物车商品
    'delUserShopCart'      =>    array( "act"=>"user", "op"=>"delUserShopCart"),
    
    ###地址相关接口
     //根据地址ID得到当前用户收获地址
    'getReceiptAddress'    =>    array( "act"=>"address", "op"=>"getAddress"),
     //得到当前登录用户默认收货地址
    'getDefaultReceiptAddress'    =>    array( "act"=>"address", "op"=>"getDefaultAddress"),
     //得到所有省市区信息      
    'getProvinceList'     =>    array( "act"=>"address", "op"=>"getProvinceList"),
    'getCityList'         =>    array( "act"=>"address", "op"=>"getCityList"),
    'getDistrictList'     =>    array( "act"=>"address", "op"=>"getDistrictList"),
    'getPCD'              =>    array( "act"=>"address", "op"=>"getPCD"),
      
    
    //添加用户地址
    'addReceiptAddress'   =>    array( "act"=>"address", "op"=>"addReceiptAddress"),
    //修改用户地址
    'modReceiptAddress'   =>    array( "act"=>"address", "op"=>"modReceiptAddress"),
    //删除用户地址
    'removeReceiptAddress'=>    array( "act"=>"address", "op"=>"removeReceiptAddress"),
    //设置默认收货地址
    'setDefaultReceiptAddress'=>array( "act"=>"address", "op"=>"setDefaultReceiptAddress"),

    ###首页
    'getBannerList'      =>    array( "act"=>"home", "op"=>"getBannerList"), 
    'getCatorgyList'     =>    array( "act"=>"home", "op"=>"getCategoryList"),     
    
    ###列表页
    'getGoodsListByCategory' =>    array( "act"=>"goods", "op"=>"getGoodsByCategory"), 
    ###详情页
    'getGoods'             =>        array( "act"=>"goods", "op"=>"getGoods"),
    ###查询商品
    'search'               =>     array( "act"=>"goods", "op"=>"search"),   
    ###得到热销产品
    'getHotGoodsList'      =>     array("act"=>"goods", "op"=>"getHotGoodsList"),   
    
    
    ###得到用户的微信信息
    'getUserWxInfo'        =>     array('act'=>'user' , 'op'=>'getUserWxInfo' ),
    'initUser'             =>     array('act'=>'user' , 'op'=>'initUser' ),
    
    ###其他
    //表单提交csrf获取
    //不需要登录状态就可以获取
    'getCsrfToken'         =>    array( "act"=>"address", "op"=>"getCsrf"),
    
    ###订单
    //创建订单
    'createOrder'          =>    array( "act"=>"order", "op"=>"createOrder"),
    //修改订单状态
    'changOrderState'      =>    array( "act"=>"order", "op"=>"changOrderState"),
    //订单退款
    'refundOrder'          =>    array(  "act"=>"order", "op"=>"refundOrder"),
    //多个产品一起发订单的时候，先获取一个order_id
    'generateOrderId'      =>    array( "act"=>"order", "op"=>"generateOrderId"),
    
    //插入订单定制信息
    'addGoodsInfo'         =>    array( "act"=>"goods", "op"=>"addGoodsInfo"),
    'getGoodsInfo'         =>    array( "act"=>"goods", "op"=>"getGoodsInfo"),
    
    //支付接口
    "jsapi"                =>    array( "act"=>"wx", "op"=>"getJsapi"),
    
    #快递信息查询
    "getKuaidiInfo"                =>    array( "act"=>"order", "op"=>"getKuaidiInfo"),
);
?>