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
*/
header("Content-type: text/html; charset=utf-8");
unset($_GET['m']);
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('PHP 版本必须大于等于5.3.0 !');

define('DIR_SECURE_CONTENT', 'powered by http://www.dragondea.cn');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
// define('APP_DEBUG', 1);
define('APP_DEBUG', 1);

if(!APP_DEBUG && !strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')){
	die('请通过微信访问');
}
define('APP_PATH','./Application/');
require './#ThinkPHP/ThinkPHP.php';