<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="TPshop v1.1" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>首页-<?php echo ($tpshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/index.css"/>
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/TouchSlide.1.1.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.json.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/touchslider.dev.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
<script src="/Public/js/global.js"></script>
<script src="/Public/js/mobile_common.js"></script>

</head>
<style>
.box {
    height: 45px;
    background: #000;
    overflow: hidden;
    /*margin-top: 240px;*/
    font-size: 19px;
    /*   width: 50%;*/
    /*overflow: hidden;*/
}

.t_news {
    height: 30px;
    color: red;
    padding-left: 10px;
    margin: 10px 0;
    overflow: hidden;
    position: relative;
}

.t_news b {
    line-height: 30px;
    font-weight: bold;
    display: inline-block;
}

.news_li,
.swap {
    line-height: 30px;
    display: inline-block;
    position: absolute;
    top: 0;
    left: 30%;
    /*text-align: center;*/
}

.news_li a,
.swap a {
    color: #fff;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 200px;
    display: block;
}

.swap {
    top: 29px;
}
</style>
<body>
<div id="page" class="showpage">
<div>
<header id="header"> 
<a href="<?php echo U('Goods/categoryList');?>" class="top_bt"></a><a href="<?php echo U('Cart/cart');?>" class='user_btn'></a>
<span href="javascript:void(0)" class="logo"><?php echo ($tpshop_config['shop_info_store_name']); ?></span> 
</header>

<div id="scrollimg" class="scrollimg">
  <div class="bd">
	 <ul>
	 	<?php $pid =2;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->getField("position_id,position_name,ad_width,ad_height");$result = D("ad")->where("pid=$pid  and enabled = 1 and start_time < 1502352000 and end_time > 1502352000 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("5")->select(); if(!in_array($pid,array_keys($ad_position)) && $pid) { M("ad_position")->add(array( "position_id"=>$pid, "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ", "is_open"=>1, "position_desc"=>CONTROLLER_NAME."页面", )); delFile(RUNTIME_PATH); } $c = 5- count($result); if($c > 0 && $_GET[edit_ad]) { for($i = 0; $i < $c; $i++) { $result[] = array( "ad_code" => "/Public/images/not_adv.jpg", "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid", "title" =>"暂无广告图片", "not_adv" => 1, "target" => 0, ); } } foreach($result as $key=>$v): $v[position] = $ad_position[$v[pid]]; if($_GET[edit_ad] && $v[not_adv] == 0 ) { $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]"; $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name]; $v[target] = 0; } ?><li><a href="<?php echo ($v["ad_link"]); ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> ><img src="<?php echo ($v[ad_code]); ?>" title="<?php echo ($v[title]); ?>"width="100%" style="<?php echo ($v[style]); ?>"/></a></li><?php endforeach; ?>                        
     </ul>
  </div>
  <div class="hd">
	<ul></ul>
  </div>
</div>
<div class="box">
  <div class="t_news">
      <b>最新消息</b>
      <ul class="news_li">
          <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?><li>
                  <?php if($lists["link"] == ''): ?><a href="/index.php/Mobile/Index/article/article_id/<?php echo ($lists["article_id"]); ?>"><?php echo ($lists["title"]); ?></a>
                      <?php else: ?>
                      <a href="<?php echo ($lists["link"]); ?>"><?php echo ($lists["title"]); ?></a><?php endif; ?>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
      <ul class="swap"></ul>
  </div>
</div>
<script type="text/javascript">
// 字体轮播
function b() {
    t = parseInt(x.css('top'));
    y.css('top', '29px');
    x.animate({
        top: t - 29 + 'px'
    }, 'slow'); //19为每个li的高度
    if (Math.abs(t) == h - 29) { //19为每个li的高度
        y.animate({
            top: '0px'
        }, 'slow');
        z = x;
        x = y;
        y = z;
    }
    setTimeout(b, 3000); //滚动间隔时间 现在是3秒
}
$(document).ready(function() {
    $('.swap').html($('.news_li').html());
    x = $('.news_li');
    y = $('.swap');
    h = $('.news_li li').length * 29; //19为每个li的高度
    setTimeout(b, 3000); //滚动间隔时间 现在是3秒

})
</script>
<script type="text/javascript">
	TouchSlide({ 
		slideCell:"#scrollimg",
		titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
		mainCell:".bd ul", 
		effect:"leftLoop", 
		autoPage:true,//自动分页
		autoPlay:true //自动播放
	});
</script> 
<div id="fake-search" class="index_search">
  <div class="index_search_mid">
  <span><img src="/Template/mobile/new/Static/images/xin/icosousuo.png"></span>
    <input  type="text" id="search_text" class="search_text" value="请输入您所搜索的商品"/>
  </div>
