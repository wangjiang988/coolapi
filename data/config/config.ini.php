<?php
$config = array();
$config['version'] 		= '201401162490';
$config['setup_date'] 	= '2014-05-12 08:48:31';
$config['gip'] 			= 0;
$config['dbdriver'] 	= 'mysqli';
$config['tablepre']		= 'xg_';
$config['db'][1]['dbhost']  	= 'localhost';
$config['db'][1]['dbport']		= '3306';
$config['db'][1]['dbuser']  	= 'root';
// $config['db'][1]['dbpwd'] 	 	= 'root';
$config['db'][1]['dbpwd'] 	 	= 'password';
$config['db'][1]['dbname']  	= 'xiagao';
$config['db'][1]['dbcharset']   = 'UTF-8';
$config['db']['slave'] 		= array();
$config['session_expire'] 	= 3600;
$config['lang_type'] 		= 'zh_cn';
$config['cookie_pre'] 		= 'BA74_';
$config['tpl_name'] 		= 'default';
$config['thumb']['cut_type'] = 'gd';
$config['thumb']['impath'] = '';
$config['cache']['type'] 			= 'file';
$config['upload_site_url']   =  'http://'.$_SERVER['HTTP_HOST'].'/xiagao/Public/upload/';
$config['upload_path']   =  (dirname(BASE_PATH)).'/xiagao/Public/upload/';
// d($config['upload_path']);die;
//$config['upload_path']   =  dirname(__DIR__).'/upload/';
//$config['memcache']['prefix']      	= 'nc_';
//$config['memcache'][1]['port']     	= 11211;
//$config['memcache'][1]['host']     	= '127.0.0.1';
//$config['memcache'][1]['pconnect'] 	= 0;
//$config['redis']['prefix']      	= 'nc_';
//$config['redis']['master']['port']     	= 6379;
//$config['redis']['master']['host']     	= '127.0.0.1';
//$config['redis']['master']['pconnect'] 	= 0;
//$config['redis']['slave']      	    = array();
//$config['fullindexer']['open']      = false;
//$config['fullindexer']['appname']   = 'shopnc';
$config['APPID']         =    'wx7b2682c0b184ab14';
$config['APPSECRET']     =    'f294b8e50ff7e5146d1a371f021d7d99';
$config['redirct_url']   =    'www.xgtee.com';  //微信用户授权回调域名

$config['debug'] 			= true;
// $config['default_store_id'] = '1';
$config['is_root'] = false;//当前目录为不是根路径，则不能直接读取request——uri进行解析路径
$config['encrypt_key'] = 'coolApi';
// 是否开启伪静态
$config['url_model'] = false;
// 二级域名后缀
$config['subdomain_suffix'] = '';