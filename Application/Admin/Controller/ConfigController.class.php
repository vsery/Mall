<?php
namespace Admin\Controller;
use Think\Controller;
class ConfigController extends AdminController {
	public function _initialize(){
		parent::_initialize();
	}
	
	// 站点设置
	public function site(){
		$this -> _save();
		$this -> display();
	}
	
	// 配置管理账号
	public function user(){
		if(IS_POST){
			if(empty($_POST['name'])){
				
				$this -> error('请正确填写登录名');
				
			}else if($_POST['pass'] != $_POST['pass2'] || empty($_POST['pass'])){
				
				$this -> error('请正确填写密码!');
			}
			
			$_POST['pass'] = xmd5($_POST['pass']);
			unset($_POST['pass2']);
			
			// 调用保存方法
			$this -> _save();
		}
		
		$this -> display();
	}
	
	// 配置公众号
	public function mp(){
		$this -> _save();
		$this -> display();
	}
	
	// 分销设置
	public function dist(){
		$this -> _save();
		$this -> display();
	}
	
	// 配置等级
	public function level(){
		if(IS_POST){
			$config = array();
			foreach($_POST['name'] as $key => $val){
				if(empty($val)){
					continue;
				}else{
					// 条件
					empty($_POST['orders'][$key]) && $_POST['orders'][$key] = 0;
					empty($_POST['agent'][$key]) && $_POST['agent'][$key] = 0;
					empty($_POST['agent_all'][$key]) && $_POST['agent_all'][$key] = 0;
					// 权限
					empty($_POST['dist'][$key]) && $_POST['dist'][$key] = 0;
					empty($_POST['withdraw'][$key]) && $_POST['withdraw'][$key] = 0;
					empty($_POST['deposit'][$key]) && $_POST['deposit'][$key] = 0;
				}
				
				$config[] = array(
					'name' => $_POST['name'][$key],
					'orders' => $_POST['orders'][$key],
					'agent' => $_POST['agent'][$key],
					'agent_all' => $_POST['agent_all'][$key],
					'dist' => $_POST['dist'][$key],
					'withdraw' => $_POST['withdraw'][$key],
					'deposit' => $_POST['deposit'][$key],
				);
			}
			
			unset($_POST);
			$_POST = $config;
			
			$this -> _save();
		}
		//print_r($this -> _level);
		$this -> display();
	}
	
	// 轮播图设置
	public function banner(){
		if(IS_POST){
			$_POST['config'] = array();
			foreach($_POST['pic'] as $key => $val){
				$_POST['config'][] = array('pic' => $_POST['pic'][$key], 'url' => $_POST['url'][$key]);
			}
			unset($_POST['pic']);
			unset($_POST['url']);
		}
		$this -> _save();
		
	}
	
	// 模板设置
	public function tpl(){
		$action = empty($_GET['action']) ? 'index' : $_GET['action'];
		if(IS_POST){
			$tpl = $_POST[$action];
			$_POST = $this -> _tpl;
			$_POST[$action] = $tpl;
			$this -> _save();
		}
		
		// 读取模板
		$tpl_path = APP_PATH . 'Home/View/Index/'.$action;
		$dir_list = scandir($tpl_path);
		foreach($dir_list as $k => $v){
			if(in_array($v,array('.','..'))  || !is_dir($tpl_path.'/'.$v)){
				unset($dir_list[$k]);
			}
		}
		$this -> assign('dir_list', $dir_list);
		$this -> assign('action', $action);
		$this -> assign('tpl_path',$tpl_path);
		$this -> display();
	}
	
	// 自定义样式
	public function css(){
		$css_file = '.'.__ROOT__ . '/Public/css/user.css';
		if(IS_POST){
			file_put_contents($css_file, $_POST['content']);
			$this -> success('操作成功！');
			exit;
		}
		
		$css_content = file_get_contents($css_file);
		$this -> assign('content', $css_content);
		$this -> display();		
	}
	
	private function _save(){
		// 通用配置保存操作
		if(IS_POST){
			// 有此配置则更新,没有则新增
			if(array_key_exists(ACTION_NAME, $this -> _CFG)){
				M('config') -> where(array('name' => ACTION_NAME)) -> save(array(
					'value' => serialize($_POST)
				));
			}else{
				M('config') -> add(array(
					'name' => ACTION_NAME,
					'value' => serialize($_POST)
				));
			}
			$this -> success('操作成功！');
			exit;
		}
	}
}?>