</div>
<div class="entry-list clearfix">
	<nav>
		<ul>
			<li>
				<a href="<?php echo U('Goods/categoryList');?>">
					<img alt="全部分类" src="/Template/mobile/new/Static/images/1440437165699930301.png" />
					<span>全部分类</span>
				</a>
			</li>		 
			<li>
				<a href="<?php echo U('Activity/group_list');?>">
					<img alt="我的订单" src="/Template/mobile/new/Static/images/1440439318451279676.png" />
					<span>团购</span>
				</a>
			</li>
			<li>
				<a href="<?php echo U('Cart/cart');?>">
					<img alt="购物车" src="/Template/mobile/new/Static/images/1440439353048484531.png" />
					<span>购物车</span>
				</a>
			</li>
			<li>
				<a href="<?php echo U('User/index');?>">
					<img alt="个人中心" src="/Template/mobile/new/Static/images/1440439367001464442.png" />
					<span>个人中心</span>
				</a>
			</li>
		</ul>
	</nav>
</div>
 
<div class="floor_images">
  <div class="floor_body1">
    <h2>
      <em></em>会员专区
          <div class="geng"><a href="<?php echo U('Goods/search',array('q'=>'会员'));?>">更多</a><span></span></div>
    </h2>
  </div>
	  <dl>
	    <dt>
	      <?php $pid =300;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->getField("position_id,position_name,ad_width,ad_height");$result = D("ad")->where("pid=$pid  and enabled = 1 and start_time < 1502352000 and end_time > 1502352000 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select(); if(!in_array($pid,array_keys($ad_position)) && $pid) { M("ad_position")->add(array( "position_id"=>$pid, "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ", "is_open"=>1, "position_desc"=>CONTROLLER_NAME."页面", )); delFile(RUNTIME_PATH); } $c = 1- count($result); if($c > 0 && $_GET[edit_ad]) { for($i = 0; $i < $c; $i++) { $result[] = array( "ad_code" => "/Public/images/not_adv.jpg", "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid", "title" =>"暂无广告图片", "not_adv" => 1, "target" => 0, ); } } foreach($result as $key=>$v): $v[position] = $ad_position[$v[pid]]; if($_GET[edit_ad] && $v[not_adv] == 0 ) { $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]"; $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name]; $v[target] = 0; } ?><a href="<?php echo ($v["ad_link"]); ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> >
                <img src="<?php echo ($v[ad_code]); ?>" title="<?php echo ($v[title]); ?>" style="<?php echo ($v[style]); ?>" border="0">
            </a><?php endforeach; ?>              
        </dt>    
        <dd> 
            <span class="Edge">
		      <?php $pid =306;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->getField("position_id,position_name,ad_width,ad_height");$result = D("ad")->where("pid=$pid  and enabled = 1 and start_time < 1502352000 and end_time > 1502352000 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select(); if(!in_array($pid,array_keys($ad_position)) && $pid) { M("ad_position")->add(array( "position_id"=>$pid, "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ", "is_open"=>1, "position_desc"=>CONTROLLER_NAME."页面", )); delFile(RUNTIME_PATH); } $c = 1- count($result); if($c > 0 && $_GET[edit_ad]) { for($i = 0; $i < $c; $i++) { $result[] = array( "ad_code" => "/Public/images/not_adv.jpg", "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid", "title" =>"暂无广告图片", "not_adv" => 1, "target" => 0, ); } } foreach($result as $key=>$v): $v[position] = $ad_position[$v[pid]]; if($_GET[edit_ad] && $v[not_adv] == 0 ) { $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]"; $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name]; $v[target] = 0; } ?><a href="<?php echo ($v["ad_link"]); ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> >
                    <img src="<?php echo ($v[ad_code]); ?>" title="<?php echo ($v[title]); ?>" style="<?php echo ($v[style]); ?>" border="0">
                </a><?php endforeach; ?>
            </span> 
            <span>
		      <?php $pid =302;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->getField("position_id,position_name,ad_width,ad_height");$result = D("ad")->where("pid=$pid  and enabled = 1 and start_time < 1502352000 and end_time > 1502352000 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select(); if(!in_array($pid,array_keys($ad_position)) && $pid) { M("ad_position")->add(array( "position_id"=>$pid, "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ", "is_open"=>1, "position_desc"=>CONTROLLER_NAME."页面", )); delFile(RUNTIME_PATH); } $c = 1- count($result); if($c > 0 && $_GET[edit_ad]) { for($i = 0; $i < $c; $i++) { $result[] = array( "ad_code" => "/Public/images/not_adv.jpg", "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid", "title" =>"暂无广告图片", "not_adv" => 1, "target" => 0, ); } } foreach($result as $key=>$v): $v[position] = $ad_position[$v[pid]]; if($_GET[edit_ad] && $v[not_adv] == 0 ) { $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]"; $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name]; $v[target] = 0; } ?><a href="<?php echo ($v["ad_link"]); ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> >
                    <img src="<?php echo ($v[ad_code]); ?>" title="<?php echo ($v[title]); ?>" style="<?php echo ($v[style]); ?>" border="0">
                </a><?php endforeach; ?>           
            </span> 
        </dd>
	  </dl>
	  <!-- <ul>
	    <li class="brom">
		      <?php $pid =306;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->getField("position_id,position_name,ad_width,ad_height");$result = D("ad")->where("pid=$pid  and enabled = 1 and start_time < 1502352000 and end_time > 1502352000 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select(); if(!in_array($pid,array_keys($ad_position)) && $pid) { M("ad_position")->add(array( "position_id"=>$pid, "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ", "is_open"=>1, "position_desc"=>CONTROLLER_NAME."页面", )); delFile(RUNTIME_PATH); } $c = 1- count($result); if($c > 0 && $_GET[edit_ad]) { for($i = 0; $i < $c; $i++) { $result[] = array( "ad_code" => "/Public/images/not_adv.jpg", "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid", "title" =>"暂无广告图片", "not_adv" => 1, "target" => 0, ); } } foreach($result as $key=>$v): $v[position] = $ad_position[$v[pid]]; if($_GET[edit_ad] && $v[not_adv] == 0 ) { $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]"; $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name]; $v[target] = 0; } ?><a href="<?php echo ($v["ad_link"]); ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> >
                    <img src="<?php echo ($v[ad_code]); ?>" title="<?php echo ($v[title]); ?>" style="<?php echo ($v[style]); ?>" border="0">
                </a><?php endforeach; ?>        
        </li>
	    <li>
		      <?php $pid =302;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->getField("position_id,position_name,ad_width,ad_height");$result = D("ad")->where("pid=$pid  and enabled = 1 and start_time < 1502352000 and end_time > 1502352000 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select(); if(!in_array($pid,array_keys($ad_position)) && $pid) { M("ad_position")->add(array( "position_id"=>$pid, "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ", "is_open"=>1, "position_desc"=>CONTROLLER_NAME."页面", )); delFile(RUNTIME_PATH); } $c = 1- count($result); if($c > 0 && $_GET[edit_ad]) { for($i = 0; $i < $c; $i++) { $result[] = array( "ad_code" => "/Public/images/not_adv.jpg", "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid", "title" =>"暂无广告图片", "not_adv" => 1, "target" => 0, ); } } foreach($result as $key=>$v): $v[position] = $ad_position[$v[pid]]; if($_GET[edit_ad] && $v[not_adv] == 0 ) { $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]"; $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name]; $v[target] = 0; } ?><a href="<?php echo ($v["ad_link"]); ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> >
                    <img src="<?php echo ($v[ad_code]); ?>" title="<?php echo ($v[title]); ?>" style="<?php echo ($v[style]); ?>" border="0">
                </a><?php endforeach; ?>        
        </li>
	  </ul> -->
