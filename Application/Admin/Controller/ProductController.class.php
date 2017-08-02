<?php
namespace Admin\Controller;
use Think\Controller;
class ProductController extends AdminController {
    // 商品列表
	public function index(){
		$this -> _list('product');
	}
	
	// 编辑、添加商品
	public function edit(){
		if(IS_POST){
			if($_POST['attr_open'] != 1){
				$_POST['attr_open'] = 0;
			}
			
			$_POST['attr'] = implode(',',$_POST['attr_name']); // 属性
			
			$attr_type = count($_POST['attr_name']);
			foreach($_POST['attr_value'] as $key => $val){
				$_POST['attr_values'][$key%$attr_type][] = trim($val);
			}
			$_POST['attr_values'] = serialize($_POST['attr_values']);
			
			//属性值
			//$_POST['attr_value'] = array();
			
			
			$attr_table = array(
				'attr' => $_POST['attr_value'],
				'price' => $_POST['attr_price'],
				'stock' => $_POST['attr_stock'],
				'code' => $_POST['attr_code']
			);
						
			// 修改
			if(isset($_GET['id'])){
				$rs = M('product') -> where('id='.intval($_GET['id'])) -> save($_POST);
				$product_id = intval($_GET['id']);
			}
			
			// 添加
			else{
				$rs = M('product') -> add($_POST);
				$product_id = $rs;
			}
			
			// 如果操作成功则处理属性内容
			$rows = $this -> format($attr_table);
			foreach($rows as $row){
				$row['product_id'] = $product_id;
				$row['create_time'] = NOW_TIME;
				
				$where = array(
					'product_id' => $row['product_id'],
					'attr' => $row['attr']
				);
				
				// 有相同属性组合则修改，没有则增加
				if(M('product_attr') -> where($where) -> find()){
					M('product_attr') -> where($where) -> save($row);
				}else{
					M('product_attr') -> add($row);
				}
			}
			
			// 删除本次没有修改的属性组合
			M('product_attr') -> where(array('product_id' => $product_id, 'create_time' => array('neq', NOW_TIME))) -> delete();
			
			$this -> success('操作成功！', U('index'));
			exit;
		}
		
		if(intval($_GET['id'])>0){
			$info = M('product') -> find($_GET['id']);
			$info['attr'] = explode(',', $info['attr']);
			
			$temp = unserialize($info['attr_value']);
			
			$info['attr_table'] = M('product_attr') -> where(array('product_id' => $info['id'])) -> order('id asc') -> select();

			// 对属性组合进行分解
			foreach($info['attr_table'] as &$val){
				$val['attr'] = explode(',', $val['attr']);
			}
			$this -> assign('info', $info);
		}
		
		// 查询分类信息
		$cates = M('product_cate') -> select();
		$this -> assign('cates', $cates);
				
		
		$this -> display();
	}
	
	
	// 根据attr_table格式化数据
	private function format($attr_table){
		if(!is_array($attr_table)){
			$attr_table = unserialize($attr_table);
		}
		// 属性种类数
		$attr_count = count($attr_table['attr']) / count($attr_table['price']);
		// 最后的结果
		$rows = array();
		foreach($attr_table['price'] as $key => $val){
			$attr_tmp = array();
			for($i=0; $i<$attr_count;$i++){
				$attr_tmp[] = $attr_table['attr'][$key*$attr_count+$i];
			}
			$rows[] = array(
				'attr' => implode(',', $attr_tmp),
				'price' => $attr_table['price'][$key],
				'stock' => $attr_table['stock'][$key],
				'code' => $attr_table['code'][$key]
			);
		}
		return $rows;
		
	}
	
	// 删除商品
	public function del(){
		$this -> _del('product', $_GET['id']);
		// 删除相关的属性
		M('product_attr') -> where(array('product_id'=>intval($_GET['id']))) -> delete();
		$this -> success('操作成功！', $_SERVER['HTTP_REFERER']);
	}
	
	/***以下是分类管理***/
	
	// 列表
	public function cate(){
		$list = M('product_cate') -> order('sort desc') -> select();
		$this -> assign('list', $list);
		$this -> display();
	}
	
	// 编辑
	public function cate_edit(){
		$this -> _edit('product_cate',U('cate'));
	}
	
	// 删除
	public function cate_del(){
		$this -> _del('product_cate', $_GET['id']);
		$this -> success('操作成功！', U('cate'));
	}
}