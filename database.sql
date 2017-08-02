-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 12 月 10 日 00:08
-- 服务器版本: 5.5.36
-- PHP 版本: 5.3.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `dd_addr`
--

CREATE TABLE IF NOT EXISTS `dd_addr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `addr` varchar(200) NOT NULL,
  `district` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `dd_addr`
--

INSERT INTO `dd_addr` (`id`, `user_id`, `name`, `mobile`, `addr`, `district`) VALUES
(1, 10001, '龙哥', '13800138000', '江南大道57号金岸小区2栋5喽502室', '安徽省||六安市||裕安区'),
(2, 10018, '约块', '13888888888', '见见你吧比较接近', '山西省||朔州市||右玉县'),
(3, 10024, '刘先生', '185715726817', '东三环南路906', '北京市||朝阳区');

-- --------------------------------------------------------

--
-- 表的结构 `dd_article`
--

CREATE TABLE IF NOT EXISTS `dd_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autoreply_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(20) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `show_cover` tinyint(3) NOT NULL DEFAULT '0',
  `desc` varchar(255) DEFAULT NULL,
  `body` text,
  `link` varchar(255) DEFAULT NULL,
  `create_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `dd_autoreply`
--

CREATE TABLE IF NOT EXISTS `dd_autoreply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(50) DEFAULT NULL,
  `type` tinyint(3) DEFAULT NULL,
  `content` text,
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `dd_autoreply`
--

INSERT INTO `dd_autoreply` (`id`, `keyword`, `type`, `content`, `status`) VALUES
(1, '案例说明', 1, '案例不一定和程序一模一样，部分案例是根据需求定制过的。如果您喜欢或者有其他想法也可以和我们客服洽谈定制!', 1),
(2, '联系方式', 1, '微信：dragondean\r\nQ  Q：2045003697\r\n电话：4000012713', 1),
(3, '关注', 1, '欢迎关注百思商盟，点击自定义菜单了解更多信息!<a href="http://store.besttool.cn">点击这里进入演示商城</a>', 1),
(4, '后台功能', 1, '系统设置\r\n    - 网站设置\r\n    - 管理员设置\r\n    - 公众号设置\r\n    - 分销设置\r\n    - 等级设置\r\n    - 轮播图设置\r\n商品管理\r\n    - 商品 管理\r\n    - 分类管理\r\n通知公告管理\r\n订单管理\r\n用户管理\r\n提现管理\r\n自定义菜单管理\r\n自动回复管理\r\n收款管理\r\n统计分析\r\n在线升级\r\n\r\n后台演示请用电脑打开http://test.besttool.cn/?m=Admin&a=login\r\n登录账号和密码都是admin', 1);

-- --------------------------------------------------------

--
-- 表的结构 `dd_bank_card`
--

CREATE TABLE IF NOT EXISTS `dd_bank_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `cardno` varchar(30) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `dd_bank_card`
--

INSERT INTO `dd_bank_card` (`id`, `user_id`, `bank`, `bank_name`, `cardno`, `name`) VALUES
(1, 10001, '工商银行', '吉林支行新山街储蓄所', '6222222222222222222', '龙哥');

-- --------------------------------------------------------

--
-- 表的结构 `dd_config`
--

CREATE TABLE IF NOT EXISTS `dd_config` (
  `name` varchar(20) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dd_config`
--

INSERT INTO `dd_config` (`name`, `value`) VALUES
('mp', 'a:4:{s:5:"appid";s:18:"wx1713cd2aec21c7fb";s:9:"appsecret";s:32:"e5fb7710ef3c92ba639f99c799622eb4";s:6:"mch_id";s:10:"1276847501";s:3:"key";s:32:"d90824a5a8224fd7bb4fdffd331c62ab";}'),
('user', 'a:2:{s:4:"name";s:5:"admin";s:4:"pass";s:32:"0ba20fa90177c0540747df3f33ab8b0f";}'),
('site', 'a:9:{s:4:"name";s:12:"分销商城";s:6:"charge";s:22:"500|700|1000|2000|5000";s:5:"banks";s:103:"工商银行|农业银行|建设银行|邮政银行|中国银行|招商银行|交通银行|广发银行";s:6:"prefix";s:2:"CV";s:11:"points_rate";s:2:"10";s:11:"points_name";s:9:"购物币";s:9:"rank_name";s:12:"全国100强";s:9:"subscribe";s:6:"关注";s:3:"tel";s:10:"4000012713";}'),
('dist', 'a:11:{s:11:"parent_name";s:9:"推荐人";s:5:"model";s:1:"1";s:11:"level1_name";s:9:"总代理";s:10:"level1_per";s:2:"10";s:11:"level1_pper";s:1:"7";s:11:"level2_name";s:9:"总经销";s:10:"level2_per";s:2:"10";s:11:"level2_pper";s:1:"6";s:11:"level3_name";s:9:"零售商";s:10:"level3_per";s:1:"5";s:11:"level3_pper";s:1:"5";}'),
('level', 'a:6:{i:0;a:7:{s:4:"name";s:12:"普通商户";s:6:"orders";i:0;s:5:"agent";i:0;s:9:"agent_all";i:0;s:4:"dist";s:1:"1";s:8:"withdraw";s:1:"1";s:7:"deposit";s:1:"1";}i:1;a:7:{s:4:"name";s:12:"黄金商户";s:6:"orders";s:1:"2";s:5:"agent";s:2:"20";s:9:"agent_all";i:0;s:4:"dist";s:1:"1";s:8:"withdraw";s:1:"1";s:7:"deposit";s:1:"1";}i:2;a:7:{s:4:"name";s:12:"铂金商户";s:6:"orders";s:1:"3";s:5:"agent";i:0;s:9:"agent_all";s:3:"200";s:4:"dist";s:1:"1";s:8:"withdraw";s:1:"1";s:7:"deposit";s:1:"1";}i:3;a:7:{s:4:"name";s:12:"钻石商户";s:6:"orders";s:1:"4";s:5:"agent";i:0;s:9:"agent_all";s:4:"1700";s:4:"dist";s:1:"1";s:8:"withdraw";s:1:"1";s:7:"deposit";s:1:"1";}i:4;a:7:{s:4:"name";s:12:"皇冠商户";s:6:"orders";s:1:"5";s:5:"agent";i:0;s:9:"agent_all";s:4:"5000";s:4:"dist";i:0;s:8:"withdraw";i:0;s:7:"deposit";i:0;}i:5;a:7:{s:4:"name";s:12:"王者商户";s:6:"orders";s:4:"1333";s:5:"agent";s:3:"123";s:9:"agent_all";s:3:"321";s:4:"dist";i:0;s:8:"withdraw";i:0;s:7:"deposit";i:0;}}'),
('banner', 'a:1:{s:6:"config";a:3:{i:0;a:2:{s:3:"pic";s:53:"./Public/upload/images/1510/21/105013368326008225.jpg";s:3:"url";s:20:"http://www.baidu.com";}i:1;a:2:{s:3:"pic";s:53:"./Public/upload/images/1511/05/202831052631001661.jpg";s:3:"url";s:0:"";}i:2;a:2:{s:3:"pic";s:53:"./Public/upload/images/1510/21/105022145828003593.jpg";s:3:"url";s:0:"";}}}'),
('interest', 'a:2:{s:4:"rate";s:4:"0.01";s:4:"nums";s:2:"10";}'),
('tpl', 'a:1:{s:5:"index";s:7:"default";}');

