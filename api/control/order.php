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

class orderControl extends SystemControl{
	 
	public function __construct(){
		parent::__construct();
	}

	/**
	 *  生成订单
	 */
	public function createOrderOp()
	{
	    $loginUser   =    $this->checkLogin();
	    
	    $post      =  $this->getRequest()->post;
// 	    判断是否重复提交表单,防止csrf;
	    if(isset($post['token']))
	    {
	        $this->checkToken($post['token']);
	    }else{
	        ajaxReturn(L('E600'),600);
	    }
	    
	    //得到goods_id
	    
	    $goods_id                =     Validator::isNumber($post['goods_id'],'int','goods_id');
	    //查看库存
	    $goods                   =     Model('goods')->getGoodsById($goods_id);
	    $order_num               =     Validator::isNumber($post['num'],'num'); 
	    $goods_stock             =     $goods['goods_stock'] - $order_num ;
	    if($goods_stock < 0)
	    {
	        ajaxReturn('库存不足',E603);
	    }
	    
	    $order                   =     array();
	    $order['goods_id']       =     $goods_id;
	    
	    if(isset($post['order_id']))
	        $order['order_id']   =     $post['order_id'];
	    else{
	        $order['order_id']        =   $this->_generateOrderId();
	    }
	    $order['preview_url']    =     Validator::has($post['preview_url'],'preview_url');
	    $order['goods_name']     =     Validator::has($post['goods_name'],'goods_name'); 
	    $order['style']          =     Validator::has($post['style'],'style'); 
	    $order['price']          =     Validator::has($post['price'],'price'); 
	    $order['num']            =     $order_num;
	    $order['order_state']    =     0 ; //未付款状态
	    $order['preferential_code']    =   Validator::has($post['preferential_code'],'preferential_code'); 
	    $order['receipt_address']      =   Validator::has($post['receipt_address'],'receipt_address'); 
	    $order['receipt_people']       =   Validator::has($post['receipt_people'],'receipt_people');  
	    $order['phone']                =   Validator::isMobile($post['phone'],'phone'); 
	    $order['zip_code']             =   Validator::isPostcode($post['zip_code'],'zip_code'); 
	    $order['preferential_code']    =   Validator::has($post['preferential_code'],'preferential_code');
	    $order['refund_status']        =   0;  //未退款
	    $order['size']                 =   Validator::has($post['size'],'size');
	    $order['words']                =   Validator::has($post['words'],'words');
	    $order['technology']           =   Validator::has($post['technology'],'technology');
	    $order['material']             =   Validator::has($post['material'],'material');
	    $order['gift_boxes']           =   Validator::has($post['gift_boxes'],'gift_boxes');
	    $order['color']                =   Validator::has($post['color'],'color');
	    $order['updowncode']           =   Validator::has($post['updowncode'],'updowncode');
	    $order['leftrightcode']        =   Validator::has($post['leftrightcode'],'leftrightcode');
	    $order['rotationcode']         =   Validator::has($post['rotationcode'],'rotationcode');
	    $order['bigsmallcode']         =   Validator::has($post['bigsmallcode'],'bigsmallcode');
	    $order['font']                 =   Validator::has($post['font'],'font');
	    $order['details']              =   Validator::has($post['details'],'details');
	    $order['time']                 =   time();
	    $order['generate_time']        =   time();
	    $order['openid']          =   $loginUser['openid'];
	   
	    $result  =  Model('order')->insert($order);
	    
	    if($result){
	        Model('goods')->where(array('id'=>$goods_id))->update(array('goods_stock'=>$goods_stock));
	        ajaxReturn(L('E200'),200,array('id'=>$result,'order_id'=>$order['order_id']));
	    }
	    else 
	        ajaxReturn(L('E603'),'E603');
	}
	
