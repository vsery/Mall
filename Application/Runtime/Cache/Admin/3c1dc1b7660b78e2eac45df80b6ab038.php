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
				<script src="/mall/Public/plugins/My97DatePicker/WdatePicker.js"></script>
        <div class="pageheader notab">
            <h1 class="pagetitle">统计报表</h1>
            <span class="pagedesc">默认查看最近7天的数据</span>
            
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper lineheight21">
			<style>
			input.smallinput2 { 
				padding: 8px 5px; border: 1px solid #ccc; width: 120px !important; -moz-border-radius: 2px; -webkit-border-radius: 2px; 
				border-radius: 2px; background: #fcfcfc; vertical-align: middle; -moz-box-shadow: inset 0 1px 3px #ddd; 
				-webkit-box-shadow: inset 0 1px 3px #ddd; box-shadow: inset 0 1px 3px #ddd; color: #666;
			}

			</style>
        
			<div class="tableoptions">
				<span style=" float:left;">
					<form method="post" name="form" id="form">
						时间:
						<input type="text" class="smallinput2" name="stime" value="<?php echo ($_POST['stime']); ?>" onclick="WdatePicker()" />
						到
						<input type="text" class="smallinput2" name="etime" value="<?php echo ($_POST['etime']); ?>" onclick="WdatePicker()" />
						<button class="radius3" onclick="form.submit()">查询</button>
					</form>
				</span>
				<span style=" float:right;">
					<button class="radius3" onclick="showData('orders')">订单数</button>
					<button class="radius3" onclick="showData('total')">销售额</button>
					<button class="radius3" onclick="showData('wxpay')">现金支付</button>
					<button class="radius3" onclick="showData('subs')">关注人数</button>
				</span>
				<div style=" clear:both"></div>
			</div><!--tableoptions-->
			<div style="border:1px solid #ddd">
				<div id="container" style="min-width:800px;height:400px"></div>
			</div>
        </div><!--contentwrapper-->
		<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
		<script>
			data = <?php echo ($data); ?>;
			title = {orders:'订单数',total:'销售额',wxpay:'现金支付',subs:'关注人数'}
			jQuery(function () { 
				showData('orders')
			});
			
			function showData(type){
				jQuery('#container').highcharts({                   //图表展示容器，与div的id保持一致
						credits:{
							 enabled:false // 禁用版权信息
						},
						chart: {
							type: 'spline'                         //指定图表的类型，默认是折线图（line）
						},
						title: {
							text: title[type]+"数据报表"      //指定图表标题
						},
						xAxis: {
							categories: <?php echo ($cates); ?>   //指定x轴分组
						},
						yAxis: {
							title: {
								text: '金额/数量'                  //指定y轴的标题
							}
						},
						series: [{                                 //指定数据列
							name: title[type] ,                   //数据列名
							data: data[type]                        //数据
						}]
					});
			}
		</script>
        
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