-- --------------------------------------------------------

--
-- 表的结构 `dd_data`
--

CREATE TABLE IF NOT EXISTS `dd_data` (
  `date` int(11) NOT NULL,
  `orders` int(11) DEFAULT '0',
  `wxpay` int(11) DEFAULT '0',
  `total` int(11) DEFAULT '0',
  `subs` int(11) DEFAULT '0',
  PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dd_data`
--

INSERT INTO `dd_data` (`date`, `orders`, `wxpay`, `total`, `subs`) VALUES
(20151104, 1, NULL, NULL, 0),
(20151103, 3, NULL, NULL, 0),
(20151105, 6, NULL, NULL, 0),
(20151110, 4, NULL, NULL, 0),
(20151112, 6, NULL, NULL, 0),
(20151113, 1, NULL, NULL, 0),
(20151114, 3, NULL, NULL, 0),
(20151117, 2, NULL, NULL, 0),
(20151118, 7, NULL, NULL, 0),
(20151119, 3, NULL, NULL, 7),
(20151121, 5, NULL, NULL, 0),
(20151122, 6, NULL, NULL, 1),
(20151123, 9, NULL, NULL, 0),
(20151124, 2, NULL, NULL, 0),
(20151126, 4, NULL, NULL, 0),
(20151127, 7, NULL, NULL, 0),
(20151128, 0, NULL, NULL, 0),
(20151129, 0, NULL, NULL, 4),
(20151130, 0, NULL, NULL, 4),
(20151202, 0, NULL, NULL, 0),
(20151209, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `dd_deposit`
--

CREATE TABLE IF NOT EXISTS `dd_deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deposit_user` int(11) NOT NULL,
  `accept_user` int(11) NOT NULL,
  `accept_user_name` varchar(20) NOT NULL,
  `money` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `dd_finance_log`
--

CREATE TABLE IF NOT EXISTS `dd_finance_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `money` float(10,2) NOT NULL,
  `action` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `dd_finance_log`
--

INSERT INTO `dd_finance_log` (`id`, `user_id`, `type`, `money`, `action`, `create_time`) VALUES
(1, 10001, 'money', -100.00, 6, 1448715508),
(2, 10018, 'points', 0.00, 8, 1448818445),
(3, 10018, 'money', 0.00, 8, 1448818445);

-- --------------------------------------------------------

--
-- 表的结构 `dd_notice`
--

CREATE TABLE IF NOT EXISTS `dd_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `dd_order`
--

CREATE TABLE IF NOT EXISTS `dd_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `addr` varchar(200) NOT NULL,
  `addr_id` int(11) NOT NULL,
  `msg` varchar(256) NOT NULL,
  `total` float(10,2) NOT NULL,
  `points_total` int(11) NOT NULL,
  `points` float(10,2) NOT NULL,
  `money` float(10,2) NOT NULL,
  `wxpay` float(10,2) NOT NULL,
  `paid` tinyint(4) NOT NULL,
  `express` varchar(20) NOT NULL,
  `express_no` varchar(20) NOT NULL,
  `create_time` int(11) NOT NULL,
  `pay_time` int(11) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `confirm_time` int(11) NOT NULL,
  `separate` tinyint(4) NOT NULL,
  `status` tinyint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `dd_order`
--

INSERT INTO `dd_order` (`id`, `sn`, `user_id`, `name`, `mobile`, `addr`, `addr_id`, `msg`, `total`, `points_total`, `points`, `money`, `wxpay`, `paid`, `express`, `express_no`, `create_time`, `pay_time`, `delivery_time`, `confirm_time`, `separate`, `status`) VALUES
(1, '1511282051100019177', 10001, '龙哥', '13800138000', '安徽省 六安市 裕安区江南大道57号金岸小区2栋5喽502室', 1, '', 121.00, 121, 0.00, 0.00, 0.00, 0, '', '', 1448715106, 0, 0, 0, 0, 1),
(2, '1511300133100181957', 10018, '约块', '13888888888', '山西省 朔州市 右玉县见见你吧比较接近', 2, '', 1045.00, 1045, 0.00, 0.00, 0.00, 0, '', '', 1448818432, 0, 0, 0, 0, 1),
(3, '1511302019100011295', 10001, '龙哥', '13800138000', '安徽省 六安市 裕安区江南大道57号金岸小区2栋5喽502室', 1, '', 1045.00, 1045, 0.00, 0.00, 0.00, 0, '', '', 1448885941, 0, 0, 0, 0, 1),
(4, '1512031542100245413', 10024, '刘先生', '185715726817', '北京市 朝阳区东三环南路906', 3, '', 227.80, 229, 0.00, 0.00, 0.00, 0, '', '', 1449128549, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `dd_order_product`
--

CREATE TABLE IF NOT EXISTS `dd_order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `nums` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `pic` varchar(256) NOT NULL,
  `attr` varchar(200) DEFAULT NULL,
  `price` float(10,2) NOT NULL,
  `market_price` float(10,2) NOT NULL,
  `separate_money` float NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `dd_order_product`
--

INSERT INTO `dd_order_product` (`id`, `user_id`, `order_id`, `product_id`, `nums`, `title`, `pic`, `attr`, `price`, `market_price`, `separate_money`, `points`) VALUES
(1, 10004, 0, 1, 5, 'Polo女袜子秋冬款正品棉袜子女中筒休闲袜糖果色袜秋冬女', './Public/upload/images/1511/19/182911438762008651.jpg', NULL, 121.00, 123.00, 0, 121),
(2, 10004, 0, 1, 1, 'Polo女袜子秋冬款正品棉袜子女中筒休闲袜糖果色袜秋冬女', './Public/upload/images/1511/19/182911438762008651.jpg', NULL, 121.00, 123.00, 0, 121),
(3, 10001, 1, 2, 1, '', '', '官方标配,黑色', 0.00, 0.00, 0, 0),
(4, 10001, 1, 1, 1, 'Polo女袜子秋冬款正品棉袜子女中筒休闲袜糖果色袜秋冬女', './Public/upload/images/1511/19/182911438762008651.jpg', NULL, 121.00, 123.00, 0, 121),
(5, 10015, 0, 3, 1, '攀升兄弟AMD 870K四核独显台式电脑', './Public/upload/images/1511/19/183804328865007268.jpg', NULL, 1045.00, 12345.00, 0, 1045),
(6, 10018, 2, 3, 1, '攀升兄弟AMD 870K四核独显台式电脑', './Public/upload/images/1511/19/183804328865007268.jpg', NULL, 1045.00, 12345.00, 0, 1045),
(7, 10001, 3, 3, 1, '攀升兄弟AMD 870K四核独显台式电脑', './Public/upload/images/1511/19/183804328865007268.jpg', NULL, 1045.00, 12345.00, 0, 1045),
(8, 10024, 4, 2, 6, '阿巴町儿童智能手表电话手机学生小孩GPS定位防丢插卡打电话通话', './Public/upload/images/1511/19/183441370876009442.jpg', '增值套餐,红色', 17.80, 178.00, 0, 18),
(9, 10024, 4, 1, 1, 'Polo女袜子秋冬款正品棉袜子女中筒休闲袜糖果色袜秋冬女', './Public/upload/images/1511/19/182911438762008651.jpg', NULL, 121.00, 123.00, 0, 121);

-- --------------------------------------------------------

--
-- 表的结构 `dd_pay_log`
--

CREATE TABLE IF NOT EXISTS `dd_pay_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `return_code` varchar(10) NOT NULL,
  `resault_code` varchar(10) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `bank_type` varchar(20) NOT NULL,
  `total_fee` float(10,2) NOT NULL,
  `cash_fee` float(10,2) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `out_trade_no` varchar(100) NOT NULL,
  `attach` text NOT NULL,
  `time_end` varchar(20) NOT NULL,
  `log_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `dd_product`
--

CREATE TABLE IF NOT EXISTS `dd_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `pic` varchar(256) NOT NULL,
  `market_price` float(10,2) NOT NULL,
  `price` float(10,2) NOT NULL,
  `separate_money` float(10,2) NOT NULL,
  `points` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `body` text NOT NULL,
  `attr` varchar(200) DEFAULT NULL,
  `attr_values` text NOT NULL,
  `attr_open` tinyint(4) NOT NULL,
  `sold` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `dd_product`
--

INSERT INTO `dd_product` (`id`, `title`, `cate_id`, `pic`, `market_price`, `price`, `separate_money`, `points`, `stock`, `body`, `attr`, `attr_values`, `attr_open`, `sold`) VALUES
(1, 'Polo女袜子秋冬款正品棉袜子女中筒休闲袜糖果色袜秋冬女', 1, './Public/upload/images/1511/19/182911438762008651.jpg', 123.00, 121.00, 0.00, 121, 95, '<p>6双礼盒装 糖果色</p><p></p><section id="s-desc"><p><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1779071378/T2kVY2XeNbXXXXXXXX_!!1779071378.jpg"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1779071378/T2_gBcXulaXXXXXXXX_!!1779071378.jpg"/></p><p>&nbsp;</p><p>&nbsp;</p><p>品名：POLO女装休闲袜</p><p>尺码：22-24CM （36-39码）</p><p>货号：1206</p><p>成份：棉75.4%&nbsp; 聚酯纤维22.5%&nbsp; 氨纶2.1%</p><p>包装：6双礼盒装/6个颜色</p><p>袜子是中等厚度，建议秋冬穿</p><p><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/1779071378/TB2CzBadVXXXXatXpXXXXXXXXXX_!!1779071378.jpg"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1779071378/TB2XQ0adVXXXXanXpXXXXXXXXXX_!!1779071378.jpg"/></p><p><br/></p><p>****************************</p><p></p><p>品名：POLO女装休闲袜</p><p>尺码：22-24CM （36-39码）</p><p>货号：1207</p><p>成份：棉75.4%&nbsp; 聚酯纤维22.5%&nbsp; 氨纶2.1%</p><p>包装：6双礼盒装/6个颜色</p><p>袜子是中等厚度，建议秋冬穿</p><img src="https://img.alicdn.com/imgextra/i3/1779071378/TB24UBadVXXXXajXpXXXXXXXXXX_!!1779071378.jpg" align="absmiddle"/><img src="https://img.alicdn.com/imgextra/i4/1779071378/TB2TttmdVXXXXbrXXXXXXXXXXXX_!!1779071378.jpg" align="absmiddle"/><p><br/></p><p><br/></p><p>**</p></section><p></p>', '', 'N;', 0, 2),
(2, '阿巴町儿童智能手表电话手机学生小孩GPS定位防丢插卡打电话通话', 2, './Public/upload/images/1511/19/183441370876009442.jpg', 178.00, 17.80, 0.00, 18, 222, '<p style="margin-top: 1.12em; margin-bottom: 1.12em; padding: 0px; line-height: 1.4; color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);"><a href="http://detail.ju.taobao.com/home.htm?spm=a220o.1000855.1998059529.1.2ED2h1&item_id=521251147408&scene=taobao_shop" target="_blank" style="margin: 0px; padding: 0px; text-decoration: none; color: rgb(51, 85, 170); outline: 0px;"><img alt="" src="https://gdp.alicdn.com/imgextra/i4/2344216282/TB2F33ghXXXXXavXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/></a><a href="http://detail.ju.taobao.com/home.htm?spm=a220o.1000855.1998059529.1.2ED2h1&item_id=521251147408&scene=taobao_shop" target="_blank" style="margin: 0px; padding: 0px; text-decoration: none; color: rgb(51, 85, 170); outline: 0px;"><img alt="" src="https://gdp.alicdn.com/imgextra/i2/2344216282/TB2vkgjhXXXXXXHXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img alt="" src="https://gdp.alicdn.com/imgextra/i3/2344216282/TB2al7bhXXXXXbiXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/></a></p><p style="margin-top: 1.12em; margin-bottom: 1.12em; padding: 0px; line-height: 1.4; color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);"><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/2344216282/TB2x.IXhXXXXXblXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/2344216282/TB2rDn4fVXXXXawXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/2344216282/TB2lCHNfVXXXXagXpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/2344216282/TB2lyY3fVXXXXa1XXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/2344216282/TB2rgBygXXXXXX.XpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/2344216282/TB2BbtEgXXXXXXaXpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/2344216282/TB25pdEgXXXXXcZXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/2344216282/TB2GqRRgXXXXXabXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/2344216282/TB2mElvgXXXXXaOXpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/2344216282/TB2TJNvgXXXXXaRXpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/2344216282/TB2ZsNvgXXXXXaMXpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/2344216282/TB2DItOgXXXXXaKXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/2344216282/TB2UVVQgXXXXXasXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/2344216282/TB2VsBBgXXXXXXCXpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/2344216282/TB2FwxzgXXXXXXSXpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/2344216282/TB29OBwgXXXXXaGXpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/2344216282/TB2DgdBgXXXXXXbXpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/2344216282/TB2uQhDgXXXXXc7XXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/2344216282/TB2Ns0ogXXXXXX_XpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/2344216282/TB2ryltgXXXXXbiXpXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/2344216282/TB2kPRFgXXXXXceXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/2344216282/TB28DNLgXXXXXbaXXXXXXXXXXXX_!!2344216282.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/></p>', '套餐,颜色', 'a:2:{i:0;a:4:{i:0;s:12:"增值套餐";i:1;s:12:"官方标配";i:2;s:12:"官方标配";i:3;s:12:"官方标配";}i:1;a:4:{i:0;s:6:"红色";i:1;s:6:"黑色";i:2;s:6:"红色";i:3;s:6:"白色";}}', 1, 7),
(3, '攀升兄弟AMD 870K四核独显台式电脑', 2, './Public/upload/images/1511/19/183804328865007268.jpg', 12345.00, 1045.00, 0.00, 1045, 453, '<p class="attr-list-hd tm-clear" style="margin-top: 0px; margin-bottom: 0px; padding: 5px 20px; line-height: 22px; color: rgb(153, 153, 153); font-family: tahoma, arial, 微软雅黑, sans-serif; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);"><span style="margin: 0px; padding: 0px; font-weight: 700; float: left;">产品参数：</span></p><ul id="J_AttrUL" style="list-style-type: none;" class=" list-paddingleft-2"><li><p>80 PLUS认证:&nbsp;不支持</p></li><li><p>CPU主频:&nbsp;3.0GHz及以上</p></li><li><p>CPU类型:&nbsp;AMD-速龙</p></li><li><p>主板品牌:&nbsp;Asus/华硕</p></li><li><p>主板结构:&nbsp;M-ATX</p></li><li><p>内存品牌:&nbsp;Apacer/宇瞻</p></li><li><p>内存类型:&nbsp;DDR3</p></li><li><p>内存频率:&nbsp;1600MHz</p></li><li><p>办公用途:&nbsp;美工电脑</p></li><li><p>包装体积:&nbsp;15</p></li><li><p>品牌:&nbsp;AMD</p></li><li><p>声卡品牌:&nbsp;Asus/华硕</p></li><li><p>声卡接口类型:&nbsp;其他</p></li><li><p>平台类型:&nbsp;AMD FM2＋</p></li><li><p>散热方式:&nbsp;风冷</p></li><li><p>散热设备品牌:&nbsp;AMD</p></li><li><p>是否智能控温:&nbsp;是</p></li><li><p>显卡品牌:&nbsp;XFX/讯景</p></li><li><p>显存位宽:&nbsp;128bit</p></li><li><p>显存类型:&nbsp;GDDR5</p></li><li><p>最大内存容量:&nbsp;16GB</p></li><li><p>机箱品牌:&nbsp;游戏悍将</p></li><li><p>机箱类型:&nbsp;中塔</p></li><li><p>机箱结构:&nbsp;ATX</p></li><li><p>核心数:&nbsp;四核心</p></li><li><p>毛重:&nbsp;10</p></li><li><p>电源品牌:&nbsp;Sama/先马</p></li><li><p>硬盘类型:&nbsp;固态硬盘</p></li><li><p>箱体材质:&nbsp;钢板</p></li><li><p>配置类型:&nbsp;经济实惠型</p></li><li><p>适用品牌:&nbsp;AMD</p></li><li><p>兼容机AMD型号:&nbsp;其他/other</p></li><li><p>芯片组类型:&nbsp;AMD A88</p></li><li><p>内存容量:&nbsp;8GB</p></li><li><p>显卡类型:&nbsp;独立显卡</p></li><li><p>独立显卡型号:&nbsp;其他/other</p></li><li><p>显存容量:&nbsp;2GB</p></li><li><p>硬盘容量:&nbsp;其他/other</p></li><li><p>光驱类型:&nbsp;无光驱</p></li><li><p>功率:&nbsp;300W</p></li><li><p>成色:&nbsp;全新</p></li><li><p>同城服务:&nbsp;同城物流送货上门</p></li><li><p>芯片类型:&nbsp;R7 240</p></li><li><p>显示器尺寸:&nbsp;不含显示器</p></li></ul><p><img src="https://img.alicdn.com/imgextra/i2/1652528654/TB2AvNYhpXXXXXjXXXXXXXXXXXX_!!1652528654.gif" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; line-height: 21px; white-space: normal; background-color: rgb(255, 255, 255);"/><br style="margin: 0px; padding: 0px; color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; line-height: 21px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://img.alicdn.com/imgextra/i1/1652528654/TB2ShBThpXXXXaXXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; line-height: 21px; white-space: normal; background-color: rgb(255, 255, 255);"/><br style="margin: 0px; padding: 0px; color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; line-height: 21px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://img.alicdn.com/imgextra/i3/1652528654/TB27J8thpXXXXbCXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; line-height: 21px; white-space: normal; background-color: rgb(255, 255, 255);"/><span style="color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; line-height: 21px; background-color: rgb(255, 255, 255);"></span></p><p style="margin-top: 1.12em; margin-bottom: 1.12em; padding: 0px; line-height: 1.4; color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);"><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1652528654/TB2uHFshpXXXXcbXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB21Hq9gVXXXXaMXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1652528654/TB2sW56gVXXXXaMXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1652528654/TB2XzSTgVXXXXXmXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><br style="margin: 0px; padding: 0px;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB2gZQffFXXXXXAXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/></p><table cellpadding="0" cellspacing="0" height="451" width="790" style="width: 591px;"><tbody style="margin: 0px; padding: 0px;"><tr style="margin: 0px; padding: 0px;"><td style="margin: 0px; padding: 0px; border-color: rgb(0, 0, 0);"><a href="https://detail.tmall.com/item.htm?spm=a1z10.15-b.w4011-11348944498.109.PZqkNq&id=43789507457&rn=e671ad0681a103f4616e868c383360b7&abbucket=1" target="_blank" style="margin: 0px; padding: 0px; text-decoration: none; color: rgb(51, 85, 170); outline: 0px;"><img alt="" height="451" src="https://img.alicdn.com/imgextra/i1/1652528654/TB26PnOfFXXXXb8XpXXXXXXXXXX_!!1652528654.jpg" width="190" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top;"/></a></td><td style="margin: 0px; padding: 0px; border-color: rgb(0, 0, 0);"><a href="https://detail.tmall.com/item.htm?spm=a1z10.15-b.w4011-11348944498.127.PZqkNq&id=41385685661&rn=e671ad0681a103f4616e868c383360b7&abbucket=1" target="_blank" style="margin: 0px; padding: 0px; text-decoration: none; color: rgb(51, 85, 170); outline: 0px;"><img alt="" height="451" src="https://img.alicdn.com/imgextra/i1/1652528654/TB22jMdfFXXXXadXXXXXXXXXXXX_!!1652528654.jpg" width="212" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top;"/></a></td><td style="margin: 0px; padding: 0px; border-color: rgb(0, 0, 0);"><a href="https://detail.tmall.com/item.htm?spm=a220o.1000855.1998025129.1.Szlj4c&id=37637286931&abbucket=_AB-M32_B12&rn=e671ad0681a103f4616e868c383360b7&acm=03054.1003.1.430707&aldid=zeCgx5Pf&abtest=_AB-LR32-PV32_2044&scm=1003.1.03054.13_37637286931_430707&pos=1" target="_blank" style="margin: 0px; padding: 0px; text-decoration: none; color: rgb(51, 85, 170); outline: 0px;"><img alt="" height="451" src="https://img.alicdn.com/imgextra/i3/1652528654/TB2ErL_fFXXXXbKXXXXXXXXXXXX_!!1652528654.jpg" width="201" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top;"/></a></td><td style="margin: 0px; padding: 0px; border-color: rgb(0, 0, 0);"><a href="https://detail.tmall.com/item.htm?spm=a1z10.15-b.w4011-11348944498.118.PZqkNq&id=43219900108&rn=e671ad0681a103f4616e868c383360b7&abbucket=1" target="_blank" style="margin: 0px; padding: 0px; text-decoration: none; color: rgb(51, 85, 170); outline: 0px;"><img alt="" height="451" src="https://img.alicdn.com/imgextra/i1/1652528654/TB2O4.gfFXXXXXCXXXXXXXXXXXX_!!1652528654.jpg" width="187" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top;"/></a></td></tr></tbody></table><p style="margin-top: 1.12em; margin-bottom: 1.12em; padding: 0px; line-height: 1.4; color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);">&nbsp;</p><p style="margin-top: 1.12em; margin-bottom: 1.12em; padding: 0px; line-height: 1.4; color: rgb(64, 64, 64); font-family: tahoma, arial, 宋体, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);"><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1652528654/TB2UhohgVXXXXaYXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/1652528654/TB2JzTLfFXXXXb8XpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1652528654/TB2bvv0fFXXXXXDXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/1652528654/TB2zMqUgVXXXXXkXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1652528654/TB2H0HOfFXXXXcaXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/1652528654/TB2FvkffFXXXXXPXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1652528654/TB2LOwefFXXXXXWXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/1652528654/TB2eoT4fFXXXXcYXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1652528654/TB2POQefFXXXXX8XXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1652528654/TB2MgIhfFXXXXXoXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/1652528654/TB2WbPLfFXXXXcvXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB2ihf8fFXXXXb1XXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB23Nb6fFXXXXcnXXXXXXXXXXXX_!!1652528654.gif" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img src="https://img.alicdn.com/imgextra/i2/1652528654/TB2kS8ShXXXXXaXXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><br style="margin: 0px; padding: 0px;"/><img src="https://img.alicdn.com/imgextra/i3/1652528654/TB2JlK_gVXXXXauXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><br style="margin: 0px; padding: 0px;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB2K2LUfFXXXXaiXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1652528654/TB2X3vSfFXXXXaSXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB223vPfFXXXXa9XpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB2l96SfFXXXXaTXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/1652528654/TB2o9bIfFXXXXXbXFXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1652528654/TB23SPTfFXXXXaFXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/1652528654/TB25sPTfFXXXXaTXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1652528654/TB20.YRfFXXXXbXXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB2XpT2fFXXXXXgXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB2yov.fFXXXXa8XXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB27IWbgFXXXXb3XpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1652528654/TB2lqD8fFXXXXbWXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB2r5kcfFXXXXapXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/1652528654/TB21rf.fFXXXXblXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1652528654/TB29vT7fFXXXXccXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB2qAuKgVXXXXazXpXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i2/1652528654/TB26i3KgVXXXXX3XXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1652528654/TB2W5EffFXXXXXxXXXXXXXXXXXX_!!1652528654.jpg" style="margin: 0px; padding: 0px; border: 0px; vertical-align: top; float: none;"/></p><p><br/></p>', '', 'N;', 0, 2);

-- --------------------------------------------------------

--
-- 表的结构 `dd_product_attr`
--

CREATE TABLE IF NOT EXISTS `dd_product_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `attr` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `stock` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `dd_product_attr`
--

INSERT INTO `dd_product_attr` (`id`, `product_id`, `attr`, `price`, `stock`, `code`, `create_time`) VALUES
(5, 2, '增值套餐,红色', 17.8, 50, '', 1448246331),
(8, 2, '官方标配 ,红色', 17.8, 45, '', 1448246331),
(7, 2, '官方标配,黑色', 17.8, 51, '', 1448246331),
(9, 2, ' 官方标配,白色', 17.8, 56, '', 1448246331);

-- --------------------------------------------------------

--
-- 表的结构 `dd_product_cate`
--

CREATE TABLE IF NOT EXISTS `dd_product_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `pic` varchar(256) NOT NULL COMMENT '分类图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `dd_product_cate`
--

INSERT INTO `dd_product_cate` (`id`, `name`, `pid`, `sort`, `pic`) VALUES
(1, '服装鞋帽', 0, 0, ''),
(2, '3C数码', 0, 0, ''),
(3, '特产食品', 0, 0, ''),
(4, '其他商品', 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `dd_reward`
--

CREATE TABLE IF NOT EXISTS `dd_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL COMMENT '等级',
  `money` float(10,2) NOT NULL COMMENT '单份金额',
  `nums` int(11) NOT NULL COMMENT '发放数量',
  `total` float(10,2) NOT NULL COMMENT '发放总额',
  `create_time` int(11) NOT NULL COMMENT '发放时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='绩效发放记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `dd_selfmenu`
--

CREATE TABLE IF NOT EXISTS `dd_selfmenu` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `extra` varchar(256) NOT NULL,
  `type` varchar(50) NOT NULL,
  `pid` tinyint(4) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `dd_selfmenu`
--

INSERT INTO `dd_selfmenu` (`id`, `name`, `extra`, `type`, `pid`, `sort`) VALUES
(1, '系统演示', '', 'click', 0, 3),
(2, '成功案例', '', 'click', 0, 2),
(3, '咨询购买', '购买咨询', 'click', 0, 1),
(4, '商城首页', 'http://store.besttool.cn', 'view', 1, 0),
(5, '个人中心', 'http://store.besttool.cn/?a=ucenter', 'view', 1, 0),
(6, '收款功能', 'http://store.besttool.cn/index.php?m=Home&c=Sk&a=detail&id=1', 'view', 1, 0),
(7, '焌煌美食', 'http://mp.weixin.qq.com/s?__biz=MzA3ODM2NzM0Mg==&mid=401173281&idx=1&sn=1c23503d2531812d9fcb0f55e080d15d&scene=0#wechat_redirect', 'view', 2, 0),
(8, '七版冲生态农业', 'http://mp.weixin.qq.com/s?__biz=MzA3ODM2NzM0Mg==&mid=401173475&idx=1&sn=2eb225b6b1764447b56bef0cbb59d192&scene=0#wechat_redirect', 'view', 2, 0),
(10, '案例说明', '案例说明', 'click', 2, 0),
(11, '后台功能', '后台功能', 'click', 3, 0),
(12, '联系方式', '联系方式', 'click', 3, 0);

-- --------------------------------------------------------

--
-- 表的结构 `dd_separate_log`
--

CREATE TABLE IF NOT EXISTS `dd_separate_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_sn` varchar(20) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `money` float(10,2) NOT NULL,
  `points` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `dd_sk`
--

CREATE TABLE IF NOT EXISTS `dd_sk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `market_price` float(10,2) NOT NULL,
  `price` float(10,2) NOT NULL,
  `form_open` tinyint(4) NOT NULL,
  `form` text NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `dd_sk`
--

INSERT INTO `dd_sk` (`id`, `title`, `body`, `market_price`, `price`, `form_open`, `form`, `create_time`) VALUES
(1, '分销商城独立收款功能演示', '<p style="line-height: 1.5em;"><span style="font-size: 18px;"><strong>这个是分销商城中的独立收款功能演示，您可以灵活的应用于单品销售，收款等。值得注意的是<span style="font-size: 18px; background-color: rgb(84, 141, 212); color: rgb(255, 255, 255);">本收款功能中的订单不参与商城的分销提成</span>。您可以自由设置此处的内容。可以是文字，图片，表情，甚至是视频！</strong></span></p><p style="line-height: 1.5em;"><span style="font-size: 18px;"><strong>长按下面的二维码关注我们了解更多的功能！</strong></span></p><p style="line-height: 1.5em;"><span style="font-size: 18px;"><strong><img src="/./Public/upload/image/20151118/1447831921320027.jpg" alt="1447831921320027.jpg"/></strong></span></p>', 12.00, 10.00, 1, 'a:2:{i:0;a:2:{s:4:"name";s:6:"姓名";s:4:"tips";s:21:"请输入您的姓名";}i:1;a:2:{s:4:"name";s:6:"电话";s:4:"tips";s:27:"请输入您的联系电话";}}', 1448362739);

-- --------------------------------------------------------

--
-- 表的结构 `dd_sk_order`
--

CREATE TABLE IF NOT EXISTS `dd_sk_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sk_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `form` text NOT NULL,
  `money` float(10,2) NOT NULL,
  `paid` float(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `dd_sk_order`
--

INSERT INTO `dd_sk_order` (`id`, `sk_id`, `user_id`, `nickname`, `form`, `money`, `paid`, `status`, `create_time`) VALUES
(1, 1, 10001, '阿拉丁龙哥', 'a:2:{i:0;a:2:{s:4:"name";s:6:"姓名";s:5:"value";s:6:"测试";}i:1;a:2:{s:4:"name";s:6:"电话";s:5:"value";s:11:"13800125888";}}', 10.00, 0.00, 1, 1448369399),
(2, 1, 10004, '心剑江湖', 'a:2:{i:0;a:2:{s:4:"name";s:6:"姓名";s:5:"value";s:0:"";}i:1;a:2:{s:4:"name";s:6:"电话";s:5:"value";s:0:"";}}', 10.00, 0.00, 1, 1448369668),
(3, 1, 10008, '路人甲', 'a:2:{i:0;a:2:{s:4:"name";s:6:"姓名";s:5:"value";s:6:"侧脸";}i:1;a:2:{s:4:"name";s:6:"电话";s:5:"value";s:11:"18953532066";}}', 10.00, 0.00, 1, 1448706533);

-- --------------------------------------------------------

--
-- 表的结构 `dd_user`
--

CREATE TABLE IF NOT EXISTS `dd_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `sex` tinyint(4) NOT NULL,
  `headimg` varchar(256) NOT NULL,
  `true_name` varchar(20) NOT NULL,
  `cardno` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `birth` varchar(20) NOT NULL,
  `sub_time` int(11) NOT NULL,
  `subscribe` tinyint(4) NOT NULL,
  `default_addr` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `parent1` int(11) NOT NULL,
  `parent2` int(11) NOT NULL,
  `parent3` int(11) NOT NULL,
  `agent1` int(11) NOT NULL,
  `agent2` int(11) NOT NULL,
  `agent3` int(11) NOT NULL,
  `money` float(10,2) NOT NULL,
  `points` int(11) NOT NULL,
  `achievement` float(10,2) NOT NULL,
  `receive_total` float(10,2) NOT NULL,
  `assign_total` float(10,2) NOT NULL,
  `withdraw_total` float(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10026 ;

--
-- 转存表中的数据 `dd_user`
--

INSERT INTO `dd_user` (`id`, `openid`, `nickname`, `sex`, `headimg`, `true_name`, `cardno`, `mobile`, `birth`, `sub_time`, `subscribe`, `default_addr`, `level`, `parent1`, `parent2`, `parent3`, `agent1`, `agent2`, `agent3`, `money`, `points`, `achievement`, `receive_total`, `assign_total`, `withdraw_total`) VALUES
(10001, 'obih8t8OhKl9zFTKwNpMQStk8bbk', '阿拉丁龙哥', 1, 'http://wx.qlogo.cn/mmopen/bRZiczN0yldVcibAqoOhbNNtDPcWlOv73jd19gmqAk57WiayAgxmkcsM4a4YTjqgjvk8xKxuP8TGPmiau4nYMa9rMYRiaDGG1adT0/0', '', '', '', '', 1447930386, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10002, 'obih8t-1hcMTUew0pIGqic6JseWw', 'A-微信公众号定制', 1, 'http://wx.qlogo.cn/mmopen/23icleuWtqtPEY5IPhib6Xx4kefPxu4Uwen3xHbrIgaWeezStTLrFxcgYbMhwGKk9v5F48icwVGv6bDyvU2icEBMtuK8dmzV8diaq/0', '', '', '', '', 1447931418, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10003, 'obih8txEiCm33D0twW0Tl5jxBNDg', '时隐时现', 1, 'http://wx.qlogo.cn/mmopen/fkf2hwUK0JhO08YiagR2l9lYwxSy1AcvnR64QMEb1kaZZnEIibgc3ibVwDW503ibCf3SmKnCDh8sZjIM7k4tz9Hre49gsrEt27u0/0', '', '', '', '', 1447931505, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10004, 'obih8t6MYnUMNRJFh-Z2PfNayMVU', '心剑江湖', 1, 'http://wx.qlogo.cn/mmopen/QqXStWm2N15qmlbjQjib8EPQZNs03ZiaG376DUicic9nsejkQ16TAiapnUD87Y2YBhXrkIfE00I6ULIlSexfkeicObCetNloGiajA0f/0', '', '', '', '', 1447932161, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10005, 'obih8tyNaLENH2jh1lCIktKSPhqg', '￡CoCo', 1, 'http://wx.qlogo.cn/mmopen/fkf2hwUK0JhO08YiagR2l9jdnSLrTzcE50l38ZJxlo2gkA28rrexhFUzp00AyOO2GGcYMTV7F5cxXymbTr21Fj4ibOQQiaJjiasT/0', '', '', '', '', 1447932236, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10006, 'obih8t3gOXiQ7rtszxuiKdT0qWEs', '༄のོ࿆༘那一刻', 1, 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEKmmI6ZcVSDU8BfBv4bCx0zXibGzVDpzy3B4oQ5pMwNaC0p9uz9icicogSjWic8uYSvLEVrM7EnYeTpYw/0', '', '', '', '', 1447934411, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10007, 'obih8txG9dGHGowhJXy-S4jBuzmM', '后会无期', 2, 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLBbU6HCOKWmvfpbTGVgV3kXWhzUTzmtsZHGVV3r6Hm2poickuJibnkD24ZsQR0PpJaPolBanhsib9yzQichaAa5f4sfFtGG4GE5kWw/0', '', '', '', '', 1447934609, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10008, 'obih8t8AQYUTNwVI45QB5JeQKVhc', '路人甲', 1, 'http://wx.qlogo.cn/mmopen/fkf2hwUK0JhO08YiagR2l9oEUiaw8pbk2tbPFUGlaKR8QBQxKpYQ7nQM7P1KoDicvzKdZEeibbxCMggGr9XnEBfmG3f4N7EU6Z6e/0', '', '', '', '', 1447977828, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10009, 'obih8t8VRo0lqgPwwXiBFj6NvVuY', '李飞飞', 1, 'http://wx.qlogo.cn/mmopen/bRZiczN0yldVuLgGAv6XmqG8ibMFbCPCK5VsuE6IophlprOOtKLiaE0j6bpP33oia7cmIcAc7tSHicVnicVtD6PD3s3A/0', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10010, 'obih8t89boGGOnr5ODJia5WH4FNw', '媛媛', 0, 'http://wx.qlogo.cn/mmopen/fkf2hwUK0JjiaWQmIYxn1GTo4icVxyuRGeHuxgetdj9ZQNvknefGFOytibWV3GcSI3BKEZYhtjYwdURtE6N1GPPwcCHpibb1rYg3/0', '', '', '', '', 1448167153, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10011, 'obih8t5Uf3E-y76vOb9FOUuPz4S0', 'Gru.', 1, 'http://wx.qlogo.cn/mmopen/LIND77SSexicMTicvTqUpAprWlZfiahFrla2kVbckRMToqVFGCQHs8qkxKmmzXZUECB8ynIicuj5ruRadLcbjibnKlZmFzlia0Zt4ib/0', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10012, 'obih8t5IMhWv3q5aQF7Zbj0PuN3w', '庆莉化妆品', 1, 'http://wx.qlogo.cn/mmopen/bRZiczN0yldX77nSia9hk6vXAbdPRiaPDPcNQYMO66qBicicOFRR0bKaUHSvJHqSxhSgJddQVaIPeD3VUbEjnib4VsVQ/0', '', '', '', '', 1448434997, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10013, 'obih8t3M980DMnUYTY0v5U8CZJOY', '焦点-王少伟', 1, 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM7Tiaia6lgbcQ8xDjiaZ2FNZv4E7Sofkic30Sp0hU3wqicJrFDHXSAHqZbBqNJNWXU6WQryAPOtf4mHtPQ/0', '', '', '', '', 1448465473, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10014, 'obih8tzpWSZ6SWM5JFLiVW62NFPw', 'iYon', 1, 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLB6qOZg0twgc92WbtO7wT7ZHamztbFQUGvTtdEd9WGzoYUnfO1A1b2YIlib0UTr38YGxiav4QIw73TQ/0', '', '', '', '', 1448795155, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10015, 'obih8t-DMCtASnzJH-IMpqfXpGks', '宽容', 1, 'http://wx.qlogo.cn/mmopen/bRZiczN0yldUerOQUGoOahgLPpRWzLZWicLRJuWjjKb2TUibwkTzvJL0T2UpeunDpe0FRjEeO6czfKdHgm1QgmC9X5jNwgOcicym/0', '', '', '', '', 1448798898, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10016, 'obih8t9BfnlvAgC5w0bgUmSu1AaI', '', 0, 'http://wx.qlogo.cn/mmopen/fkf2hwUK0JiaMYmGr5UfiaicAwicr9bQD9t08DNnuMxYk6e3YofM7hgbZLxBNKtOm54icxjDDxlAXIJYoR4XFOvQ5gic9D9icRsfJicU/0', '', '', '', '', 1448799186, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10017, 'obih8t4NJmXmdbmXX70ZeuPfNVK8', '微赢科技', 1, 'http://wx.qlogo.cn/mmopen/fkf2hwUK0JhO08YiagR2l9nbCJtiapwxlw9mia0TyQLrgbBuZicf5P4a4oM4B2fvAvL7ApQceiawc3HR8eiclia5Ub9UxG4gVNVYykK/0', '', '', '', '', 1448799202, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10018, 'obih8t4KBrrrRKv5D_Zc734_cBwA', 'NIFENG', 1, 'http://wx.qlogo.cn/mmopen/bRZiczN0yldVcibAqoOhbNNmRBHWUZn8dW7cAV4MgNbjMC8n4QjzS3tlRic0pOfYQoMGgvyGzsKGqAaZ3cEIQZDBB7NeOFDmb6e/0', '', '', '', '', 1448818360, 1, 2, 0, 0, 0, 0, 1, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10019, 'obih8t6MmuXxziyizy8_8SMvPuxE', '', 1, 'http://wx.qlogo.cn/mmopen/bRZiczN0yldVcibAqoOhbNNvUwXAMoz8Btjt9dFib3edq2B0y1TpXhoxIsDEefmLKoKBwKdKgJbicPYDjrz9PYcM3gBJR0RlMf7t/0', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10020, 'obih8t0yymfG3yWQ4-6ovz4jrE7I', '啊健', 0, 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLDtib3CpuibnOKy20MVSZ5AUxEOpyCUP2OaYJLia3HC85f2icSqarUEUHcx62nS3vdMkoy9PX2EtpyvBQ/0', '', '', '', '', 1448884526, 1, 0, 0, 10018, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10021, 'obih8t-MLEM9fZvncVy4ViH9Sj2c', '小单同学', 1, 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM4CHltPOKBlgf2eZ2FGO8ib7D11aOssleRU43D9TsozNQJz149pJUNnQbwZAdgAhqxibgPSGCF5uzRGa51sXjas0WDaw03AMl34A/0', '', '', '', '', 1448885709, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10022, 'obih8t0Uj0OQNTVQXUgDOSy-zgPg', '许冠华', 2, 'http://wx.qlogo.cn/mmopen/QqXStWm2N14JZLiarN8J5xDVNlYCOLDibzHjCmoHJqiar8xYMX4uwU0DaQA9c4m37dP8Yhx4F9zBG5CmDt3c3IKCBl0MlibfOOge/0', '', '', '', '', 1448888638, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10023, 'obih8tynZrOECcRgERIAFVk6gR50', '袁纯浩', 1, 'http://wx.qlogo.cn/mmopen/fkf2hwUK0JhBiazCPmPA5wNSLjxLJWrNrmbZaQYlAxj40RTGOmrxa3iajTHnTbicETgN86DbWAwqFfx5FNhkLiaycOoscRBor5Xt/0', '', '', '', '', 1448973458, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10024, 'obih8t2ASUDGOFdE8QlUO9GRkXjQ', '银汉', 1, 'http://wx.qlogo.cn/mmopen/fkf2hwUK0JghsxjeLxaQQwwS2Y55ibWZicDTExNnGscFC6BJCO06n6G70z6llEbicLbARiaIic6OPJypLS5o71p4HUEfWwX2nK8fw/0', '', '', '', '', 1449119430, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00),
(10025, 'obih8t-B3kwog4i8i-Tt5pagA9wg', '码到成功VIP客服', 2, 'http://wx.qlogo.cn/mmopen/fkf2hwUK0JhO08YiagR2l9qXj5ghsgMgHCszjVFyLj6lqZXAFsodt4BSckFaTwkG46EfTgrEDvU16vhfuOqB8NO3kMtQUmc00/0', '', '', '', '', 1449121182, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- 表的结构 `dd_withdraw`
--

CREATE TABLE IF NOT EXISTS `dd_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `bank` text NOT NULL,
  `bank_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `audit_time` int(11) NOT NULL,
  `confirm_time` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `dd_withdraw`
--

INSERT INTO `dd_withdraw` (`id`, `user_id`, `money`, `bank`, `bank_id`, `create_time`, `audit_time`, `confirm_time`, `status`) VALUES
(1, 10001, 100, 'a:6:{s:2:"id";s:1:"1";s:7:"user_id";s:5:"10001";s:4:"bank";s:12:"工商银行";s:9:"bank_name";s:30:"吉林支行新山街储蓄所";s:6:"cardno";s:19:"6222222222222222222";s:4:"name";s:6:"龙哥";}', 1, 1448715508, 0, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