</div>
<script>
/* 
var Tday = new Array();
var daysms = 24 * 60 * 60 * 1000
var hoursms = 60 * 60 * 1000
var Secondms = 60 * 1000
var microsecond = 1000
var DifferHour = -1
var DifferMinute = -1
var DifferSecond = -1
function clock(key)
{
   var time = new Date()
   var hour = time.getHours()
   var minute = time.getMinutes()
   var second = time.getSeconds()
   var timevalue = ""+((hour > 12) ? hour-12:hour)
   timevalue +=((minute < 10) ? ":0":":")+minute
   timevalue +=((second < 10) ? ":0":":")+second
   timevalue +=((hour >12 ) ? " PM":" AM")
   var convertHour = DifferHour
   var convertMinute = DifferMinute
   var convertSecond = DifferSecond
   var Diffms = Tday[key].getTime() - time.getTime()
   DifferHour = Math.floor(Diffms / daysms)
   Diffms -= DifferHour * daysms
   DifferMinute = Math.floor(Diffms / hoursms)
   Diffms -= DifferMinute * hoursms
   DifferSecond = Math.floor(Diffms / Secondms)
   Diffms -= DifferSecond * Secondms
   var dSecs = Math.floor(Diffms / microsecond)
  
   if(convertHour != DifferHour) a=DifferHour+":";
   if(convertMinute != DifferMinute) b=DifferMinute+":";
   if(convertSecond != DifferSecond) c=DifferSecond+"分"
     d=dSecs
     if (DifferHour>0) {a=a}
     else {a=''}
   document.getElementById("jstimerBox"+key).innerHTML = a + b + c ; //显示倒计时信息
}
*/
 
 
	// 倒计时
	function GetRTime2(){
		//var text = GetRTime('2016/02/27 17:34:00');
	   <?php
 $md5_key = md5("select * from __PREFIX__goods as g inner join __PREFIX__flash_sale as f on g.goods_id = f.goods_id limit 3"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("select * from __PREFIX__goods as g inner join __PREFIX__flash_sale as f on g.goods_id = f.goods_id limit 3"); S("sql_".$md5_key,$sql_result_v,31104000); } foreach($sql_result_v as $k=>$v): ?>var text<?php echo ($v[goods_id]); ?> = GetRTime('<?php echo (date("Y/m/d H:i:s",$v["end_time"])); ?>');
		
		if (typeof(text<?php echo ($v[goods_id]); ?>) == "undefined") 
				$("#surplus_text<?php echo ($v[goods_id]); ?>").text('活动已结束');
		else   		
				$("#surplus_text<?php echo ($v[goods_id]); ?>").text(text<?php echo ($v[goods_id]); ?>);<?php endforeach; ?>
	}
	setInterval(GetRTime2,1000);
