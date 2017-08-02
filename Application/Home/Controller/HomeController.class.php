<?php
namespace Home\Controller;
use Think\Controller;
class HomeController extends Controller {
    public function _initialize(){
		// 加载配置
		$config = M('config') -> select();
		if(!is_array($config)){
			die('请先在后台设置好各参数');
		}
		foreach($config as $v){
			$key = '_'.$v['name'];
			$this -> $key = unserialize($v['value']);
			$_CFG[$v['name']] = $this -> $key;
		}
		$this -> assign('_CFG', $_CFG);
		
		//print_r($this -> _level);
		
		if(APP_DEBUG && $_GET['user_id'])
			session('user', M('user') -> find(intval($_GET['user_id'])));

		//session('user', M('user') -> find(10004));
		
		if(session('?user')){
			// 不能直接从session获取数据，不是最新的 
			$this -> user = M('user') -> find(session('user.id'));
		}else{
			// 网页认证授权
			if (!isset($_GET['code'])){
				$custome_url = get_current_url();
				$scope = 'snsapi_userinfo';
				$oauth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this -> _mp['appid'] . '&redirect_uri=' . urlencode($custome_url) . '&response_type=code&scope=' . $scope . '&state=dragondean#wechat_redirect';
				header('Location:' . $oauth_url);
				exit;
			}
			if(isset($_GET['code']) && isset($_GET['state']) && isset($_GET['state']) == 'dragondean'){
				$rt = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this -> _mp['appid'] . '&secret=' . $this -> _mp['appsecret'] . '&code=' . $_GET['code'] . '&grant_type=authorization_code');
				$jsonrt = json_decode($rt, 1);
				if(empty($jsonrt['openid'])){
					$this -> error('用户信息获取失败!');
				}
				$this -> openid = $jsonrt['openid'];
				
				//从数据库获取信息
				$user_info = M('user') -> where(array('openid' => $this -> openid)) -> find();
				if(!$user_info){
					// 拉取用户信息
					$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$jsonrt['access_token']."&openid=".$jsonrt['openid']."&lang=zh_CN";
					$rt = file_get_contents($url);
					$jsonrt = json_decode($rt ,1);
					if(empty($jsonrt['openid'])){
						$this -> error('获取用户详细信息失败');
					}
					$user_id = M('user') -> add(array(
						'nickname' => $jsonrt['nickname'],
						'openid' => $this -> openid,
						'sex' => $jsonrt['sex'],
						'headimg' => $jsonrt['headimgurl']
					));
					$user_info = M('user') -> find($user_id);
				}
				session('user', $user_info);
				$this -> user = $user_info;
			}
			
		}
		
		$this -> assign('user', $this -> user);
		
		// 需要鉴定分销权限的模块
		$dist_arr = array( 'my_agent', 'separate', 'qrcode', 'get_qrcode');
		if(in_array(ACTION_NAME, $dist_arr) && !$this -> _can('dist')){
			$this -> error('您没有分销权限！');
		}
		
		// 需要提现权限的模块
		$withdraw_arr = array( 'withdraw', 'withdraw_add');
		if(in_array(ACTION_NAME, $withdraw_arr) && !$this -> _can('withdraw')){
			$this -> error('您没有提现权限！');
		}
		
		// 需要转让权限的模块
		$deposit_arr = array('deposit','deposit_add');
		if(in_array(ACTION_NAME, $deposit_arr) && !$this -> _can('deposit')){
			$this -> error('您没有转让权限！');
		}
	}
	
	// 判断权限
	private function _can($type){
		if($this -> _level[$this -> user['level']][$type] > 0){
			return true;
		}else{
			return false;
		}
	}
}