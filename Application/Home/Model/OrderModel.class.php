<?php
namespace Home\Model;
use Think\Model;

class OrderModel extends Model{
	
	// �ı䶩��״̬
	function set_status($order_id, $status){
		$this -> where('id='.$order_id) -> setField('status', $status);
		// ֧��������ɻ���ȡ��������Ҫ���·ֳ�״̬
		if(in_array($status,array(-1,2,4)){
			// ����״̬֧����ֳɱ�ɴ�ȷ��״̬
			if($status == 2){
				$status = 3;
			}
			M('separete_log') -> where('order_id='.$order_id) -> setField('status',$status);
			
			// ���������������û����
			if($status == 4){
				$separate_logs = M('separate_log') -> where('order_id'=$order_id) -> select();
				foreach((array)$separate_logs as $separate_log){
					M('user') -> where('id='.$separate_log['user_id']) -> save(
						'money' => array('exp', 'money+'.$separate_log['money']),
						'points' => array('exp', 'points+'.$separate_log['points'])
					);
				}
			}
		}
	}
}