</script>
<!-- <section class="index_floor_lou">
	  <div class="floor_body">
	    <h2>
	      <em></em>促销商品
            <div class="geng"><a href="<?php echo U('Goods/search',array('q'=>'促销'));?>">更多</a><span></span></div>
	    </h2>
	    <div id="scroll_promotion">
	        <ul>
	         <?php
 $md5_key = md5("select * from __PREFIX__goods as g inner join __PREFIX__flash_sale as f on g.goods_id = f.goods_id limit 3"); $result_name = $sql_result_val = S("sql_".$md5_key); if(empty($sql_result_val)) { $Model = new \Think\Model(); $result_name = $sql_result_val = $Model->query("select * from __PREFIX__goods as g inner join __PREFIX__flash_sale as f on g.goods_id = f.goods_id limit 3"); S("sql_".$md5_key,$sql_result_val,31104000); } foreach($sql_result_val as $key=>$val): ?><li>
	            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" title="<?php echo ($val["goods_name"]); ?>"></a>
	            <div class="index_pro">
		            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$val[goods_id]));?>" title="<?php echo ($val["goods_name"]); ?>"> 
		              <div class="products_kuang">
		              	<div class="timerBox" id="surplus_text<?php echo ($val[goods_id]); ?>">1时 59分 59秒</div>
		                <img src="<?php echo (goods_thum_images($val["goods_id"],400,400)); ?>">
		              </div>
		              <div class="goods_name"><?php echo ($val["goods_name"]); ?></div>
		            </a>
		              <div class="price">
                      <a href="javascript:AjaxAddCart(<?php echo ($val[goods_id]); ?>,1,0);" class="btns">
		                  <img src="/Template/mobile/new/Static/images/index_flow.png">
                      </a>
		                <span class="price_pro">￥<?php echo ($val["price"]); ?>元</span>
		              </div>
				</div>
	          </li><?php endforeach; ?>
	        </ul>
	    </div>
	</div>
</section> -->
 <section class="index_floor">
  <div class="floor_body1">
    <h2><em></em>优惠卷专区
        <div class="geng"> <a href="<?php echo U('Goods/search',array('q'=>'优惠券'));?>">更多</a> <span></span></div>
    </h2>
    <div id="scroll_youhui" class="scroll_hot">
      <div class="bd">
        <ul>
        <?php $fl = '1'; ?>
         <?php
 $md5_key = md5("select * from __PREFIX__goods where offset != 0.00 order by goods_id desc limit 9"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("select * from __PREFIX__goods where offset != 0.00 order by goods_id desc limit 9"); S("sql_".$md5_key,$sql_result_v,31104000); } foreach($sql_result_v as $k=>$v): ?><li>
            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" title="<?php echo ($v["goods_name"]); ?>">
             <div class="index_pro"> 
                <div class="products_kuang">
                  <div class="timerBox" id="Coupon<?php echo ($val[goods_id]); ?>">可抵用现金<font style="color: red;"><?php echo ($v["offset"]); ?></font>元</div>
                  <img src="<?php echo (goods_thum_images($v["goods_id"],400,400)); ?>"></div>
                <div class="goods_name"><?php echo ($v["goods_name"]); ?></div>
                <div class="price">
                   <a href="javascript:AjaxAddCart(<?php echo ($v[goods_id]); ?>,1,0);" class="btns">
                      <img src="/Template/mobile/new/Static/images/index_flow.png">
                   </a>
                   <span href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" class="price_pro">￥<?php echo ($v["shop_price"]); ?>元</span>
                </div>
              </div>
            </a>
           </li>
           <?php if(($fl++%3 == 0) && ($fl < 9)): ?></ul><ul><?php endif; endforeach; ?>
           </ul>
       </div>
       <div class="hd">
          <ul></ul>
       </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    TouchSlide({ 
      slideCell:"#scroll_youhui",
      titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      effect:"leftLoop", 
      autoPage:true, //自动分页
      //switchLoad:"_src" //切换加载，真实图片路径为"_src" 
    });
  </script>
