<?php
return array(
	//'配置项'=>'配置值'
	'DEFAULT_MODULE'    => 'Home', //默认模块
	'MODULE_ALLOW_LIST'	=> array('Home', 'Admin'),
	'LOAD_EXT_CONFIG' 	=> 'db,ver',
	'URL_MODEL'			=> 0,
	'DATA_CACHE_TYPE'	=> 'file',
	'DATA_CACHE_TIME'	=> 7000,
	'SAFE_SALT'			=> '/@DragonDean/#', // 全局盐值
);