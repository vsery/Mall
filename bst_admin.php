<?php
/**
*	微信三级分销商城
*
*	http://www.besttool.cn
*
*	Q Q : 2045003697
*
*	微信: dragondean
*
================================================================================

	使用协议：
	遇到问题请联系售后，不要随意改动程序源代码，一经改动不再享受售后保障服务。
	您购买的是程序使用权，版权归开发者所有。未经同意不得转售或者修改后再次销售
	使用本程序则视为接受本协议
	
================================================================================

	=> 安全提示：
	=> 为了管理员登陆方便，管理员登陆界面未设置图形验证码。
	=> 为了安全起见，建议您安装并测试好之后将此文件名改为一个别人猜不到的名字
	=> 比如bst151209.php（不要使用特殊符号，可能导致访问不了）


*/
header("Content-type: text/html; charset=utf-8");
$_GET['m'] = 'Admin';
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('PHP 版本必须大于等于5.3.0 !');

define('DIR_SECURE_CONTENT', 'powered by http://www.dragondea.cn');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', 1);

define('APP_PATH','./Application/');
require './#ThinkPHP/ThinkPHP.php';