<!-- <section class="index_floor">
  <div class="floor_body1">
    <h2><em></em>精品推荐
        <div class="geng"> <a href="<?php echo U('Goods/search',array('q'=>'精品'));?>">更多</a> <span></span></div>
    </h2>
    <div id="scroll_best" class="scroll_hot">
      <div class="bd">
        <ul>
        <?php $fl = '1'; ?>
         <?php
 $md5_key = md5("select * from __PREFIX__goods where is_recommend=1 order by sort limit 9"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("select * from __PREFIX__goods where is_recommend=1 order by sort limit 9"); S("sql_".$md5_key,$sql_result_v,31104000); } foreach($sql_result_v as $k=>$v): ?><li>
            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" title="<?php echo ($v["goods_name"]); ?>">
             <div class="index_pro"> 
	              <div class="products_kuang">
	                <img src="<?php echo (goods_thum_images($v["goods_id"],400,400)); ?>"></div>
	              <div class="goods_name"><?php echo ($v["goods_name"]); ?></div>
	              <div class="price">
	                 <a href="javascript:AjaxAddCart(<?php echo ($v[goods_id]); ?>,1,0);" class="btns">
	                    <img src="/Template/mobile/new/Static/images/index_flow.png">
	                 </a>
	                 <span href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" class="price_pro">￥<?php echo ($v["shop_price"]); ?>元</span>
	              </div>
              </div>
            </a>
           </li>
           <?php if(($fl++%3 == 0) && ($fl < 9)): ?></ul><ul><?php endif; endforeach; ?>
           </ul>
       </div>
       <div class="hd">
          <ul></ul>
       </div>
      </div>
    </div>
  </section> -->
  <!-- <script type="text/javascript">
    TouchSlide({ 
      slideCell:"#scroll_best",
      titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      effect:"leftLoop", 
      autoPage:true, //自动分页
      //switchLoad:"_src" //切换加载，真实图片路径为"_src" 
    });
  </script> -->
<section class="index_floor">
  <div class="floor_body1" >
    <h2>
      <em></em>
      新品上市
        <div class="geng"><a href="<?php echo U('Goods/search',array('q'=>'新品'));?>" >更多</a> <span></span></div>
    </h2>
    <div id="scroll_new" class="scroll_hot">
      <div class="bd">
        <ul>
        <?php $fl = '1'; ?>
         <?php
 $md5_key = md5("select * from __PREFIX__goods where is_new=1 order by sort limit 9"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("select * from __PREFIX__goods where is_new=1 order by sort limit 9"); S("sql_".$md5_key,$sql_result_v,31104000); } foreach($sql_result_v as $k=>$v): ?><li>
            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" title="<?php echo ($v["goods_name"]); ?>">
             <div class="index_pro"> 
	              <div class="products_kuang">
	                <img src="<?php echo (goods_thum_images($v["goods_id"],400,400)); ?>"></div>
	              <div class="goods_name"><?php echo ($v["goods_name"]); ?></div>
	              <div class="price">
	                 <a href="javascript:AjaxAddCart(<?php echo ($v[goods_id]); ?>,1,0);" class="btns">
	                    <img src="/Template/mobile/new/Static/images/index_flow.png">
	                 </a>
	                 <span href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" class="price_pro">￥<?php echo ($v["shop_price"]); ?>元</span>
	              </div>
              </div>
            </a>
           </li>
           <?php if(($fl++%3 == 0) && ($fl < 9)): ?></ul><ul><?php endif; endforeach; ?></ul>
        </div>
        <div class="hd">
          <ul></ul>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    TouchSlide({ 
      slideCell:"#scroll_new",
      titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      effect:"leftLoop", 
      autoPage:true, //自动分页
      //switchLoad:"_src" //切换加载，真实图片路径为"_src" 
    });
  </script>
<section class="index_floor">
  <div class="floor_body1" >
    <h2><em></em>热销商品
        <div class="geng"><a href="<?php echo U('Goods/search',array('q'=>'热销'));?>" >更多</a> <span></span></div>
    </h2>
    <div id="scroll_hot" class="scroll_hot">
      <div class="bd">
        <ul>
        <?php $fl = '1'; ?>
         <?php
 $md5_key = md5("select * from __PREFIX__goods where is_hot=1 order by sort limit 9"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("select * from __PREFIX__goods where is_hot=1 order by sort limit 9"); S("sql_".$md5_key,$sql_result_v,31104000); } foreach($sql_result_v as $k=>$v): ?><li>
            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" title="<?php echo ($v["goods_name"]); ?>">
             <div class="index_pro"> 
	              <div class="products_kuang">
	                <img src="<?php echo (goods_thum_images($v["goods_id"],400,400)); ?>"></div>
	              <div class="goods_name"><?php echo ($v["goods_name"]); ?></div>
	              <div class="price">
	                 <a href="javascript:AjaxAddCart(<?php echo ($v[goods_id]); ?>,1,0);" class="btns">
	                    <img src="/Template/mobile/new/Static/images/index_flow.png">
	                 </a>
	                 <span href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" class="price_pro">￥<?php echo ($v["shop_price"]); ?>元</span>
	              </div>
              </div>
            </a>
           </li>
           <?php if(($fl++%3 == 0) && ($fl < 9)): ?></ul><ul><?php endif; endforeach; ?></ul>
          </div>
        <div class="hd">
          <ul></ul>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    TouchSlide({ 
      slideCell:"#scroll_hot",
      titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      effect:"leftLoop", 
      autoPage:true, //自动分页
      //switchLoad:"_src" //切换加载，真实图片路径为"_src" 
    });
  </script>
 
 
