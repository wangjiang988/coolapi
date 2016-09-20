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

class homeControl extends SystemControl{
	 
	public function __construct(){
		parent::__construct();
	}

	/**
	 *  首页
	 */
	public function getBannerListOp(){
	    $this->_getLsitOp('banner');
	}

	public function getCategoryListOp()
	{
	    $this->_getLsitOp('category');
	}
	
	private function _getLsitOp($tableName,$condition=null)
	{
	    $model       =  Model($tableName);
	    $List        =  $model->getAll();
	    ajaxReturn(L('success'),'200',$List);
	}
	
}