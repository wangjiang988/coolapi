<?php
/**
 * 店铺统计
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
class statisticsModel{
	/**
	 * 更新统计表
	 *
	 * @param	array $param	条件数组
	 */
	public function updatestat($param){
		if (empty($param)){
			return false;
		}
		$result = Db::update($param['table'],array($param['field']=>array('sign'=>'increase','value'=>$param['value'])),$param['where']);
		return $result;
	}
}