<!-- <section class="index_floor_lou">
    <div class="floor_body ">
        <h2>
            <em></em><div class="geng"><a href="javascript:void(0);" >更多</a> <span></span></div>
         </h2>
        <ul>
         </ul>
    </div>
</section>  -->
<!--  
<div id="index_banner" class="index_banner">
	<div class="bd">
		<ul>
          <?php $pid =309;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->getField("position_id,position_name,ad_width,ad_height");$result = D("ad")->where("pid=$pid  and enabled = 1 and start_time < 1502352000 and end_time > 1502352000 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("2")->select(); if(!in_array($pid,array_keys($ad_position)) && $pid) { M("ad_position")->add(array( "position_id"=>$pid, "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ", "is_open"=>1, "position_desc"=>CONTROLLER_NAME."页面", )); delFile(RUNTIME_PATH); } $c = 2- count($result); if($c > 0 && $_GET[edit_ad]) { for($i = 0; $i < $c; $i++) { $result[] = array( "ad_code" => "/Public/images/not_adv.jpg", "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid", "title" =>"暂无广告图片", "not_adv" => 1, "target" => 0, ); } } foreach($result as $key=>$v): $v[position] = $ad_position[$v[pid]]; if($_GET[edit_ad] && $v[not_adv] == 0 ) { $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]"; $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name]; $v[target] = 0; } ?><li>
            <a href="<?php echo ($v["ad_link"]); ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> >
                <img src="<?php echo ($v[ad_code]); ?>" title="<?php echo ($v[title]); ?>" style="<?php echo ($v[style]); ?>" border="0">
            </a>
            </li><?php endforeach; ?>        
	    </ul>
	</div>
	<div class="hd">
		<ul>         
        </ul>
	</div>
</div> -->
<!-- <script type="text/javascript">
	TouchSlide({ 
		slideCell:"#index_banner",
		titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
		mainCell:".bd ul", 
		effect:"leftLoop", 
		autoPage:true,//自动分页
		autoPlay:true //自动播放
	});
</script> -->
   
<script type="text/javascript">
var url = "index.php?m=Mobile&c=Index&a=ajaxGetMore";
$(function(){
	//$('#J_ItemList').more({'address': url});
	getGoodsList();
});

var page = 1;
function getGoodsList(){
	$('.get_more').show();
	$.ajax({
		type : "get",
		url:"/index.php?m=Mobile&c=Index&a=ajaxGetMore&p="+page,
		dataType:'html',
		success: function(data)
		{
			if(data){
				$("#J_ItemList>ul").append(data);
				page++;
				$('.get_more').hide();
			}else{
				$('.get_more').hide();
				$('#getmore').remove();
			}
		}
	}); 
}
</script> 
<!-- <div class="floor_body2" >
  <h2>————&nbsp;猜你喜欢&nbsp;————</h2>
  <div id="J_ItemList">
    <ul class="product single_item info">
    </ul>
    <a href="javascript:;" class="get_more" style="text-align:center; display:block;"> 
    <img src='/Template/mobile/new/Static/images/category/loader.gif' width="12" height="12"> </a> 
  </div>
  <div id="getmore" style="font-size:.24rem;text-align: center;color:#888;padding:.25rem .24rem .4rem;">
  	<a href="javascript:void(0)" onClick="getGoodsList()">点击加载更多</a>
  </div>
</div> -->
<!--
<div class="footer" >
	      <div class="links"  id="TP_MEMBERZONE"> 
	      		<?php if($user_id > 0): ?><a href="<?php echo U('User/index');?>"><span><?php echo ($user["nickname"]); ?></span></a><a href="<?php echo U('User/logout');?>"><span>退出</span></a>
	      		<?php else: ?>
	      		<a href="<?php echo U('User/login');?>"><span>登录</span></a><a href="<?php echo U('User/reg');?>"><span>注册</span></a><?php endif; ?>
	      		<a href="#"><span>反馈</span></a><a href="javascript:window.scrollTo(0,0);"><span>回顶部</span></a>
		  </div>
	      <ul class="linkss" >
		      <li>
		        <a href="#">
		        <i class="footerimg_1"></i>
		        <span>客户端</span></a></li>
		      <li>
		      <a href="javascript:;"><i class="footerimg_2"></i><span class="gl">触屏版</span></a></li>
		      <li><a href="<?php echo U('Home/Index/index');?>" class="goDesktop"><i class="footerimg_3"></i><span>电脑版</span></a></li>
	      </ul>
	  	 <p class="mf_o4">备案号:<?php echo ($tpshop_config['shop_info_record_no']); ?><br/>&copy; 2005-2016 TPshop多商户V1.2 版权所有，并保留所有权利。</p>
