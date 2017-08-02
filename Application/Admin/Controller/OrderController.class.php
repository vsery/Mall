<?php
namespace Admin\Controller;
use Think\Controller;
class OrderController extends AdminController {
    // 通知列表
	public function index(){
		if(IS_POST){
			$_GET  =$_REQUEST;
		}
		if(!empty($_GET['status'])){
			$where['status'] = intval($_GET['status']);
		}else{
			$where['status'] = array('gt', 1); //默认不现实待支付订单
		}
		if(!empty($_GET['time1']) && !empty($_GET['time2'])){
			$where['create_time'] = array(
				array('gt', strtotime($_GET['time1'])),
				array('lt', strtotime($_GET['time2']) + 86400)
			);
		}
		elseif(!empty($_GET['time1'])){
			$where['create_time'] = array('gt', strtotime($_GET['time1']));
		}
		elseif(!empty($_GET['time2'])){
			$where['create_time'] = array('lt', strtotime($_GET['time2'])+86400);
		}
		
		// 总订单数
		$this -> assign('orders', M('order') -> where($where) -> count());
		// 总额
		$this -> assign('total', M('order') -> where($where) -> sum('total'));
		
		$this -> _list('order');
	}
	
	// 订单详情
	public function detail(){
		$id = intval($_GET['id']);
		$order_info = M('order') -> find($id);
		if(!$order_info){
			$this -> error('订单不存在');
		}
		$this -> assign('info', $order_info);
		
		//查询商品信息
		$product_list = M('order_product') -> where(array('order_id' => $order_info['id'])) -> select();
		$this -> assign('products', $product_list);
		
		$this -> display();
	}
	
	// ajax设置快递信息,发货
	public function set_express(){
		$name = I('post.name');
		$no = I('post.no');
		$order_id = intval($_POST['order']);
		$rs = M('order') -> where("id={$order_id}") -> save(array(
			'express' => $name,
			'express_no' => $no,
			'delivery_time' => NOW_TIME, //发货时间
			'status' => 3 // 已发货状态
		));
		
		if($rs){
			$this -> success('操作成功！');
			exit;
		}else{
			$this -> error('操作失败，请重试！');
		}
	}
	
	// 取消订单
	public function cancle_order(){
		$order_id = intval($_POST['order']);
		$order_model = M('order');
		$order_info = $order_model -> find($order_id);
		
		// 订单状态设置为-1
		$order_model -> where('id='.$order_id) -> save(array(
			'status' => -1,
			'confirm_time' => NOW_TIME
		));

		// 分成状态设置为-1
		M('separate_log') -> where('order_id='.$order_id) -> setField('status', -1);
		
		// 如果是已完成状态，则表示分成已到帐，需要扣除
		if($order_info['status'] == 4){
			$user_model = M('user');
			$slog = M('separate_log') -> where('order_id='.$order_id) -> select();
			foreach($slog as $log){
				$user_model -> where('id='.$log['user_id']) -> save(array(
					'money' => array('exp', 'money-'.$log['money']),
					'points' => array('exp', 'points-'.$log['points']),
				));
			}
		}
		$this -> success('操作成功！');
	}
	
	// 删除通知
	public function del(){
		
	}
}