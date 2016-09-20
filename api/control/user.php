<?php
/**
 * 权限管理
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2015-2016 wj (###)
 * @license    ###
 * @link       ###
 * @since      File available since Release v1.1
 */
defined('CoolAPI') or exit('Access Invalid!');

class userControl extends SystemControl{
	 
	public function __construct(){
		parent::__construct();
		Language::read('index,error');
	}

	
	/**
	 * 登录Op
	 */
	public function loginOp()
	{
	    $wxApi    =  new WxApi();
// 	    d($wxApi);die;
	    if(getSession('loginUser')){
	        setSession('loginUser', NULL);
	    }
	    
	    //openid先固定
	    if(isset($_GET['id'])){
	        //如果已经登录，取消登录状态，重新登录
	        $loginUser =  Model('user')->getUserByID($_GET['id']);
	        if($loginUser){
	            setSession('loginUser',json_encode($loginUser));
	            ajaxReturn(L('E201'),201);
	        }else{
	            ajaxReturn(L('E401'),401);
	        }
	    }else{
	        $openid  = $_GET['openid'];
	        if(empty($openid)) $openid ='520215f41781038';
	        //如果已经登录，取消登录状态，重新登录
	        
	        $loginUser =  Model('user')->getUserInfo(array('openid'=>$openid));
	        if($loginUser){
	            setSession('loginUser',json_encode($loginUser));
	            ajaxReturn(L('E201'),201);
	        }else{
	            ajaxReturn(L('E401'),401);
	        }
	    }
	}
	
	/**
	 * 登出
	 */
	
	public function logoutOp()
	{
	    setSession('loginUser', NULL);
	    ajaxReturn(L('E200'),200);
	}
	/**
	 *  首页
	 */
	public function getUserOp(){
	    
	     Validator::has($this->getRequest()->id);
	     Validator::isNumber($this->getRequest()->id,'int');
	     
	     $model     =    Model('user');
	     $userinfo  =    $model->getUserByID($this->getRequest()->id);
	     if($userinfo){
	         ajaxReturn(L('E200'),'200',$userinfo);
	     }else {
	         ajaxReturn('id='.$this->getRequest()->id.':'.L('E404'),'404','');
	     }
	}
	
	/**
	 * 根据用户OPENID 得到用户的收货地址
	 */
	
	public function getUserReceiptAddrsOp()
	{
	    $loginUser   =  $this->checkLogin();
        $model      =  Model('receiptAddress');
        $addrs      =  $model->getAddresListByOpenId($loginUser['openid'],10);// 目前每页显示10条数据
        $pager      =  $model->getPager();
        
        if(empty($addrs)) ajaxReturn(L('E203'),203,null);
        $list      =  array();
        foreach ($addrs as $addr)
        {
            $p = Model('province')->getNameById($addr['province']);
            $c = Model('city')->getNameById($addr['city']);
            $d = Model('district')->getNameById($addr['area']);
            $tmp['id']        =  $addr['id'];
            $tmp['openid']    =  $addr['openid'];
            $tmp['consignee'] =  $addr['consignee_name'];
            $tmp['phone']     =  $addr['phone'];
            $tmp['provinceId']=  $addr['province'];
            $tmp['cityId']    =  $addr['city'];
            $tmp['districtId']=  $addr['area'];
            $tmp['address']   =  $p.$c.$d.$addr['detailed_address'];
            $tmp['zip_code']  = $addr['zip_code'];;
            $tmp['default_state']  = $addr['default_state'];;
            $list[]           = $tmp;
        }
        ajaxReturn(L('E200'),'200',$list,$pager);
	}
	
	/**
	 * 我的订单
	 */
    public function getUserOrdersOp()
    {
        $loginUser   =  $this->checkLogin();
	    
	    
        $model      =  Model('order');
        $field      =  'id,goods_name,style,order_id,openid,order_state,size,technology,material,gift_boxes,num,price';
        $orders     =  $model->getOrderListByOpenId($loginUser['openid'],10,$field);//目前每页显示10条数据
        $pager      =  $model->getPager();
        
        if(empty($orders)) ajaxReturn(L('E203'),203,null);
        $list      =  array();
        foreach ($orders as $order)
        {
            $order['order_state'] =    $this->_getOrderState($order['order_state']);  
            $list[]               =    $order;
        }
        ajaxReturn(L('E200'),'200',$list,$pager);
    }
    
