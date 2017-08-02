<?php
namespace Home\Model;
use Think\Model;

class ProductModel extends Model{
	
	// ��ȡ��Ʒ��Ϣ
	public function get_info($product_id, $attr = null){
		$product_info = $this -> find($product_id);
		if($attr){
			$attr_info = M('product_attr') -> where(array(
				'product_id' => $product_id,
				'attr' => $attr
			)) -> find();
			
			// �鵽�����Զ�Ӧ����Ϣ��۸�Ϳ���滻Ϊ���Ե���Ϣ
			if($attr_info){
				$product_info['price'] = $attr_info['price'];
				$product_info['stock'] = $attr_info['stock'];
			}
			// û�в鵽���Ե���Ϣ��۸�ʹ����Ʒ�۸񣬿��Ϊ0
			else{
				$product_info['stock'] = 0;
			}
		}
		return $product_info;
	}
	
	// ���ӿ��
	public function set_stock_inc($nums, $product_id, $attr){
		M('product') -> where('id='.$product_id) -> setInc('stock', $nums);
		if($attr){
			M('product_attr') -> where(array(
				'product_id' => $product_id,
				'attr' => $attr
			)) -> setInc('stock', $nums);
		}
	}
	
	//���ٿ��
	public function set_stock_dec($nums, $product_id, $attr){
		M('product') -> where('id='.$product_id) -> setDec('stock', $nums);
		if($attr){
			M('product_attr') -> where(array(
				'product_id' => $product_id,
				'attr' => $attr
			)) -> setDec('stock', $nums);
		}
	}
}