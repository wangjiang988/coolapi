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

class wxControl extends SystemControl{
	 
	public function __construct(){
		parent::__construct();
		Language::read('error');
	}

//     public function 

	public function getJsapiOp(){
	    
	    $loginUser = $this->checkLogin();
	    
	    $post     =    $this->getRequest()->post;
	    
        $goods_name            =     Validator::has($post['goods_name'],'goods_name');
        $goods_attach          =     Validator::has($post['goods_attach'],'goods_attach');
        $order_id              =     Validator::isNumber($post['order_id'],'int','order_id');
        $price                 =     Validator::isNumber($post['price'],'all','price');
	    
// 	    require_once WX_PAY_API_PATH."/example/jsapi.php";
	    ini_set('date.timezone','Asia/Shanghai');
	    //error_reporting(E_ERROR);
	    require_once WX_PAY_API_PATH."/lib/WxPay.Api.php";
	    require_once WX_PAY_API_PATH."/example/WxPay.JsApiPay.php";
	    require_once WX_PAY_API_PATH."/example/log.php";
	    //初始化日志
	    $logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
	    $log = Log::Init($logHandler, 15);
	    
	    //①、获取用户openid
	    $tools  = new JsApiPay();
// 	    $openId = $tools->GetOpenid();
	    $openId  = $loginUser['openid'];
	    //②、统一下单
	    $input = new WxPayUnifiedOrder();
	    $input->SetBody($goods_name);  //商品名称
	    $input->SetAttach($goods_attach); //商品附件
	    $input->SetOut_trade_no($order_id); //订单ID
	    $input->SetTotal_fee($price); //商品价格
	    $input->SetTime_start(date("YmdHis"));
	    $input->SetTime_expire(date("YmdHis", time() + 600));
	    $input->SetGoods_tag("goods_tag"); //商品标签
	    $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
	    $input->SetTrade_type("JSAPI");
	    $input->SetOpenid($openId);
	    $order = WxPayApi::unifiedOrder($input);
	    $jsApiParameters = $tools->GetJsApiParameters($order);
	    if($jsApiParameters)
	        ajaxReturn(L('E200'),200,$jsApiParameters);
	    else{
	        ajaxReturn('jsapi参数获取错误',603);
	    }
	}
     
	
}