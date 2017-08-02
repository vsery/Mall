<?php
namespace Home\Controller;
use Think\Controller;
class SkController extends HomeController {
	
	// 收款列表
	public function index(){
		die('暂不可用');
	}
	
	// 收款页面
	public function detail(){
		$id = intval($_GET['id']);
		$info = M('sk') -> find($id);
		if(!$info){
			$this -> error('访问错误');
		}
		
		$info['form'] = unserialize($info['form']);
		$this -> assign('info', $info);
		$this -> display();
	}
	
	// 提交订单
	public function order(){
		$id = intval($_GET['id']);
		$info = M('sk') -> find($id);
		if(!$info){
			$this -> error('访问错误!');
		}
		
		$form = unserialize($info['form']);
		if(!is_array($form)){
			$form = array();
		}
		if(count($form) != count($_POST['form_value'])){
			$this -> error('提交的数据有误!');
		}
		
		$form_data = array();
		foreach($form as $key => $val){
			$form_data[] = array(
				'name' => $val['name'],
				'value' => $_POST['form_value'][$key]
			); 
		}
		
		if(IS_POST){
			$data = array(
				'sk_id' => $id,
				'user_id' => $this -> user['id'],
				'nickname' => $this -> user['nickname'],
				'form' => serialize($form_data),
				'money' => $info['price'],
				'paid' => 0,
				'status' => 1, // 待付款
				'create_time' => NOW_TIME
			);
			
			$rs = M('sk_order') -> add($data);
			if(!$rs){
				$this -> error('信息提交失败！');
			}
			
			// 微信支付
			$jsapi = new \Common\Util\wxjspay;
			$param = $this -> _mp;
			$param['key'] = $this -> _mp['key'];
			$param['openid'] = $this -> user['openid'];
			$param['body'] = $info['title'];
			$param['out_trade_no'] = NOW_TIME.$this -> user['id'];
			$param['total_fee'] = $info['price'] * 100;
			$param['attach'] = json_encode(array(
					'order_id' => $rs,
					'user_id' => $this -> user['id'],
					'type' => 3 // 收款
				));
			$param['notify_url'] = "http://".$_SERVER['HTTP_HOST'].__ROOT__.'/notify.php';
			$jsapi -> set_param($param);
			$uo = $jsapi -> unifiedOrder();
			$jsapi_params = $jsapi -> get_jsApi_parameters();
			$this -> assign('jsApiParameters', $jsapi_params);
			
			$this -> assign('money', $info['price']);
			$this -> display();
		}
	}
}?>