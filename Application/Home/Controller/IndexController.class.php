<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends HomeController {
	
	// 商城首页
    public function index(){
		$list = M('product') -> order('id desc') -> limit(10) -> select();
		$this -> assign('list', $list);
		
		// 查询分类
		$cates = M('product_cate') -> where('pid=0') -> select();
		$this -> assign('cates', $cates);
		
		// 判断是否设置了木板
		if(!empty($this -> _tpl['index'])){
			$tpl = 'Index/index/'.$this -> _tpl['index'].'/index';
		}
    	$this -> display($tpl);
    }
	
	// 商品详情
	public function product(){
		$id = intval($_GET['id']);
		$info = M('product') -> find($id);
		if(!$info){
			die('访问错误');
		}

		// 格式化属性
		$info['attr_names'] = explode(',', $info['attr']);
		
		// 去除每个属性中的重复内容
		$attr_values = unserialize($info['attr_values']);
		foreach($attr_values as &$v){
			$v = array_unique($v);
		}
		$info['attr_values'] = $attr_values;
		
		
		$this -> assign('info', $info);
		$this -> display();
	}
	
	
	// 所有商品
	public function all(){
		// 排序
		if(in_array($_GET['order'], array('price', 'sold'))){
			$type = $_GET['type'] == 'asc' ? 'asc' : 'desc';
			$order = $_GET['order'].' '.$type;
		}
		
		// 查询分类
		$cates = M('product_cate') -> select();
		$this -> assign('cates', $cates);
		
		// 分类查看
		if(isset($_GET['cate_id']) && intval($_GET['cate_id']) >0){
			$where['cate_id'] = intval($_GET['cate_id']);
			
			foreach($cates as $cate){
				if($cate['id'] == $where['cate_id']){
					$pagetitle = $cate['name'];
					break;
				}
			}
		}
		
		// 关键词搜索
		if(isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword'])){
			$_GET['keyword'] = $_REQUEST['keyword'];
			$where['title'] = array('like', "%{$_REQUEST['keyword']}%");
			
			$pagetitle = '搜索结果';
		}
		
		
		// 查询总商品数
		$count = M('product') -> where($where) -> count();
		
		$page = new \Think\Page($count, 20);
		
		$list = M('product') -> where($where) -> order($order) -> limit($page->firstRow.','.$page->listRows) -> select();
		$this -> assign('list', $list);
		
		if(empty($pagetitle)){
			$pagetitle = '全部商品';
		}
		$this -> assign('pagetitle', $pagetitle);

		$this -> assign('page', $page -> show());
		$this -> assign('count', $count);
		$this -> display();
	}
	
	// 购物车
	public function cart(){
		$cart = M('order_product');
		$list = $cart -> where(array('user_id' => $this -> user['id'], 'order_id' => 0)) -> select();
		// 没有商品跳转到编辑购物车，那里提示暂时没有内容
		if(!$list){
			redirect(U('Index/cart_edit'));
		}
		$this -> assign('list', $list);
		
		// 计算购物车总额
		$total = $this -> _get_cart_total($list);
		$this -> assign('total', $total);
		
		if(intval($_GET['addr'])){
			$addr = M('addr')->where('user_id='.$this -> user['id']) -> find(intval($_GET['addr']));
		}
		// 没有指定地址且有默认地址则查找默认地址
		if(empty($addr) && $this -> user['default_addr']){
			$addr = M('addr') ->where('user_id='.$this -> user['id']) -> find($this -> user['default_addr']);
		}
		$this -> assign('addr', $addr);
		
		
		$this -> display();
	}
	
	// 编辑购物车
	public function cart_edit(){
		$list = M('order_product') -> where(array('user_id' => $this -> user['id'], 'order_id' => 0)) -> select();		
		if(is_array($list)){
			$this -> assign('list', $list);
			if(is_array($list)){
				// 计算总额
				$total = 0;
				foreach($list as $v){
					$total += $v['nums'] * $v['price'];
				}
				$total = sprintf("%.2f", $total);
				$this -> assign('total', $total);
			}
		}
		$this -> display();
	}
	
	// 提交订单
	public function order(){
		$addr_id = intval($_POST['addr_id']);
		$msg = I('post.msg');
		 
		$cart = M('order_product');
		// 检查商品
		$list = $cart -> where(array('user_id' => $this -> user['id'], 'order_id' =>0)) -> select();
		if(!$list){
			$this -> error('购物车还没有产品哦');
		}
		$total = $this -> _get_cart_total($list);
		$points_total = $this -> _get_cart_total($list, 'points');
		
		// 检查收货地址
		$addr_info = M('addr') -> where(array('user_id' => $this -> user['id'], 'id' => $addr_id)) -> find();
		if(!$addr_info){
			$this -> error('没有选择收获地址哦');
		}
		
		// 将信息保存到数据库
		$order_info = array(
			'sn' => date("ymdHi").$this -> user['id'].mt_rand(1000,9999),
			'user_id' => $this -> user['id'],
			'name' => $addr_info['name'],
			'mobile' => $addr_info['mobile'],
			'addr' => str_replace('||', ' ', $addr_info['district']).$addr_info['addr'],
			'addr_id' => $addr_info['id'],
			'msg' => I('post.msg'),
			'total' => $total,
			'points_total' => $points_total,
			'create_time' => NOW_TIME,
			'status' => 1
		);
		$order_id = M('order') -> add($order_info);
		if(!$order_id){
			$this -> error('订单提交失败，请重试');
		}
		// 补全订单编号信息
		$order_info['id'] = $order_id;
		
		// 更改购物车的订单信息
		M('order_product') -> where(array('user_id' => $this -> user['id'], 'order_id' => 0)) -> setField('order_id', $order_id);
		
		//循环增加商品销量
		foreach($list as $v){
			M('product') -> where('id='.$v['product_id']) -> setInc('sold', $v['nums']);
		}
		
		// 对订单分成
		$this -> _separate($order_info);
		
		// 跳转到支付选择页面
		redirect(U("Index/order_pay?id=".$order_id));
	}
	
	// 订单支付选择页面
	public function order_pay(){
		$id = intval($_GET['id']);
		$info = M('order') -> where(array('id' => $id, 'user_id' => $this -> user['id'])) -> find();
		if(!$info){
			$this -> error('访问错误');
		}
		$this -> assign('info', $info);
		$this -> display();
	}
	
	// 支付页面
	public function pay(){
		$order_id = intval($_GET['order_id']);
		
		// 支付订单
		if(IS_POST && $order_id >0){
			$order = M('order');
			$order_info = $order -> where(array('user_id' => $this -> user['id'])) -> find($order_id);
			if(!$order_info){
				$this -> error('访问错误');
			}
			
			// 判断是否是待支付状态
			if($order_info['status'] != 1){
				$this -> error('订单暂时不能支付');
			}
			
			$need_pay = $order_info['total'] - $order_info['wxpay'] - $order_info['points'] - $order_info['money'];
			
			// 勾选了积分支付
			if($_POST['points'] == 1){
				// 计算积分价值
				$points_value = sprintf('%.2f', $this -> user['points']/$this ->_site['points_rate']);
				
				// 积分足够
				if($points_value >= $need_pay){
					// 减少用户的购物币
					M('user') -> where('id='.$this -> user['id']) -> save(array(
						'points' => $this -> user['points'] - $need_pay*$this -> _site['points_rate']
						));
						
					
					
					$order -> where('id='.$order_id) -> save(array(
						'points' => $order_info['points'] + $need_pay,
						'status' => 2,
						'pay_time' => NOW_TIME
						));
						
					// 更新分成状态为待确认
					M('separate_log') -> where('order_id='.$order_id) -> setField('status', 3);
					
					// 记录财务日志
					flog($this -> user['id'], 'points', 0-$need_pay * $this -> _site['points_rate'], 8);
					
					redirect(U('Index/order_list'));
					exit;
				}
				// 积分不够,先用全部积分支付
				else{
					$order -> where('id='.$order_id) -> save(array('points' => $order_info['buycoin'] + $points_value));
					M('user') -> where('id='.$this -> user['id']) -> save(array('points' => 0));
					$need_pay -= $points_value;
					
					flog($this -> user['id'],'points',0-$this -> user['points'], 8); // 记录财务日志
				}
			}
			
			// 勾选了余额支付
			if($_POST['money'] == 1){
				// 余额足够
				if($this -> user['money'] >= $need_pay){
					// 减少用户余额
					M('user') -> where('id='.$this -> user['id']) -> save(array(
							'money' => $this -> user['money'] - $need_pay
						));
						
					// 改变订单状态
					$order -> where('id='.$order_id) -> save(array(
						'money' => $order_info['money'] + $need_pay,
						'status' => 2,
						'pay_time' => NOW_TIME
						));
						
					// 记录财务日志
					flog($this -> user['id'],'money',0-$need_pay, 8); 
					
					// 更新分成状态为待确认
					M('separate_log') -> where('order_id='.$order_id) -> setField('status', 3);
					
					redirect(U('Index/order_list'));
					exit;
				}
				// 余额不够
				else{
					$order -> where('id='.$order_id) -> save(array('money' => $order_info['money'] + $this -> user['money']));
					M('user') -> where('id='.$this -> user['id']) -> save(array('money' => 0));
					$need_pay -= $this -> user['money'];
					
					flog($this -> user['id'],'money',0-$this -> user['money'], 8); // 记录财务日志
				}
			}
			
			$this -> assign('info', $order_info);
			$type = 1;//'购物订单支付';
			$out_trade_no = $order_info['sn'];
		}
		
		// 充值
		elseif(!empty($_POST['charge'])){
			// TODO
			$need_pay = sprintf('%.2f', floatval($_POST['charge']));
			if($need_pay <= 0){
				$this -> error('充值金额错误');
			}
			$type = 2; // 在线充值
			$out_trade_no = NOW_TIME.$this -> user['id'];
		}else{
			$this -> error('访问错误');
		}
		
		// 剩余部分用微信支付
		$jsapi = new \Common\Util\wxjspay;
		$param = $this -> _mp;
		$param['key'] = $this -> _mp['key'];
		$param['openid'] = $this -> user['openid'];
		$param['body'] = $this -> _site['name'].'在线支付';
		$param['out_trade_no'] = $out_trade_no;
		$param['total_fee'] = $need_pay * 100;
		$param['attach'] = json_encode(array(
				'order_id' => $order_info['id'],
				'charge' => $need_pay,
				'user_id' => $this -> user['id'],
				'type' => $type
			));
		$param['notify_url'] = "http://".$_SERVER['HTTP_HOST'].__ROOT__.'/notify.php';
		$jsapi -> set_param($param);
		$uo = $jsapi -> unifiedOrder();
		$jsapi_params = $jsapi -> get_jsApi_parameters();
		$this -> assign('jsApiParameters', $jsapi_params);
		
		$this -> assign('out_trade_no', $out_trade_no);
		$this -> assign('money', sprintf("%.2f",$need_pay));
		$this -> assign('type', $type);
		$this -> display();
	}
	
	// 订单列表
	public function order_list(){
		$where = array(
			'user_id' => $this -> user['id']
		);
		
		// 有before参数表示获取一个月前的订单，否则就是一个月内的订单
		$time = strtotime("-1 month");
		if(isset($_GET['before'])){
			$where['create_time'] = array('lt', $time);
		}else{
			$where['create_time'] = array('gt', $time);
		}
		
		$list = M('order') -> where($where) -> order('id desc') -> select();
		
		if(is_array($list) && count($list) >0 ){
			// 获取订单的产品信息
			$order_arr = array();
			foreach($list as $order){
				$order_arr[] = $order['id'];
			}
			$product_list = M('order_product') -> where(array(
				'user_id' => $this -> user['id'],
				'order_id' => array('EXP',"in (".implode(',', $order_arr).")")
			)) -> select();
			foreach($list as &$order){
				foreach($product_list as $product){
					if($order['id'] == $product['order_id']){
						$order['products'][] = $product;
					}
				}
			}
		}
		$this -> assign('list', $list);
		$this -> display();
	}
	
	// 订单详细信息
	public function order_detail(){
		$id = intval($_GET['id']);
		$info = M('order') -> where(array('id' => $id, 'user_id' => $this -> user['id'])) -> find();
		if(!$info){
			$this -> error('没有这个订单');
		}
		
		// 查询产品信息
		$product_list = M('order_product') -> where(array('order_id' => $id)) -> select();
		$this -> assign('products', $product_list);
		
		
		$this -> assign('info', $info);
		$this -> display();
	}
	
	// 确认收货
	public function order_confirm(){
		$order_id = intval($_GET['id']);
		$order_info = M('order') -> where(array('id' => $order_id, 'user_id' => $this -> user['id'])) -> find($order_id);
		if(!$order_info){
			$this -> error('没有这个订单!');
		}
		
		$rs = M('order') -> where(array('id' => $order_id, 'user_id' => $this -> user['id'])) -> save(array(
			'status' => 4,
			'confirm_time' => NOW_TIME
		));
		
		if(!$rs){
			$this -> error('操作失败！');
		}
		// 将订单中的积分赠送到用户
		if($order_info['points_total'] >0 ){
			M('user') -> where(array('id='.$this -> user['id'])) -> save(array(
				'points' => array('exp', 'points+'.$order_info['points_total'])
			));
			flog($this -> user['id'], 'points', $order_info['points_total'],10);
		}
		// 将分成状态设置为已完成
		M('separate_log') -> where('order_id='.$order_id) -> setField('status', 4);
		
		// 循环对分成添加到分销商账户
		$separate_logs = M('separate_log') -> where('order_id='.$order_id) -> select();
		foreach((array)$separate_logs as $separate_log){
			
			M('user') -> where('id='.$separate_log['user_id']) -> save(array(
				'money' => array('exp', 'money+'.$separate_log['money']),
				'points' => array('exp', 'points+'.$separate_log['points'])
			));
			
			flog($separate_log['user_id'], 'money', $separate_log['money'],9);
			flog($separate_log['user_id'], 'points', $separate_log['points'],9);
		}
		
		
		$this -> error('操作成功！', U('order_detail?id='.$order_id));
	}
	
	// 收货地址
	public function addr(){
		$act = empty($_GET['act']) ? '' : $_GET['act'];
		
		// 有默认参数则将此地址设置为默认
		if(isset($_GET['default'])){
			$addr_info = M('addr') -> find(intval($_GET['default']));
			if($addr_info && $addr_info['user_id'] == $this -> user['id']){
				M('user') -> where("id=".$this -> user['id']) -> setField('default_addr', intval($_GET['default']));
				redirect(U('Index/addr'));
				exit;
			}
		}
		
		$list = M('addr') -> where(array('user_id' => $this -> user['id'])) -> select();
		// 如果没有地址且是选择地址则直接跳转到添加地址
		if(!$list && $act == 'select'){
			header("location:".U('Index/addr_add?act=select'));
			exit;
		}
		$this -> assign('list', $list);
		$this -> display();
	}
	
	// 添加收货地址
	public function addr_add(){
		if(IS_POST){
			if(empty($_POST['name']) || empty($_POST['mobile']) || empty($_POST['addr']) || empty($_POST['district'])){
				$this -> error('请填写完整');
			}
			$addr = M('addr');
			$rs = $addr -> add(array(
				'user_id' => $this -> user['id'],
				'name' => I('post.name'),
				'mobile' => I('post.mobile'),
				'addr' => I('post.addr'),
				'district' => I('post.district')
			));
			if(!$rs){
				$this -> error('地址保存失败');
			}
			
			// 如果没有默认地址就设置为默认地址
			if($this -> user['default_addr'] == '0'){
				M('user') -> where('id='.$this -> user['id']) -> setField('default_addr', $rs);
			}
			
			// 如果是选择地址的时候添加地址则直接跳转回购物车页面,否则跳转到列表页
			if($_GET['act'] == 'select'){
				redirect(U('Index/cart?addr='.$rs));
				exit;
			}else{
				$this -> success('地址添加成功',U('Index/addr'));
				exit;
			}
		}
		
		$this -> display();
	}
	
	// 会员中心
	public function ucenter(){
		// 获取商家昵称
		if(!empty($this -> user['parent1'])){
			$parent_name = M('user') -> where("id=".$this -> user['parent1']) -> getField('nickname');
			$this -> assign('parent_name', $parent_name);
		}
		
		// 获取等级名称数组
		$level_arr = get_level_name_arr($this -> _level);
		$this -> assign('level_name', $level_arr[$this -> user['level']]); // 我的等级名称
		
		// 查询我的排名
		$rank = M('user') -> where(array('expense_total' => array('gt', $this -> user['expense_total']))) -> count();
		if($rank >= 100){
			$this -> assign('rank', '100+');
		}else{
			$this -> assign('rank', $rank);
		}
		
		// 查询我的分成
		$separate = M('separate_log') -> where('status>0 and user_id='.$this -> user['id']) -> sum('money');
		$this -> assign('separate', $separate);
		
		// 查询最新的公告
		$notice = M('notice') -> order('id desc') -> find();
		if($notice){
			$this -> assign('notice', $notice);
		}
		$this -> display();
	}
	
	// 排行榜
	public function rank(){
		$list = M('user') -> order('agent desc') 
				-> field('headimg,nickname,level,agent1+agent2+agent3 as agent')
				-> limit(108) -> select();
		$this -> assign('list', $list);
		
		
		
		// 获取等级名称数组
		$level_arr = get_level_name_arr($this -> _level);
		$this -> assign('level_name', $level_arr);
		
		$this -> display();
	}
	
	// 我的推广
	public function my_spread(){
		// 获取分店关注总数
		$count = $this -> user['agent1'] + $this -> user['agent2'] + $this -> user['agent3'];
		
		// 获取订单总数,即分成订单数
		$total = M('separate_log') -> where(array('user_id' => $this -> user['id'])) -> count();
		
		$this -> assign('count', $count);
		$this -> assign('total', $total);
		
		$this -> display();
	}
	
	// 我的代理
	public function my_agent(){
		$type = intval($_GET['type']) >0 ? intval($_GET['type']) : 1;
		$_GET['type'] = $type;
		
		$list = M('user') -> where(array('parent'.$type => $this -> user['id'])) -> field('headimg,nickname,sub_time') -> select();
		
		$this -> assign('list', $list);
		
		// 获取等级名称数组
		//$level_arr = get_level_name_arr($this -> _level);
		//$this -> assign('level_name', $level_arr);
		$this -> display();
	}
	
	// 充值
	public function charge(){
		$values = explode('|', $this -> _site['charge']);
		foreach($values as &$v){
			if(intval($v)<1){
				unset($v);
			}
		}
		$this -> assign('values', $values);
		$this -> display();
	}
	
	// 转币管理
	public function deposit(){
		// 查询我的转出记录
		$list = M('deposit') -> where(array('deposit_user')) -> select();
		$this -> assign('list', $list);
		$this -> display();
	}
	
	// 申请转币
	public function deposit_add(){
		if(IS_POST){
			// 金额取整
			$money = intval($_POST['money']);
			if($money < 50){
				$this -> assign('errmsg', '金额必须大于50');
			}
			
			// 判断金额是否足够
			elseif($money > $this -> user['money'] ){
				$this -> assign('errmsg', '可用金额不足');
			}else{
				$user = M('user');
				
				$user_id = intval($_POST['code']);
				// 查询用户资料
				$accept_user = $user -> find($user_id);
				if(!$accept_user){
					$this -> assign('errmsg', '受让人不存在');
				}
				
				// 减少转让人的余额，增加受让人的余额
				else{
					// 转让人可用余额减少，累计转出增加
					$user -> where('id='.$this -> user['id']) -> save(array(
						'money' => $this -> user['money']-$money
					));
					flog($this -> user['id'],'money',$money, 2); // 记录财务日志
					
					// 受让人余额增加
					$user -> where('id='.$accept_user['id']) -> save(array(
						'money' => $money + $accept_user['money']
					));
					
					flog($accept_user['id'],'money',$money, 3); // 记录财务日志
					
					// 转让记录
					M('deposit') -> add(array(
						'deposit_user' => $this -> user['id'],
						'accept_user' => $user_id,
						'accept_user_name' => $accept_user['nickname'],
						'money' => $money,
						'create_time' => NOW_TIME
					));
					$this -> success('操作成功！');
					exit;
				}
			}
		}
		
		$this -> display();
		
	}
	
	// 个人资料
	public function profile(){
		if(IS_POST){
			M('user') -> where('id='.$this -> user['id']) -> save($_POST);
			$this -> success('保存成功！');
			exit;
		}
		
		$this -> display();
	}
	
	// 同步个人资料
	public function sync_profile(){
		$dd = new \Common\Util\ddwechat;
		$dd -> setParam($this -> _mp);
		$user_info = $dd -> getuserinfo($this -> user['openid']);
		if(!$user_info){
			$msg = APP_DEBUG ? $dd -> errmsg : '同步失败';
			$this -> error($msg);
		}
		
		M('user') -> save(array(
			'id' => $this -> user['id'],
			'nickname' => $user_info['nickname'],
			'sex' => $user_info['sex'],
			'headimg' => $user_info['headimgurl']
		));
		$this -> success('更新成功！');
	}
	
	// 银行卡管理
	public function bankcard(){
		$list = M('bank_card') -> where('user_id='.$this -> user['id']) -> select();
		foreach($list as &$v){
			$v['cardno'] = substr($v['cardno'],0,4).str_repeat('*', strlen($v['cardno'])-8).substr($v['cardno'],strlen($v['cardno'])-4,4);
		}
		$this -> assign('list', $list);
		$this -> display();
	}
	
	// 添加银行卡
	public function bankcard_add(){
		if(IS_POST){
			$arr = array('bank', 'bank_name', 'cardno', 'name');
			foreach($arr as $v){
				if(empty($_POST[$v])){
					$this -> error('请填写完整信息');
				}
			}
			
			$_POST['user_id'] = $this -> user['id'];
			M('bank_card') -> add($_POST);
			$this -> success('添加成功！', U('bankcard'));
			exit;
		}
		
		$banks = explode('|', $this -> _site['banks']);
		$this -> assign('banks', $banks);
		
		$this -> display();
	}
	
	// 删除银行卡
	public function bankcard_del(){
		M('bank_card') -> where(array('id' => intval($_GET['id']), 'user_id' => $this -> user['id'])) -> delete();
		redirect(U('Index/bankcard'));
	}
	
	// 通知中心
	public function notice(){
		$list = M('notice') -> select();
		$this -> assign('list', $list);
		$this -> display();
	}
	
	// 通知详情
	public function notice_detail(){
		$info = M('notice') -> find(intval($_GET['id']));
		$this -> assign('info', $info);
		$this -> display();
	}
	
	// 提现管理
	public function withdraw(){
		$list = M('withdraw') -> where('user_id='. $this -> user['id']) -> order("id desc") -> select();
		$this -> assign('list', $list);
		$this -> display();
	}
	
	// 申请提现
	public function withdraw_add(){
		if(IS_POST){
			// 检查金额
			$money = intval($_POST['money']);
			if($money < 50 || $money%50 >0){
				$this -> assign('errmsg', '金额必须大于50且是50的整数倍');
			}
			// 检查余额是否足够
			elseif($this -> user['money'] < $money){
				$this -> assign('errmsg', '可用余额不足！');
			}
			// 检查银行卡
			elseif(intval($_POST['bank'])){
				$bank = M('bank_card') -> where(array('user_id' => $this -> user['id'], 'id' => intval($_POST['bank']))) -> find();
				if(!$bank){
					$this -> assign('errmsg', '请选择银行卡');
				}else{
					// 减少可用余额
					M('user') -> where("id=".$this -> user['id']) -> save(array(
						'money' => $this -> user['money'] - $money
					));
					flog($this -> user['id'],'money',0-$money, 6); // 记录财务日志
					
					// 增加提现记录
					$rs = M('withdraw') -> add(array(
						'user_id' => $this -> user['id'],
						'money' => $money,
						'bank' => serialize($bank),
						'bank_id' => intval($_POST['bank']),
						'create_time' => NOW_TIME,
						'status' => 1
						));
					
					if($rs){
						$this -> success('提现申请成功！' , U('withdraw'));
						exit;
					}
					$this -> error('提现申请失败，请重试！');
				}
			}
		}
		
		// 查询我的银行卡信息
		$banks = M('bank_card') -> where('user_id='.$this -> user['id']) -> select();
		foreach($banks as &$v){
			$v['cardno'] = substr($v['cardno'],0,4).str_repeat('*', strlen($v['cardno'])-8).substr($v['cardno'],strlen($v['cardno'])-4,4);
		}
		if(count($banks) <1){
			$this -> assign('errmsg', "
			请先添加银行卡<a href='".U('bankcard_add')."'>现在去添加</a>
			");
		}else{
			$this -> assign('banks', $banks);
		}
		$this -> display();
	}
	
	// 我的推广二维码
	public function qrcode(){
		$this -> display();
	}
	
	// 显示/获取推广二维码图片
	public function get_qrcode(){
		header("Content-type: image/jpeg");
		
		// 忽略用户取消，限制执行时间为90s
		ignore_user_abort();
		set_time_limit(90);
		
		$path_info = get_qrcode_path($this -> user);
		
		// 已生成则直接返回
		if(is_file($path_info['new'])){
			echo file_get_contents($path_info['new']);
			exit;
		}
		
		// 目录不存在则创建
		if(!is_dir($path_info['path'])){
			mkdir($path_info['path'], 0777,1);
		}
		
		$dd = new \Common\Util\ddwechat($this -> _mp);
		
		if(!is_file($path_info['qrcode'])){
		
			
			$accesstoken = $dd -> getaccesstoken();
			$rs = $dd -> createqrcode('user_'.$this -> user['id'],null,$accesstoken);
			if(!$rs){
				if(APP_DEBUG){
					$this -> error($dd -> errmsg);
				}else{
					$this -> error('推广二维码生成失败，请稍后重试！');
				}
			}
			
			$qrcode_url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$rs['ticket'];
			$qrcode_img = $dd -> exechttp($qrcode_url, 'get', null , true); //file_get_contents($qrcode_url);
			if(!$qrcode_img){
				$this -> error('获取二维码失败');
			}
			
			// 保存图片	
			$save = file_put_contents($path_info['qrcode'],$qrcode_img);

			if(!$save){
				$this -> error('二维码保存失败！');
			}
		}
		// 合成
		$im_dst = imagecreatefromjpeg("./Public/images/tpl.jpg");
		$im_src = imagecreatefromjpeg($path_info['qrcode']);
		
		// 合成二维码（二维码大小282*282)
		imagecopyresized ( $im_dst, $im_src,204, 587, 0, 0, 231, 231, 430, 430);
		
		
		// 合成昵称
		$str = $this -> user['nickname'];
		$color = ImageColorAllocate($im_dst, 0,0,0);
		$font_info = imagettfbbox( 20 , 0 , './Public/font/simhei.ttf' , $str );
		$width = $font_info[2] -  $font_info[0];
		$left = (640 - $width)/2;
		$rs = imagettftext($im_dst, '20', 0, $left, 210, $color, './Public/font/simhei.ttf',  $str);
		
		// 不存在头像则保存像
		if(!is_file($path_info['head'])){
			$head_img = $dd -> exechttp($this -> user['headimg'], 'get', null , true);
			$head = file_put_contents($path_info['head'], $head_img); // file_get_contents($this -> user['headimg'])
		}
		// 合成头像
		$im_src = imagecreatefromjpeg($path_info['head']);
		imagecopyresized ( $im_dst, $im_src, 276, 64, 0, 0, 80, 80, 640, 640);
		
		
		// 保存
		imagejpeg($im_dst, $path_info['new']);
		
		// 输出
		imagejpeg($im_dst);
		
		// 销毁
		imagedestroy($im_src);
		imagedestroy($im_dst);
	}
	
	// 余额或者积分变动日志
	public function log(){
		$type = $_GET['type'] == 'points' ? 'points' : 'money';
		$where = array(
			'user_id' => $this -> user['id'],
			'type' => $type
		);
		
		$count = M('finance_log') -> where($where) -> count();
		$page = new \Think\Page($count, 20);
		$list = M('finance_log') -> where($where) -> order('id desc') 
				-> limit($page -> firstRow.','.$page -> listRows) -> select();

		$this -> assign('list', $list);
		$this -> assign('page', $page -> show());
		$this -> display();
	}
	
	// 我的分成记录
	public function separate(){
		$where['user_id'] = $this -> user['id'];
		$count = M('separate_log') -> where($where) -> count();
		$page = new \Think\Page($count, 20);
		$list = M('separate_log') -> where($where) -> order('id desc') 
				-> limit($page -> firstRow.','.$page -> listRows) -> select();

		$this -> assign('list', $list);
		$this -> assign('page', $page -> show());
		$this -> display();
	}
	
	// 统计昨日全站数据报告
	public function data(){
		$date = date('Ymd', strtotime('-1 day'));
		$info = M('data') -> where('date='.$date) -> find();
		// 如果有昨天的记录则结束
		if($info){
			exit;
		}
		
		$etime = strtotime('today');
		$stime = $etime - 86400;
		
		$where['create_time'] = array('between', "$stime and $etime");
		$data['orders'] = M('order') -> where($where) -> count();
		$data['total']  = M('order') -> where($where) -> sum('total'); 
		$data['wxpay']  = M('order') -> where($where) -> sum('wxpay');
		$data['subs']   = M('user') -> where("sub_time between $stime and $etime") -> count();
		
		$data['date'] = $date;
		
		M('data') -> add($data);
	}
	
	// ajax根据属性获取商品信息
	public function get_product_info(){
		$product_id = intval($_POST['product_id']);
		$attr = $_POST['attr'];
		$product_info = M('product') -> find($product_id);
		if(!$product_info){
			$this -> ajaxReturn(array('status' => 0,'info' => '没有这个商品'));
			exit;
		}
		// 如果开启了属性设置则查询属性对应内容
		if($product_info['attr_open'] >0){
			$attr_info = M('product_attr') -> where(array('product_id' => $product_id, 'attr' => $attr)) -> find();
			// 有指定属性的产品则返回属性价格和库存信息
			if($attr_info){
				$product_info['price'] = $attr_info['price'];
				$product_info['stock'] = $attr_info['stock'];
			}
			// 没有指定属性的产品返回商品价格和0库存
			else{
				$product_info['stock'] = 0;
			}
		}
		$this -> ajaxReturn(array(
			'status' => 1,
			'price' => $product_info['price'],
			'stock' => $product_info['stock']
		));
	}
	
	// 添加商品到购物车
	public function add_to_cart(){
		$product_id = intval($_POST['product_id']);
		$nums = intval($_POST['nums']);
		$attr = implode(',', $_POST['attr']);
		if($nums <1){
			$this -> error('数量有误');
		}
		$cart = M('order_product');
		
		$product_model = D('Product');
		
		// 产品信息
		$product_info = $product_model -> get_info($product_id, $attr);//
		if(!$product_info){
			$this -> error('数据错误');
		}
		
		/*
		// 如果有属性则查询属性的价格和库存信息
		if(!empty($attr)){
			$attr_info = M('product_attr') -> where(array('product_id' => $product_id, 'attr' => $attr)) -> find();
			// 有指定属性的产品则返回属性价格和库存信息
			if($attr_info){
				$product_info['price'] = $attr_info['price'];
				$product_info['stock'] = $attr_info['stock'];
			}
			// 没有指定属性的产品返回商品价格和0库存
			else{
				$product_info['stock'] = 0;
			}
		}
		*/
		
		// 判断库存
		if($product_info['stock'] < $nums){
			$this -> error('库存不足！');
			exit;
		}
		
		$wh  = array(
				'user_id' => $this -> user['id'],
				'product_id' => $product_id,
				'order_id' => 0
			);
		if(!empty($attr)){
			$wh['attr'] = $attr;
		}
		// 先判断购物车是否有这个商品，如果有则增加数量，没有则创建
		$record = $cart -> where($wh) -> find();
		
		if($record){
			$rs = $cart -> where('id='. $record['id']) -> setInc('nums', $nums);
		}else{
			$rs = $cart -> add(array(
					'user_id' => $this -> user['id'],
					'order_id' => 0,
					'product_id' => $product_id,
					'title' => $product_info['title'],
					'pic' => $product_info['pic'],
					'attr' => $attr,
					'price' => $product_info['price'],
					'market_price' => $product_info['market_price'],
					'separate_money' => $product_info['separate_money'],  // 用于分成金额
					'points' => $product_info['points'], // 赠送的积分
					'nums' => $nums
				));
		}
		
		// 减少库存
		$product_model -> set_stock_dec($nums, $product_id, $attr);
		/*
		M('product') -> where('id='.$product_id) -> setDec('stock', $nums);
		if(!empty($attr)){
			M('product_attr') -> where("id=".$attr_info['id']) -> setDec('stock',$nums);
		}*/
		
		if($rs){
			$this -> success('操作成功');
		}else{
			$this -> error('操作失败，请重试');
		}
	}
	
	// 删除购物车产品
	public function del_product(){
		$ids = $_POST['ids'];
		$id_arr = explode(',', $ids);
		
		// 对id进行过滤
		foreach($id_arr as &$v){
			if(!intval($v)>0){
				unset($v);
			}
		}
		
		$cart =  M('order_product');
		$product_model = D('Product');
		//$attr_model = M('product_attr');
		
		// 循环对商品库存进行恢复
		foreach($id_arr as $id){
			$cart_info = $cart -> find($id);
			/*  
			* -------使用Product模型之前需要依次对product和attr操作，使用后直接使用封装好的方法--------
			*
			$product_model -> where("id=".$cart_info['product_id']) -> setInc('stock', $cart_info['nums']);
			// 如果有属性则对属性库存恢复
			if(!empty($cart_info['attr'])){
				$attr_model -> where(array(
					'product_id' => $cart_info['product_id'],
					'attr' => $cart_info['attr']
				)) -> setInc('stock', $cart_info['nums']);
			}
			*/
			$product_model -> set_stock_inc($cart_info['nums'], $cart_info['product_id'], $cart_info['attr']);
		}
		
		$where = array(
			'user_id' => $this -> user['id'],
			'order_id' => 0,
			'id' => array('in', implode(',', $id_arr))
		);
		$rs = M('order_product') -> where($where) -> delete();
		
		// 计算购物车总额
		$total = $this -> _get_cart_total();
		
		if($rs){
			$this -> ajaxReturn(array('status' => 1, 'total' => $total));
			exit;
			//$this -> success('操作成功');
		}else{
			$this -> error('操作失败');
		}
	}
	
	// 设置购物车产品数量
	public function set_product(){
		$id = intval($_POST['id']);
		$nums = intval($_POST['nums']);
		if($nums <0)$nums = 0;
		
		$cart_model = M('order_product');
		$where = array('id' => $id, 'user_id' => $this -> user['id'], 'order_id' => 0);
		
		// 更新前的记录信息
		$cart_info = $cart_model -> where($where) -> find();
		
		$product_model = D('Product');
		
		// 如果数量增加则判断库存
		if($nums > $cart_info['nums']){
			$product_info = $product_model -> get_info($cart_info['product_id'], $cart_info['attr']);
			if($product_info['stock'] < $nums - $cart_info['nums']){
				$this -> error('库存不足');
			}
		}
		
		if($nums <= 0){
			$rs = $cart_model -> where($where) -> delete();
		}else{
			$rs = $cart_model -> where($where) -> setField('nums', $nums);
		}
		
		if(!$rs){
			$this -> error('操作失败，请重试！');
		}
		
		/*******更新库存 S*********/
		
		// 数量增加则减少库存
		if($nums > $cart_info['nums']){
			$product_model -> set_stock_dec($nums - $cart_info['nums'], $cart_info['product_id'], $cart_info['attr']);
		}
		//数量减少则增加库存
		else{
			$product_model -> set_stock_inc( $cart_info['nums'] - $nums, $cart_info['product_id'], $cart_info['attr']);
		}
		
		/*******更新库存 E*********/
		
		// 计算购物车总额
		$total = $this -> _get_cart_total();
		$this -> assign('total', $total);
		
		$this -> ajaxReturn(array('status' => 1, 'total' => $total));
		exit;
		//$this -> success('操作成功！');
	}
	
	// ajax获取用户名称和头像
	public function get_user_info(){
		$user_id = intval($_POST['user_id']);
		$user_info = M('user') -> field('nickname,headimg') -> find($user_id);
		if(!$user_info){
			$this -> error('用户不存在');
			exit;
		}
		
		$this -> ajaxReturn(array(
			'status' => 1,
			'nickname' => $user_info['nickname'],
			'headimg' => $user_info['headimg']
		));
	}
	
	// 计算购物车总额
	private function _get_cart_total($list = null, $type = 'price'){
		
		if(!$list){
			$cart = M('order_product');
			$list = $cart -> where(array('user_id' => $this -> user['id'], 'order_id' => 0)) -> select();
		}
		$total = 0;
		if(is_array($list)){
			// 计算总额
			
			foreach($list as $v){
				$total += $v['nums'] * $v[$type];
			}
			
			// 如果是计算总价格则保留两位小数点
			if($type == 'price'){
				$total = sprintf("%.2f", $total);
			}
		}
		return $total;
	}
	
	
	// 处理分成
	private function _separate($order){
		// 如果参数是订单id则查询订单信息
		if(!is_array($order)){
			$order = M('order') -> find(intval($order));
			if(!$order || empty($order['user_id']) || $order['user_id'] < 2){
				return false;
			}
		}
		
		// 如果订单已分成则退出
		if($order['separate']>0){
			return false;
		}
		
		$user = M('user');
		
		// 查询用户信息
		$user_info = $user -> find($order['user_id']);
		if(!$user_info){
			return false;
		}
		
		$dist = $this -> _dist;
		
		// 如果是商品设置分成总额分成则计算可分成总额
		if($dist['model'] == 2){
			$total = M('order_product') -> where('order_id='.$order['id']) -> sum('separate_money');
		}
		// 否则分成金额就是订单总额
		else{
			$total = $order['total'];
		}
		
		// 循环分红
		for($i=1; $i<=3; $i++){
			// 检查是否设置该级分成信息
			if(empty($dist["level{$i}_per"])){
				break;
			}
			// 检查是否有这一级别的上级
			if(empty($user_info['parent'.$i]) || $user_info['parent'.$i] <1){
				break;
			}
			
			// 查询上级资料
			$parent_info = $user -> find($user_info['parent'.$i]);
			if(!$parent_info){
				break; // 这级别代理都木有就没有在上一级了，直接跳出循环
			}
			
			// 进行分红
			$separate_money	= $total * $dist["level{$i}_per"]/100; // 分红金额
			$separate_points = $order['points_total'] * $dist["level{$i}_pper"]/100; // 积分金额
			M('separate_log') -> add(array(
					'user_id' => $user_info["parent{$i}"],
					'order_id' => $order['id'],
					'order_sn' => $order['sn'],
					'level' => $i,
					'money' => $separate_money,
					'points' => $separate_points,
					'status' => 1,
					'create_time' => NOW_TIME
				));
			
			M('order') -> where('id='.$order['id']) -> setInc('separate' , 1 );		
		}
	}
		
}?>