    /**
     * 根据订单ID 得到订单
     */
    public function getUserOrderDetailOp()
    {
        $loginUser   =   $this->checkLogin();
        $id         =  isset($_GET['order_id'])?$_GET['order_id']:$_POST['order_id'];
        Validator::has($id,'order_id');
//         Validator::isNumber($id,'int','order_id');
        
        $model       =   Model('order');
        $order       =   $model->getUserOrderById($id,$loginUser);
        
        if(empty($order)) ajaxReturn(L('E203'),203,null);
        
        ajaxReturn(L('E200'),'200',$order);
    }
    
    
    /**
     * 返回order_state中文
     */
    private function _getOrderState($state)
    {
         Language::read('order');
         return L('O'.$state);
    }
    
    /**
     * 我的购物车
     */
    public function getUserShopCartOp()
    {
         $loginUser  =  $this->checkLogin();
        
         $model      =  Model('shopCart');
         $products   =  $model->getProductsFromCartByOpenId($loginUser['openid'],10);//目前每页显示10条数据
         $pager      =  $model->getPager();
         
         $list       =  array();
         foreach ($products as $product)
         {
             if($product['crafts_id'])
                 $product['craftsInfo']  = Model('crafts')->getById($product['crafts_id']);
             if($product['material_id'])
                 $product['materialInfo']  = Model('material')->getById($product['material_id']);
             if($product['detail_id'])
                 $product['detailInfo']  = Model('detail')->getById($product['detail_id']);
             $p                    =    Model('goods')->getGoodsById($product['goods_id']);
             unset($product['goods_id']);
             $product['goodsInfo'] =    $p;
             $list[]               =    $product;
         }
         
         if(empty($products)) ajaxReturn(L('E203'),203,null);
         ajaxReturn(L('E200'),'200',$list,$pager);
    }
    
    /**
     * 添加商品到购物车
     */
    public function addToShopCartOp()
    {
        $loginUser  =   $this->checkLogin();
        
        $post      =  $this->getRequest()->post;
        //判断是否重复提交表单,防止csrf;
        if(isset($post['token']))
        {
            $this->checkToken($post['token']);
        }else{
            ajaxReturn(L('E600'),600);
        }
        
        
        $info                 =   array();
        $info['openid']       =   $loginUser['openid'];
        $info['goods_id']     =   Validator::isNumber($post['goods_id'],'int','goods_id');
        $info['count']        =   Validator::isNumber($post['count'],'int','count');
        $info['price']        =   Validator::isNumber($post['price'],'all','price');
        $info['collection']   =   Validator::has($post['collection'],'collection');
        $info['size']         =   Validator::has($post['size'],'size');
        $info['literal']      =   Validator::has($post['literal'],'literal');
        if(isset($post['crafts_id']))
            $info['crafts_id']    =   Validator::isNumber($post['crafts_id'],'int','crafts_id');
        $info['crafts']       =   Validator::has($post['crafts'],'crafts');
        $info['crafts_price'] =   Validator::has($post['crafts_price'],'crafts_price');
        if(isset($post['material_id']))
            $info['material_id']    =   Validator::isNumber($post['material_id'],'int','material_id');
        $info['material']     =   Validator::has($post['material'],'material');
        $info['material_price']     =   Validator::has($post['material_price'],'material_price');
        $info['gift_boxes']   =   Validator::has($post['gift_boxes'],'gift_boxes');
        $info['gift_boxes_price']   =   Validator::has($post['gift_boxes_price'],'gift_boxes_price');
        if(isset($post['detail_id']))
            $info['detail_id']    =   Validator::isNumber($post['detail_id'],'int','detail_id');
        $info['detail']   =   Validator::has($post['detail'],'detail');
        $info['detail_price']   =   Validator::has($post['detail_price'],'detail_price');
        $info['color']        =   Validator::has($post['color'],'color');
        $info['updowncode']   =   Validator::has($post['updowncode'],'updowncode');
        $info['leftrightcode']=   Validator::has($post['leftrightcode'],'leftrightcode');
        $info['bigsmallcode'] =   Validator::has($post['bigsmallcode'],'bigsmallcode');
        $info['rotationcode'] =   Validator::has($post['rotationcode'],'rotationcode');
        $info['font']         =   Validator::has($post['font'],'font');
        
        $result  =  Model('shopCart')->addToCart($info);
 	    if($result['id']) ajaxReturn(L('E200'),'200',$result);
 	    else ajaxReturn(L('E602'),'602',$result);
    }
    
