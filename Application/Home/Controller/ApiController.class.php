<?php
namespace Home\Controller;
use Think\Controller;
class ApiController extends Controller {
    public function index(){
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

		// 验证URL
		if(isset($_GET['echostr'])){
			die($_GET['echostr']);
		}
		
		$dd = new \Common\Util\ddwechat;
		$this -> dd = $dd;
		$this -> data = $dd -> request();

		// 判断mp配置
		if(!$this -> _mp){
			$dd -> response('管理员没有配置公众号信息');
			exit;
		}
		
		// TODO 可以在这里判断fromusername和配置中的微信数据是否匹配来增加安全性
		
		$dd -> setParam($this -> _mp);
		
		//file_put_contents('a.txt', var_export($this -> data,1));
		
		//如果是关注
		if($this -> data['msgtype'] == 'event'){
			// 关注
			if($this -> data['event'] == 'subscribe'){
				$user_info = M('user') -> where("openid='".$this -> data['fromusername']."'") -> find();
				if(!$user_info){
					// 首次关注,将用户信息保存到数据库
					$accesstoken = $dd -> getaccesstoken();
					if(!$accesstoken && APP_DEBUG){
						$dd -> response('accesstoken获取失败:' . $dd -> errmsg);
					}
					$wechat_user = $dd -> getuserinfo($this -> data['fromusername']);
					if(!$wechat_user && APP_DEBUG){
						$dd -> response('获取用户信息失败:'. $dd -> errmsg);
					}
					$user_info = array(
							'openid' => $this -> data['fromusername'],
							'subscribe' => 1,
							'sub_time' => NOW_TIME,
							'nickname' => $wechat_user['nickname'],
							'headimg' => $wechat_user['headimgurl'],
							'sex' => $wechat_user['sex']
					);
					$rs = M('user') -> add($user_info);
					if(!$rs && APP_DEBUG){
						$dd -> response('保存用户信息失败');
					}
					
					$user_info['id'] = $rs;
					
					// 如果是带参数的二维码则锁定上级关系
					if(!empty($this -> data['eventkey'])){
						//$dd -> response($this -> data['eventkey']);
						
						$param = str_replace('qrscene_user_','', $this -> data['eventkey']);
						if(intval($param) >0){
							$parent_info = M('user') -> find(intval($param));
							if($parent_info){
								M('user') -> where('id='.$rs) -> save(array(
									'parent1' => $parent_info['id'],
									'parent2' => $parent_info['parent1'],
									'paernt3' => $parent_info['parent2']
								));
								
								// 增加上级的统计
								M('user') -> where('id='.$parent_info['id']) -> setInc('agent1');
								M('user') -> where('id='.$parent_info['parent1']) -> setInc('agent2');
								M('user') -> where('id='.$parent_info['parent2']) -> setInc('agent3');
								
								//依次更新上级等级
								update_level($parent_info, $this ->_level);
								update_level($parent_info['parent1'], $this ->_level);
								update_level($parent_info['parent2'], $this ->_level);
							}
						}
					}
				}
				
				//如果设置了关注时回复关键词则调用回复
				if(!empty($this -> _site['subscribe'])){
					$this -> reply_by_keyword($this -> _site['subscribe']);
				}
				
				
				// 保存头像
				$path_info = get_qrcode_path($user_info);
				if(!is_file($path_info['head'])){
					if(!is_dir($path_info['path'])){
						mkdir($path_info['path'], 0777, 1);
					}
					file_put_contents($path_info['head'], file_get_contents($user_info['headimg']));
				}
			
			}
			
			// 取消关注
			elseif( $this -> data['event'] == 'unsubscribe'){
				$rs = M('user') -> where(array('openid' => $this -> data['fromusername'])) -> setField('subscribe', 0);
			}
			
			// 点击自定义菜单
			elseif( $this -> data['event'] == 'CLICK'){
				$this -> reply_by_keyword($this -> data['eventkey']);
			}
		}
		
		
		// 如果是发送文字
		elseif($this -> data['msgtype'] == 'text' && !empty($this -> data['content'])){
			$this -> reply_by_keyword($this -> data['content']);
			
		}
		
		// 未处理的事件全部返回空
		else{
			exit('success');
		}
		
		exit('success');
    }
	
	// 根据关键词回复
	private function reply_by_keyword($key){
		$dd = &$this -> dd;
		$replys = M('autoreply') -> where(array(
			'status' => 1,
			'_string' => "find_in_set('{$key}',keyword)"
		)) -> fetchSql(0) -> select();
		
		// 没有关键词对应回复
		if(empty($replys) || count($replys)<1){
			exit('success');
		}
		
		// 只有用一条记录,且是文本回复
		elseif(count($replys) ==1 && $replys[0]['type'] == 1){ // 
			$row = $replys[0];
			if(!empty($row['content'])){
				$dd -> response($row['content']);
			}
		}
		
		// 多条记录或者一条图文记录都是图文回复
		else{
			$pids = array();
			foreach($replys as $row){
				if($row['type'] ==2){
					$pids[] = $row['id'];
				}
			}
			if(count($pids) >0){
				// 查询所有文章
				$articles = M('article') -> where(array(
					'autoreply_id' => array('in', $pids)
				)) -> limit(10) -> order('id desc') -> select();

				foreach($articles as $article){
					$msgs[] = array(
						'title' => $article['title'],
						'description' => $article['desc'],
						'picurl' => complete_url($article['cover']),
						'url' => complete_url(U('Article/read?id='.$article['id']))
					);
				}
				$dd -> response(array('articles' => $msgs), 'news');
			}
		}
	}
}