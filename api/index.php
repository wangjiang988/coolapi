<?php
/**
 * 商城板块初始化文件
 *
 *
 *
 * @copyright  Copyright (c) 2015-2016 wj (###)
 * @license    ###
 * @link       ###
 * @since      File available since Release v1.1
 */

define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
require BASE_PATH.'/kint/Kint.class.php';
if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/shopnc.php')) exit('shopnc.php isn\'t exists!');
if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');
if(file_exists(BASE_PATH.'/framework/function/function.php'))
{
    require BASE_PATH.'/framework/function/function.php';
}

Base::run();
?>