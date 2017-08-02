<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>管理后台</title>
<link rel="stylesheet" href="/mall/Public/admin/css/style.default.css" type="text/css" />
<link rel="stylesheet" href="/mall/Public/plugins/bootstrap/css/bootstrap.font.css" type="text/css" />
<script type="text/javascript" src="/mall/Public/admin/js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/mall/Public/admin/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/mall/Public/admin/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="/mall/Public/admin/js/custom/general.js"></script>

<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
	<script src="js/plugins/css3-mediaqueries.js"></script>
<![endif]-->
</head>

<body class="withvernav">
<div class="bodywrapper">
    <div class="topheader">
        <div class="left">
            <h1 class="logo">分销.<span>商城</span></h1>
            <span class="slogan">后台管理系统</span>
                 
            <br clear="all" />
            
        </div><!--left-->
		<div class="right">
        	 <span style=" color:#fff;"><?php echo session('admin');?> <a href="<?php echo U('Index/logout');?>" style=" color:#ccc;">[退出]</a></span>
        </div><!--right-->

    </div><!--topheader-->
    
    <style>
	.vernav2 span.text{ padding-left:10px;}
	.menucoll2 span.text{ display:none;}
	.menucoll2>ul>li>a{ width:12px; padding:9px 10px; !important;}
	</style>
    <div class="vernav2 iconmenu">
    	<ul>
        	<li>
				<a href="#formsub">
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					<span class="text">系统设置</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="formsub">
               		<li><a href="<?php echo U('Config/site');?>">网站设置</a></li>
					<li><a href="<?php echo U('Config/user');?>">管理员设置</a></li>
                    <li><a href="<?php echo U('Config/mp');?>">公众号设置</a></li>
                    <li><a href="<?php echo U('Config/dist');?>">分销设置</a></li>
					<li><a href="<?php echo U('Config/level');?>">等级设置</a></li>
					<li><a href="<?php echo U('Config/banner');?>">轮播图设置</a></li>
					<li><a href="<?php echo U('Config/tpl');?>">模板设置</a></li>
					<li><a href="<?php echo U('Config/css');?>">自定义样式</a></li>
                </ul>
            </li>
			<li>
				<a href="#product" class="elements">
					<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
					<span class="text">商品管理</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="product">
					<li><a href="<?php echo U('Product/index');?>">商品管理</a></li>
               		<li><a href="<?php echo U('Product/cate');?>">分类设置</a></li>
                </ul>
            </li>
			<li>
				<a href="<?php echo U('Notice/index');?>" class="editor">
					<span class="glyphicon glyphicon-volume-down" aria-hidden="true"></span>
					<span class="text">通知公告管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Order/index');?>" class="typo">
					<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
					<span class="text">订单管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('User/index');?>" class="tables">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					<span class="text">用户管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Reward/index');?>" class="support">
					<span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
					<span class="text">绩效管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Withdraw/index');?>" class="support">
					<span class="glyphicon glyphicon-import" aria-hidden="true"></span>
					<span class="text">提现管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Selfmenu/index');?>" class="widgets">
					<span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>
					<span class="text">自定义菜单管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Autoreply/index');?>" class="addons">
					<span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
					<span class="text">自动回复管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Sk/index');?>">
					<span class="glyphicon glyphicon-eur" aria-hidden="true"></span>
					<span class="text">收款管理</span>
				</a>
            </li>
			<li>
				<a href="#report" class="elements">
					<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
					<span class="text">统计分析</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="report">
					<li><a href="<?php echo U('Report/index');?>">数据报表</a></li>
               		<li><a href="<?php echo U('Report/instant');?>">实时数据</a></li>
                </ul>
            </li>
			<li>
				<a href="<?php echo U('Update/index');?>" class="editor">
					<span class="glyphicon glyphicon-open" aria-hidden="true"></span>
					<span class="text">在线升级</span>
				</a>
            </li>
        </ul>
        <a class="togglemenu"></a>
        <br /><br />
    </div><!--leftmenu-->
        
    <div class="centercontent">
		
        <div class="pageheader notab">
            <h1 class="pagetitle">编辑自定义菜单</h1>
            <span class="pagedesc">编辑自定义菜单的详细信息</span>
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper lineheight21">
        
			<form class="stdform stdform2" method="post">
				<p>
					<label>名称<small>自定义菜单显示的名字</small></label>
					<span class="field"><input type="text" name="name" id="name" value="<?php echo ($info["name"]); ?>" class="smallinput" /></span>
				</p>
				<p>
					<label>排序值<small>越大越排前</small></label>
					<span class="field"><input type="text" name="sort" id="sort" value="<?php echo ($info["sort"]); ?>" class="smallinput" /></span>
				</p>
				<p>
					<label>上级菜单</label>
					<span class="field">
						<select name="pid"  default="<?php echo ($info["pid"]); ?>">
							<option value="0">顶级菜单</option>
							<?php if(is_array($parents)): $i = 0; $__LIST__ = $parents;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($_GET['id'] == $vo['id']): ?>disabled<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</span>
				</p>
				<p>
					<label>类型</label>
					<span class="field">
						<select name="type" default="<?php echo ($info["type"]); ?>" id="type_selector" onclick="type_change()">
							<option value="click">点击推事件</option>
							<option value="view">跳转URL</option>
							<option value="scancode_push">扫码推事件</option>
							<option value="scancode_waitmsg">扫码推事件且弹出“消息接收中”提示框</option>
							<option value="pic_sysphoto">弹出系统拍照发图</option>
							<option value="pic_photo_or_album">弹出拍照或者相册发图</option>
							<option value="pic_weixin">弹出微信相册发图器</option>
							<option value="location_select">弹出地理位置选择器</option>
						</select>
						<script>
						function type_change(){
							obj = document.getElementById('type_selector');
							i = 0;
							jQuery(obj).find("option").each(function(index, el){
								if(jQuery(el).is(":selected")){
									//jQuery(".type-remark").hide().eq(i).show();
									jQuery("#tips").html(jQuery(".type-remark").eq(i).html())
								}
								i++;
							});
						}
						jQuery(document).ready(function(e){
							$ = jQuery;
							// 调整默认选择内容
							jQuery("select").each(function(index, element) {
								$(element).find("option[value='"+$(this).attr('default')+"']").attr('selected','selected');
							});
							// 调整提示内容
							type_change()
						});
						</script>
					</span>
				</p>
				<p>
					<label>说明</label>
					<span class="field" id="tips">
						<b>click：点击推事件</b>
						用户点击click类型按钮后，微信服务器会通过消息接口推送消息类型为event	的结构给开发者（参考消息接口指南），并且带上按钮中开发者填写的key值，开发者可以通过自定义的key值与用户进行交互；
						
					</span>
				</p>
				<p>
					<label>附加内容<small>请填写关键词、网址后者key</small></label>
					<span class="field"><input type="text" name="extra" id="extra" value="<?php echo ($info["extra"]); ?>" class="smallinput" /></span>
				</p>
				
				
				<p class="stdformbutton">
					<button class="submit radius2">提交</button>
					<input type="reset" class="reset radius2" value="重置" />
				</p>
			</form>
        
        </div><!--contentwrapper-->
        
		<div class="contentwrapper lineheight21">
			<style>
			.type-remark{ display:none;}
			</style>
			<div class="type-remark">
			<b>click：点击推事件</b>
			用户点击click类型按钮后，微信服务器会通过消息接口推送消息类型为event	的结构给开发者（参考消息接口指南），并且带上按钮中开发者填写的key值，开发者可以通过自定义的key值与用户进行交互；
			</div>
			<div class="type-remark">
			<b>view：跳转URL</b>
			用户点击view类型按钮后，微信客户端将会打开开发者在按钮中填写的网页URL，可与网页授权获取用户基本信息接口结合，获得用户基本信息。
			</div>
			<div class="type-remark">			
			<b>scancode_push：扫码推事件</b>
			用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后显示扫描结果（如果是URL，将进入URL），且会将扫码的结果传给开发者，开发者可以下发消息。
			</div>
			<div class="type-remark">
			<b>scancode_waitmsg：扫码推事件且弹出“消息接收中”提示框</b>
			用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后，将扫码的结果传给开发者，同时收起扫一扫工具，然后弹出“消息接收中”提示框，随后可能会收到开发者下发的消息。
			</div>
			<div class="type-remark">
			<b>pic_sysphoto：弹出系统拍照发图</b>
			用户点击按钮后，微信客户端将调起系统相机，完成拍照操作后，会将拍摄的相片发送给开发者，并推送事件给开发者，同时收起系统相机，随后可能会收到开发者下发的消息。
			</div>
			<div class="type-remark">
			<b>pic_photo_or_album：弹出拍照或者相册发图</b>
			用户点击按钮后，微信客户端将弹出选择器供用户选择“拍照”或者“从手机相册选择”。用户选择后即走其他两种流程。
			</div>
			<div class="type-remark">
			<b>pic_weixin：弹出微信相册发图器</b>
			用户点击按钮后，微信客户端将调起微信相册，完成选择操作后，将选择的相片发送给开发者的服务器，并推送事件给开发者，同时收起相册，随后可能会收到开发者下发的消息。
			</div>
			<div class="type-remark">
			<b>location_select：弹出地理位置选择器</b>
			用户点击按钮后，微信客户端将调起地理位置选择工具，完成选择操作后，将选择的地理位置发送给开发者的服务器，同时收起位置选择工具，随后可能会收到开发者下发的消息。
			</div>
		</div>
	</div><!-- centercontent -->
    
    
</div><!--bodywrapper-->
<script>
	jQuery(document).ready(function(e){
		// 菜单添加提示 
		$ = jQuery;
		$(".vernav2 ul li").each(function(index, el){
			$(this).attr('title', $(this).find("a").find('span.text').text());
		});
		
		// 调整默认选择内容
		$("select").each(function(index, element) {
			$(element).find("option[value='"+$(this).attr('default')+"']").attr('selected','selected');
		});
		// 调整提示内容
	});
</script>
</body>
</html>