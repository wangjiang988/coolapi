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

class addressControl extends SystemControl{
	 
	public function __construct(){
		parent::__construct();
		Language::read('address,error');
	}

	/**
	 *  得到收获地址
	 */
	public function getAddressOp(){
	     $loginUser = $this->checkLogin(); //加上这一行表示登录才可操作。
	     Validator::has($_GET['id'],'id');
	     Validator::isNumber($this->getRequest()->id,'int');
	     
	     $model     =    Model('receiptAddress');
	     $address   =    $model->getByID($this->getRequest()->id);
	     
	     if($address && $address['openid'] == $loginUser['openid'])
	     {
	         ajaxReturn(L('E200'),'200',$address);
	     }else {
	         if($address)
	           ajaxReturn('id='.$this->getRequest()->id.':'.L('E404'),'404','');
	         else 
	             ajaxReturn(L('E401'),'401');
	     }
	}
	
	/**
	 * 得到默认收货地址
	 */
	public function getDefaultAddressOp()
	{
	    $loginUser = $this->checkLogin(); //加上这一行表示登录才可操作。
	    $model     =    Model('receiptAddress');
	    $address   =    $model->getDefaultAddress($loginUser);
	    
	    if($address && $address['openid'] == $loginUser['openid'])
	    {
	        ajaxReturn(L('E200'),'200',$address);
	    }else {
	        if($address)
	            ajaxReturn('id='.$this->getRequest()->id.':'.L('E404'),'404','');
	            else
	                ajaxReturn(L('E401'),'401');
	    }
	}
	 
	/**
	 * 得到所有省市县信息
	 */
	public function getPCDOP()
	{
	   $provinceList  = Model('province')->getAll('ProvinceID,ProvinceName');
	   $cityList      = Model('city')->getAll('CityID,CityName,ZipCode,ProvinceID');
	   $districtList  = Model('district')->getAll('DistrictID,DistrictName,CityID');
	   
	   $list          = array(
	       "province"    =>  $provinceList,
	       'city'        =>  $cityList,
	       'district'    =>  $districtList,
	   );
	   ajaxReturn(L('E200'),'200',$list);
	}
	
	/**
	 * 得到所有省信息
	 */
	public function getProvinceListOp()
	{
	    $list =  Model('province')->getAll('ProvinceID,ProvinceName');
	    if(empty($list)) ajaxReturn(L('E203'),203,null);
	   
	    ajaxReturn(L('E200'),'200',$list);
	}
	
	/**
	 * 得到所有市信息
	 */
	public function getCityListOp()
	{
	    $list = Model('city')->getAll('CityID,CityName,ZipCode,ProvinceID');
	    
	    if(empty($list)) ajaxReturn(L('E203'),203,null);
	    
	    ajaxReturn(L('E200'),'200',$list);
	}
	
	/**
	 * 
	 */
	
	/**
	 * 得到所有县区信息
	 */
	public function getDistrictListOp()
	{
	     $list = Model('district')->getAll('DistrictID,DistrictName,CityID');
	     
	     if(empty($list)) ajaxReturn(L('E203'),203,null);
	      
	     ajaxReturn(L('E200'),'200',$list);
	}
	
	/**
	 * 添加个人收获地址
	 */
	public function addReceiptAddressOp()
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
	    
	    $address   =  array();
	    $address['openid']           =   $loginUser['openid'];
	    $address['consignee_name']   =   Validator::isName($post['consignee_name'],'consignee_name');//E308
	    $address['phone']            =   Validator::isMobile($post['phone'],'phone');//手机号码格式E306
	    $address['province']         =   Validator::isNumber($post['provinceId'],'int','provinceId');
	    $address['city']             =   Validator::isNumber($post['cityId'],'int','cityId');
	    $address['area']             =   Validator::isNumber($post['districtId'],'int','districtId');
	    $address['detailed_address'] =   Validator::has($post['detailed_address'],'detailed_address');
	    $address['zip_code']         =   Validator::isPostcode($post['zip_code'],'zip_code');//邮编格式E307
	    $address['default_state']    =   0;  //默认为0;
	    
	    $result  =  Model('receiptAddress')->addAddress($address);
 	    if($result['id']) ajaxReturn(L('E200'),'200',$result);
 	    else ajaxReturn(L('E602'),'602',$result);
	}
	
	/**
	 * 修改地址
	 */
	public function modReceiptAddressOP()
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
	    
	    
	    $address   =  array();
	    $address['id']               =   Validator::has($post['id'],'id');
	    $address['openid']           =   $loginUser['openid'];
	    $address['consignee_name']   =   Validator::isName($post['consignee_name'],'consignee_name');//E308
	    $address['phone']            =   Validator::isMobile($post['phone'],'phone');//手机号码格式E306
	    $address['province']         =   Validator::isNumber($post['provinceId'],'int','provinceId');
	    $address['city']             =   Validator::isNumber($post['cityId'],'int','cityId');
	    $address['area']             =   Validator::isNumber($post['districtId'],'int','districtId');
	    $address['detailed_address'] =   Validator::has($post['detailed_address'],'detailed_address');
	    $address['zip_code']         =   Validator::isPostcode($post['zip_code'],'zip_code');//邮编格式E307
	    $address['default_state']    =   0;  //默认为0;
	     
	    $result  =  Model('receiptAddress')->modifyAddress($address);
	    if($result) ajaxReturn(L('E200'),'200',$result);
	    else ajaxReturn(L('E603'),'603',$result);
	}
	
	
	/**
	 * 删除地址
	 */
	public function  removeReceiptAddressOp()
	{
	    $loginUser =  $this->checkLogin();
	    $id        =  isset($_GET['id'])?$_GET['id']:$_POST['id'];
	    Validator::has($id,'id');
	    Validator::isNumber($id,'int','id');
	    
	    $address   =  Model('receiptAddress')->getById($id);
	    if(!$address)  ajaxReturn(L('E203'),203);
	    if($address['openid']  !=  $loginUser['openid']) ajaxReturn(L('E402'),402);
	    
	    $result = Model('receiptAddress')->removeById($id);
	    if($result)  ajaxReturn(L('E200'),'200',$result);
	    else ajaxReturn(L('E602'),'602',$result);
	}
	
	/**
	 * 设置默认收货地址
	 */
	public function setDefaultReceiptAddressOp()
	{
	    $loginUser =  $this->checkLogin();
	    $id        =  isset($_GET['id'])?$_GET['id']:$_POST['id'];
	    Validator::has($id,'id');
	    Validator::isNumber($id,'int','id');
	    
	    $address   =  Model('receiptAddress')->getById($id);
	    if(!$address)  ajaxReturn(L('E203'),203);
	    if($address['openid']  !=  $loginUser['openid']) ajaxReturn(L('E402'),402);
	    
	    $result = Model('receiptAddress')->setDefaultById($id,$loginUser);
	    if($result)  ajaxReturn(L('E200'),'200',$result);
	    else ajaxReturn(L('E603'),'603',$result);
	}
	
	 
    /**
     * 返回order_state中文
     */
    private function _getOrderState($state)
    {
         Language::read('order');
         return L('O'.$state);
    }
    
     
	
}