</div>
-->
<script>
function goTop(){
	$('html,body').animate({'scrollTop':0},600);
}
</script>
<a href="javascript:goTop();" class="gotop"><img src="/Template/mobile/new/Static/images/topup.png"></a> 
</div>
<div id="J_demo" style="display:none"></div>
 <div id="search_hide" class="search_hide">
 <h2> <span class="close"><img src="/Template/mobile/new/Static/images/close.png"></span>关键搜索</h2>
 <div id="mallSearch" class="search_mid">
        <div id="search_tips" style="display:none;"></div>
          <ul class="search-type">
          	<li  class="cur"  num="0">宝贝</li>
          	<!--<li  num="1">店铺</li>-->
          </ul>	
          <div class="searchdotm"> 
          <form class="set_ip" name="sourch_form" id="sourch_form" method="post" action="<?php echo U('Goods/search');?>">
              <div class="mallSearch-input">
                <div id="s-combobox-135">
                    <input class="s-combobox-input" name="q" id="q"  placeholder="请输入关键词"  type="text" value="<?php echo I('q'); ?>" />
                </div>                                                
                <input type="button" value="" class="button"  onclick="if($.trim($('#q').val()) != '') $('#sourch_form').submit();" />
              </div>
          </form>
         </div> 
        </div>
 		<!--
		<div class="search_body">
		<div class="search_box">
		<form action="search.php" method="post" id="searchForm" name="searchForm">
		<div>
		<select id='search_type' name="search_type" style="width:15%;">
			<option value='search'>宝贝</option>
			<option value='stores'>店铺</option>
		</select>
		     <input class="text" type="search" name="keywords" id="keywordBox" autofocus>
		     <button type="submit" value="搜 索" ></button>
		</div>
		</form>
	    </div>
		</div>
       -->              
    	<section class="mix_recently_search"><h3>热门搜索</h3>
	     <ul>
            <?php if(is_array($tpshop_config["hot_keywords"])): foreach($tpshop_config["hot_keywords"] as $k=>$wd): ?><li><a href="<?php echo U('Goods/search',array('q'=>$wd));?>" <?php if($k == 0): ?>class="ht"<?php endif; ?>><?php echo ($wd); ?></a></li><?php endforeach; endif; ?>         
	      </ul>
        </section>
    </div>
                                             
</div>
<div style="height:50px; line-height:50px; clear:both;"></div>
<div class="v_nav">
	<div class="vf_nav">
		<ul>
			<li> <a href="<?php echo U('Index/index');?>">
			    <i class="vf_1"></i>
			    <span>首页</span></a></li>
			<!-- <li><a href="tel:<?php echo ($tpshop_config['shop_info_phone']); ?>">
			    <i class="vf_2"></i>
			    <span>客服</span></a></li> -->
			<li><a href="<?php echo U('Goods/categoryList');?>">
			    <i class="vf_3"></i>
			    <span>分类</span></a></li>
			<li>
			<a href="<?php echo U('Cart/cart');?>">
			   <em class="global-nav__nav-shop-cart-num" id="cart_quantity" style="right:9px;"></em>
			   <i class="vf_4"></i>
			   <span>购物车</span>
			   </a>
			</li>
			<li><a href="<?php echo U('User/index');?>">
			    <i class="vf_5"></i>
			    <span>我的</span></a>
			</li>
		</ul>
	</div>
</div> 
<script type="text/javascript">
$(document).ready(function(){
	  var cart_cn = getCookie('cn');
	  if(cart_cn == ''){
		$.ajax({
			type : "GET",
			url:"/index.php?m=Home&c=Cart&a=header_cart_list",//+tab,
			success: function(data){								 
				cart_cn = getCookie('cn');
				$('#cart_quantity').html(cart_cn);						
			}
		});	
	  }
	  $('#cart_quantity').html(cart_cn);
});
</script>
<!-- 微信浏览器 调用微信 分享js-->
<?php if($signPackage != null): ?><script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script src="/Public/js/global.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">

<?php if(ACTION_NAME == 'goodsInfo'): ?>var ShareLink = "http://<?php echo ($_SERVER[HTTP_HOST]); ?>/index.php?m=Mobile&c=Goods&a=goodsInfo&id=<?php echo ($goods[goods_id]); ?>"; //默认分享链接
   var ShareImgUrl = "http://<?php echo ($_SERVER[HTTP_HOST]); echo (goods_thum_images($goods[goods_id],400,400)); ?>"; // 分享图标
