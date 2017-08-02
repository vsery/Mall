<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AdminController {
    public function index(){
		// 入口，已登录调到首页，未登录跳转到登陆
		if(session('?admin'))
			redirect(U('Admin/welcome'));
		else
			redirect(U('Index/login'));
    }
	
	// 登录
	public function login(){
		if(IS_POST){
			if(empty($_POST['user']) || empty($_POST['pass'])){
				$this -> assign('errmsg', '账号密码不能为空');
			}else if($_POST['user'] == $this -> _user['name'] && xmd5($_POST['pass']) == $this -> _user['pass']){
				session('admin', $this -> _user['name']);
				
				if(isset($_POST['remember'])){
					cookie('admin_user', $_POST['user']);
				}
				
				redirect(U('Admin/welcome'));
				exit;
			}else{
				$this -> assign('errmsg', '账号或密码不对');
			}
		}
		
		$this -> display();
	}
	
	//  退出
	public function logout(){
		session('admin',null);
		redirect(U('login'));		
	}
	
}