    /**
     * 编辑我的购物车
     */
    public function editUserShopCartOp()
    {
        $loginUser  =      $this->checkLogin();
        
        $id         =      isset($_GET['id'])?$_GET['id']:$_POST['id'];
        $id         =      Validator::isNumber($id,'int','id');
        
        $num        =      isset($_GET['count'])?$_GET['count']:$_POST['count'];
        $count      =      Validator::isNumber($num,'int','count');
        $size       =      isset($_GET['size'])?$_GET['size']:$_POST['size'];
        $collection =      isset($_GET['collection'])?$_GET['collection']:$_POST['collection'];
        
        
        $cartGoods  =      Model('shopCart')->getById($id);
                    
        if($cartGoods['result']['openid']  !=  $loginUser['openid'])
        {
            ajaxReturn('E404',404);
        }
        
        $where      =      array('id'=>$id);
        $update     =      array(
            'count'  =>  $count,
        );
        if(!empty($size))        $update['size']        =  $size;
        if(!empty($collection))  $update['collection']  =  $collection;
        
        $post      =  $this->getRequest()->post;
        
        if(!empty($post['price']))  $update['price']  = Validator::isNumber($post['price'],'all','price');
        if(!empty($post['size']))   $update['size']  =  Validator::has($post['size'],'size');
        if(!empty($post['literal']))   $update['literal']  = Validator::has($post['literal'],'literal');
        if(!empty($post['crafts_id']))   $update['crafts_id']  = Validator::isNumber($post['crafts_id'],'int','crafts_id');
        if(!empty($post['crafts']))   $update['crafts']  =  Validator::has($post['crafts'],'crafts');
        if(!empty($post['crafts_price']))   $update['crafts_price']  = Validator::has($post['crafts_price'],'crafts_price');
        if(isset($post['material_id']))
            $update['material_id']    =   Validator::isNumber($post['material_id'],'int','material_id');
        if(isset($post['material']))
            $update['material']     =   Validator::has($post['material'],'material');
        if(isset($post['material_price']))     $update['material_price']     =   Validator::has($post['material_price'],'material_price');
        if(isset($post['gift_boxes']))    $update['gift_boxes']   =   Validator::has($post['gift_boxes'],'gift_boxes');
        if(isset($post['gift_boxes_price']))    $update['gift_boxes_price']   =   Validator::has($post['gift_boxes_price'],'gift_boxes_price');
        if(isset($post['detail_id']))
            $update['detail_id']    =   Validator::isNumber($post['detail_id'],'int','detail_id');
        if(isset($post['detail']))     $update['detail']   =   Validator::has($post['detail'],'detail');
        if(isset($post['detail_price']))      $update['detail_price']   =   Validator::has($post['detail_price'],'detail_price');
        if(isset($post['color']))    $update['color']        =   Validator::has($post['color'],'color');
        if(isset($post['updowncode']))     $update['updowncode']   =   Validator::has($post['updowncode'],'updowncode');
        if(isset($post['leftrightcode']))     $update['leftrightcode']=   Validator::has($post['leftrightcode'],'leftrightcode');
        if(isset($post['bigsmallcode']))     $update['bigsmallcode'] =   Validator::has($post['bigsmallcode'],'bigsmallcode');
        if(isset($post['rotationcode']))     $update['rotationcode'] =   Validator::has($post['rotationcode'],'rotationcode');
        if(isset($post['font']))     $update['font']         =   Validator::has($post['font'],'font');
        

        $result     =      Model('shopCart')->editField($where,$update);
        if($result)  ajaxReturn(L('E200'),'200',$result);
        else ajaxReturn(L('E603'),'603',$result);     
    }
    
