<?php

// 对字符串进行加盐散列加密
function xmd5($str){
	return md5(md5($str).C('SAFE_SALT'));
}

// 获得当前的url
function get_current_url(){
	$url = "http://" . $_SERVER['SERVER_NAME'];
	$url .= $_SERVER['REQUEST_URI'];
	return $url;
}

// 补全url
function complete_url($url){
	if(substr($url,0,1) == '.'){
		return $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'].__ROOT__.substr($url,1);
	}
	elseif(substr($url,0,7) != 'http://' && substr($url,0,8) != 'https://'){
		return $_SERVER['REQUEST_SCHEME']. "://" . $_SERVER['SERVER_NAME'].$url;
	}
	else{
		return $url;
	}
	
}

// 根据订单状态返回状态信息
function get_order_status($status){
	$status_str = '';
	switch($status){
		case -1: $status_str = '已关闭'; break;
		case 1: $status_str = '待支付'; break;
		case 2: $status_str = '待发货'; break;
		case 3: $status_str = '待确认'; break;
		case 4: $status_str = '已完成'; break;
		default : $status_str = '未知状态';
	}
	return $status_str;
}

// 根据订单提现申请返回状态信息
function get_withdraw_status($status){
	$status_str = '';
	switch($status){
		case -1: $status_str = '已拒绝'; break;
		case 1: $status_str = '待审核'; break;
		case 2: $status_str = '待确认'; break;
		case 3: $status_str = '已完成'; break;
		default : $status_str = '未知状态';
	}
	return $status_str;
}

// 根据等级获取等级名称数组
function get_level_name_arr($config){
	if(!is_array($config)){
		$config = unserialize($config);
	}
	$arr = array();
	foreach($config['config'] as $v){
		$arr[] = $v['name'];
	}
	return $arr;
}


// 根据自定义菜单类型返回名称
function get_selfmenu_type($type){
	$type_name = '';
	switch($type){
		case 'click':
			$type_name = '点击推事件';
			break;
		case 'view':
			$type_name = '跳转URL';
			break;
		case 'scancode_push':
			$type_name = '扫码推事件';
			break;
		case 'scancode_waitmsg':
			$type_name = '扫码推事件且弹出“消息接收中”提示框';
			break;
		case 'pic_sysphoto':
			$type_name = '弹出系统拍照发图';
			break;
		case 'pic_photo_or_album':
			$type_name = '弹出拍照或者相册发图';
			break;
		case 'pic_weixin':
			$type_name = '弹出微信相册发图器';
			break;
		case 'location_select':
			$type_name = '弹出地理位置选择器';
			break;
		default : $type_name = '不支持的类型';
	}
	return $type_name;
}

// 更改用户等级
function update_level($user_info, $config){
	$user = M('user');
	// 如果用户参数是id则查询用户信息
	if(!is_array($user_info)){
		$user_info = $user -> find(intval($user_info));
		if(!$user_info){
			return false;
		}
	}
	
	// 获得直接下级商家数
	$agent = $user -> where(array(
		'parent1' => $user_info['id']
	)) -> count();
	
	// 获得所有下级商户数
	$agent_all = $user -> where(array(
		'parent1|parent2|parent3' => $user_info['id']
	)) -> count();
	
	// 获得所有订单数
	$orders = M('order') -> where(array('user_id' => $user_info['id'], 'status' => 4)) -> count();
	
	// 从高等级到低等级判断
	for($i = count($config)-1; $i>0; $i--){
		if($agent >= $config[$i]['agent'] && $agent_all >= $config[$i]['agent_all'] && $orders >= $config[$i]['orders']){
			$user -> where(array('id='.$user_info['id'])) -> setField('level', $i);
		}
	}
	return;
}

// 根据用户信息取得推广二维码路径信息
function get_qrcode_path($user){
	if(!is_array($user)){
		$user = M('user') -> find($user);
	}
	
	$path = './Public/qrcode/'.date('ym/d/',$user['sub_time']);
	return array(
			'path'		=> $path,
			'new'		=> $path.$user['id'].'_dragondean.jpg',
			'head' 		=> $path.$user['id'].'_head.jpg',
			'qrcode'	=> $path.$user['id'].'_qrcode.jpg',
			'full_path' => $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . substr($path,1)
		);
}

//获得财务记录动作名称
function get_finance_action($action){
	$return = '';
	switch($action){
		case 1: $return = '在线充值';break;
		case 2: $return = '余额转出';break;
		case 3: $return = '接受转让';break;
		case 4: $return = '绩效奖励';break;
		//case 5: $return = '全球分红';break;
		case 6: $return = '申请提现';break;
		case 7: $return = '提现退回';break;
		case 8: $return = '订单支付';break;
		case 9: $return = '订单分成';break;
		//case 10: $return = '购物币利息';break;
		default : $return = '未知操作';
	}
	return $return;
}

/** 添加财务日志
*	type => money:余额记录,points:积分记录
*/
function flog($user_id, $type, $money, $action){
	M('finance_log') -> add(array(
		'user_id' => $user_id,
		'type' => $type,
		'money' => $money,
		'action' => $action,
		'create_time' => NOW_TIME
	));
}