	/**
	 * 修改退款状态
	 */
	public function refundOrderOp()
	{
	    ini_set('date.timezone','Asia/Shanghai');
	    error_reporting(E_ERROR);
	    
	    
	    $loginUser   =    $this->checkLogin();
	    require_once WX_PAY_API_PATH."/lib/WxPay.Api.php";
	    require_once WX_PAY_API_PATH.'/example/log.php';
	    
	    //初始化日志
// 	    $logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
// 	    $log = Log::Init($logHandler, 15);
	    
	    $order_id    =    isset($_GET['order_id'])?$_GET['order_id']:$_POST['order_id'];
	    $wx_order_id    =    isset($_GET['wx_order_id'])?$_GET['wx_order_id']:$_POST['wx_order_id'];
// 	    Validator::has($order_id,'order_id');
        if(!$order_id  && !$wx_order_id)
            ajaxReturn('order_id或wx_order_id必须有一个',300);
	    
	    $post =  $this->getRequest()->post;
        $out_trade_no = $order_id;
        $total_fee  = Validator::isNumber($post['total_fee'],'int','total_fee');
        $refund_fee  = Validator::isNumber($post['refund_fee'],'int','refund_fee');
//         $total_fee = $_REQUEST["total_fee"];
//         $refund_fee = $_REQUEST["refund_fee"];
        $input = new WxPayRefund();
        $input->SetOut_trade_no($out_trade_no);
        if(!empty($wx_order_id))
            $input->SetTransaction_id($wx_order_id);
        $input->SetTotal_fee($total_fee);
        $input->SetRefund_fee($refund_fee);
        $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis"));
        $input->SetOp_user_id(WxPayConfig::MCHID);
        $ret   = WxPayApi::refund($input);	 
	    if($ret['result_code'] !='FAIL') ajaxReturn(L('E200'),200,$ret);
	    else ajaxReturn('退款失败',603,$ret);
	}
	
	
	/**
	 * 获取一个随机订单ID
	 */
	public function generateOrderIdOp()
	{
          $this->checkLogin();
           
          $order_id      =     $this->_generateOrderId();  
          ajaxReturn(L('E200'),200,$order_id);
	}
	
	/*
	 * 得到优惠码
	 */
	public function getPercentCodeOp(){
	    $login     =   $this->checkLogin();
	    
	    $code      =   isset($_GET['code'])?$_GET['code']:$_POST['code'];
	    Validator::has($code,'code');
	    
	    $codeInfo  =   Model()->table('agents')->where(array('content'=>$code,'state'=>1))->find();
	    if($codeInfo) ajaxReturn(L('E200'),200,$codeInfo);
	    else ajaxReturn(L('E203'),203);
	}
	
	/**
	 * 修改订单状态
	 */
	public function changOrderStateOp()
	{
	    $loginUser   =    $this->checkLogin();
	    
	    $order_id    =    isset($_GET['order_id'])?$_GET['order_id']:$_POST['order_id'];
	    Validator::has($order_id,'order_id');
	    
	    $this->_checkOrder($order_id,$loginUser);
	    
	    $order_state =    isset($_GET['order_state'])?$_GET['order_state']:$_POST['order_state'];
	    Validator::isNumber($order_state,'int','order_state');
	    if(!in_array($order_state, array(0,1,2,3,4,5))) {
	        ajaxReturn('order_state:状态码错误',603);
	    }
	    $ret    =    $this->_change_status($order_id,$order_state);
	    if($ret) ajaxReturn(L('E200'),200);
	    else ajaxReturn('修改订单状态失败',603);
	}
	
	
	/**
	 * 快递结果接口
	 */
	public function getKuaidiInfoOp()
	{
	    $express = new Express();
	    $order_id    =    isset($_GET['order_id'])?$_GET['order_id']:$_POST['order_id'];
	    Validator::has($order_id,'order_id');
	    $result  = $express -> getorder($order_id);
        if($result['status'] ==200)
             ajaxReturn(L('E200'),200,$result);
        else{
            ajaxReturn('查询接口错误',203,$result);
        }
	}
	
	
	private function _generateOrderId()
	{
	    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
	}
	
	/**
	 * 
	 * @param unknown $status_code
	 *   0未付款1已接单2已生产3已发货4已签收5已退款  10退款中
	 */
	
	private function _change_status($order_id,$status_code)
	{
	    $update  =  array();
	    switch ($status_code) {
	        case '10':
	            $update ['refund_status']  =  1  ;
	        ;
	        break;
	        
	        default:
	            if(in_array($status_code,array(0,1,2,3,4,5)))
	               $update['order_state']  =$status_code;
	            ;
	        break;
	    }
	   if(empty($update))  return false;
	   return  Model('order')->where(array('order_id'=>$order_id))->update($update); 
	}
	
	/**
	 * 检查订单是否是这个用户的
	 */
	private function _checkOrder($order_id,$loginUser)
	{
	    $ret   =   Model('order')->where(array('openid'=>$loginUser['openid'],'order_id'=>$order_id))->count();
	    if($ret < 1) ajaxReturn('该订单不属于该用户',603);
	    else  return true;
	}
	
	 
}