    /**
     * 删除购物车商品
     */
    public function delUserShopCartOp()
    {
        $loginUser  =      $this->checkLogin();
        
        $id         =      isset($_GET['id'])?$_GET['id']:$_POST['id'];
        $id         =      Validator::isNumber($id,'int','id');
        
        $cartGoods  =      Model('shopCart')->getById($id);
        
        if($cartGoods['result']['openid']  !=  $loginUser['openid'])
        {
            ajaxReturn('E404',404);
        }
        
        $result     =      Model('shopCart')->removeById($id);
        if($result['result'])  ajaxReturn(L('E200'),'200',$result);
        else    ajaxReturn(L('E603'),'603',$result);
    }
    
    /**
     *  链接微信
     *  获取用户openid
     */
    public function getUserWxInfoOp()
    {
         $wxApi    =  new WxApi();
         $url      =  'http://'.C('redirct_url').'/api/?json=initUser';
//          $url      =  urlencode($url);
         $url      =  $wxApi->wxOauthBase($url);
         
         $wxApi->wxHeader($url);
         
    }
    
    /**
     * 将用户信息存入，并返回
     */
    public function initUserOp()
    {
        $wxApi   =    new WxApi();
        $code    =    $_GET['code'];
        $info    =    $wxApi->wxOauthAccessToken($code);
        if($info['openid']){
            $wxInfo  = $wxApi->wxGetUser($info['openid']);
            //查看用户表是否有这个openid
            $user    =  Model('user')->getUserInfo(array('openid'=>$wxInfo['openid']));
            if(empty($user)){
                $user =    array(
                    'hand_img'   =>    $wxInfo['headimgurl'],
                    'nickname'   =>    $wxInfo['nickname'],
                    'openid'     =>    $wxInfo['openid'],
                    'time'       =>    time(),
                );
                
                $result   =   Model('user')->insert($user);
                if($result){
                    $user['id']     = $result;
                    setSession('loginUser', json_encode($user));
                    $wxInfo['id']   =  $result;   
                    ajaxReturn(L('E200'),200,$wxInfo);
                }else {
                    ajaxReturn(L('E701'),701);
                }
            }else{
                setSession('loginUser', json_encode($user));
                $wxInfo['id']   =  $user['id'];
                ajaxReturn(L('E200'),200,$wxInfo);
            }
            
        }else{
            ajaxReturn(L('E700'),700,$info);
        }
    }
    
    /**
     * 编辑用户信息
     */
	public function editUserInfoOp()
	{
	    $loginUser =  $this->checkLogin();
	    $post      =  $this->getRequest()->post;
	    //判断是否重复提交表单,防止csrf;
	    if(isset($post['token']))
	    {
	        $this->checkToken($post['token']);
	    }else{
	        ajaxReturn(L('E600'),600);
	    }
	     
	    $user            =  array();
	    $openid          =   $loginUser['openid'];
	    if(isset($post['hand_img'])) $user['hand_img']  = Validator::encode($post['hand_img']);
	    if(isset($post['nickname'])) $user['nickname']  = Validator::encode($post['nickname']);
	    if(empty($user))
	        ajaxReturn(L('E312'),'E312');
	    $result  = Model('user')->update($user,array('where'=>array('openid'=>$openid)));
        if($result){
           $loginUser  = Model('user')->getById($loginUser['id']);
           setSession('loginUser', json_encode($loginUser));
           ajaxReturn(L('E200'),200,$result);
        }
        else
           ajaxReturn(L('E604'),604,$result);
	}
	
	/**
	 * 头像图片上传
	 */
	public function uploadHeadImgOp()
	{
	    $loginUser =  $this->checkLogin();
	    
	    $upload = new UploadFile();
	    $upload->set('default_dir','head_img');
	    $result = $upload->upfile('head_img');
	    
	    if(!$result)
	    {
	       ajaxReturn(L('E605'),605,$upload->error);
	    }
	    else{
	        $update  = array();
	        $realpath  = BASE_UPLOAD_PATH.'head_img/'.$upload->file_name;
	        $update['hand_img']  = C('upload_site_url').'head_img/'.$upload->file_name;
	        $result  = Model('user')->update($update,array('where'=>array('openid'=>$loginUser['openid'])));
	        if($result)  { 
	            $loginUser  = Model('user')->getById($loginUser['id']);
	            setSession('loginUser', json_encode($loginUser));
	            ajaxReturn(L('E200'),200,$result);
	        }
            else{
               @unlink($realpath);
               ajaxReturn(L('E603'),603);
           }
	    }
	}
	
	
}