<?php else: ?>
   var ShareLink = "http://<?php echo ($_SERVER[HTTP_HOST]); ?>/index.php?m=Mobile&c=Index&a=index"; //默认分享链接
   var ShareImgUrl = "http://<?php echo ($_SERVER[HTTP_HOST]); echo ($tpshop_config['shop_info_store_logo']); ?>"; // 分享图标<?php endif; ?>

var is_distribut = getCookie('is_distribut'); // 是否分销代理
var user_id = getCookie('user_id'); // 当前用户id
//alert(is_distribut+'=='+user_id);

// 如果已经登录了, 并且是分销商
if(parseInt(is_distribut) == 1 && parseInt(user_id) > 0)
{									
	ShareLink = ShareLink + "&first_leader="+user_id;									
}										


// 微信配置
wx.config({
    debug: false, 
    appId: "<?php echo ($signPackage['appId']); ?>", 
    timestamp: '<?php echo ($signPackage["timestamp"]); ?>', 
    nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>', 
    signature: '<?php echo ($signPackage["signature"]); ?>',
    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone','hideOptionMenu'] // 功能列表，我们要使用JS-SDK的什么功能
});

// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在 页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready 函数中。
wx.ready(function(){
    // 获取"分享到朋友圈"按钮点击状态及自定义分享内容接口
    wx.onMenuShareTimeline({
        title: "<?php echo ($tpshop_config['shop_info_store_title']); ?>", // 分享标题
        link:ShareLink,
        imgUrl:ShareImgUrl // 分享图标
    });

    // 获取"分享给朋友"按钮点击状态及自定义分享内容接口
    wx.onMenuShareAppMessage({
        title: "<?php echo ($tpshop_config['shop_info_store_title']); ?>", // 分享标题
        desc: "<?php echo ($tpshop_config['shop_info_store_desc']); ?>", // 分享描述
        link:ShareLink,
        imgUrl:ShareImgUrl // 分享图标
    });
	// 分享到QQ
	wx.onMenuShareQQ({
        title: "<?php echo ($tpshop_config['shop_info_store_title']); ?>", // 分享标题
        desc: "<?php echo ($tpshop_config['shop_info_store_desc']); ?>", // 分享描述
        link:ShareLink,
        imgUrl:ShareImgUrl // 分享图标
	});	
	// 分享到QQ空间
	wx.onMenuShareQZone({
        title: "<?php echo ($tpshop_config['shop_info_store_title']); ?>", // 分享标题
        desc: "<?php echo ($tpshop_config['shop_info_store_desc']); ?>", // 分享描述
        link:ShareLink,
        imgUrl:ShareImgUrl // 分享图标
	});

	   <?php if(CONTROLLER_NAME == 'User'): ?>wx.hideOptionMenu();  // 用户中心 隐藏微信菜单<?php endif; ?>
});
</script>


<!--微信关注提醒 start-->
<?php if($_SESSION['subscribe']== 0): ?><button class="guide" onclick="follow_wx()"><font color='red'>关注公众号</font></button>
<style type="text/css">
.guide{width:20px;height:100px;text-align: center;border-radius: 8px ;font-size:12px;padding:8px 0;border:1px solid #adadab;color:#000000;background-color: #fff;position: fixed;right: 6px;bottom: 200px;}
#cover{display:none;position:absolute;left:0;top:0;z-index:18888;background-color:#000000;opacity:0.7;}
#guide{display:none;position:absolute;top:5px;z-index:19999;}
#guide img{width: 70%;height: auto;display: block;margin: 0 auto;margin-top: 10px;}
</style>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
<script type="text/javascript">

  // 关注微信公众号二维码	 
function follow_wx()
{
	layer.open({
		type : 1,  
		title: '关注公众号',
		content: '<img src="<?php echo ($wechat_config['qr']); ?>" width="200">',
		style: ''
	});
}
 
</script><?php endif; ?>
<!--微信关注提醒  end--><?php endif; ?>
<!-- 微信浏览器 调用微信 分享js  end-->
 
<script type="text/javascript">
$(function() {
    $('#search_text').click(function(){
        $(".showpage").children('div').hide();
        $("#search_hide").css('position','fixed').css('top','0px').css('width','100%').css('z-index','999').show();
    })
    $('#get_search_box').click(function(){
        $(".showpage").children('div').hide();
        $("#search_hide").css('position','fixed').css('top','0px').css('width','100%').css('z-index','999').show();
    })
    $("#search_hide .close").click(function(){
        $(".showpage").children('div').show();
        $("#search_hide").hide();
    })
});
</script>
<script>
$('.search-type li').click(function() {
    $(this).addClass('cur').siblings().removeClass('cur');
    $('#searchtype').val($(this).attr('num'));
});
$('#searchtype').val($(this).attr('0'));
</script>
<script src="/Public/js/jqueryUrlGet.js"></script><!--获取get参数插件-->
<script> set_first_leader(); //设置推荐人 </script>
</body>
</html>