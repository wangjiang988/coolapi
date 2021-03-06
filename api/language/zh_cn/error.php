<?php

/**
 * 不能直接写101 前面得加个字母，否则下标不识别
 */
//10*路由错误
$lang['E101']		                    = '没有该路由';
$lang['E102']		                    = '没有该路由';
//返回正确
$lang['E200']			                = '请求成功';
$lang['E201']			                = '登录成功';
$lang['E203']			                = '表中记录为空,没有这个或这些记录'; //虽然操作成功，但是表中没有数据，


//参数错误
$lang['E301']	                        = '字段不能为空';
$lang['E302']			                = '没有设置该字段';
$lang['E303']			                = '不是整型数值';
$lang['E304']			                = '不是浮点型数值';
$lang['E305']			                = '非电话号码格式';
$lang['E306']			                = '非手机号码格式';
$lang['E307']			                = '非邮编格式';
$lang['E308']			                = '非邮箱格式';
$lang['E309']			                = '姓名昵称合法性，中英文，数字，还有‘-’，‘_’';
$lang['E310']			                = '字符串长度不符合要求';
$lang['E311']			                = '非邮编格式';
$lang['E312']			                = '没有修改项';

//查询数据错误
$lang['E400']			                = '未登录不允许操作';
//没有查询权限
$lang['E401']                           = '改用户没有查询此数据的权限';
$lang['E402']                           = '非登录用户数据，不允许操作';
$lang['E404']			                = '数据不存在';

//程序错误
$lang['E500']			                = '程序错误';

//表单错误
$lang['E600']                           =  '不安全表单提交';
$lang['E601']                           =  '重复提交';
$lang['E602']                           =  '删除失败';
$lang['E603']                           =  '设置失败';
$lang['E604']                           =  '修改失败';
$lang['E605']                           =  '文件上传错误';

//微信错误
$lang['E700']                           =  '微信错误';
$lang['E701']                           =  '微信用户注册错误';