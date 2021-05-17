<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="jiachang" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="applicable-device" content="mobile">
<title><?php echo ($tpshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<meta name="Keywords" content="佳昌微商城" />
<meta name="Description" content="佳昌微商城 "/>
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/user.css">
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script src="/Public/js/global.js"></script>
<script src="/Public/js/mobile_common.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/modernizr.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
</head>

<style type="text/css">
.Wallet ul li {
    float: left;
    width: 50%;
    text-align: center;
}

.dis-span {
    padding: 5px;
    background: black;
    border-radius: 5px;
}

.icon-jia {
    background: url("http://shop.17pche.com/Template/mobile/new/Static/images/dis+.png") no-repeat;
    height: 30px;
    width: 30px;
}

.dis-btn1-list,
.dis-btn2-list,
.dis-btn3-list {
    display: none;
    /*margin-top: -135px;*/
    /*z-index: 2; */
}

.dis-btn1-close {
    animation: btnclose 0.5s linear;
    margin-top: -135px;
    /*display: none;*/
}

.dis-btn1-open {
    animation: btnboll 0.2s linear;
    margin-top: 0px;
    display: block;
}

.dis-btn2-open {
    animation: btnlist 0.2s linear;
    margin-top: 0px;
    display: block;
}

.dis-btn2-close {
    animation: btn2list 0.2s linear;
    margin-top: 0px;
    display: block;
}

.dis-btn3-open {
    animation: btnmoney 0.2s linear;
    margin-top: 0px;
    display: block;
}

.dis-btn3-close {
    animation: btn3list 0.2s linear;
    margin-top: 0px;
    display: block;
}


/*展示选项*/


/*分销商*/

@keyframes btnboll {
    0% {
        margin-top: -135px;
        opacity: 0;
    }
    50% {
        margin-top: -72px;
        opacity: 0.1;
    }
    100% {
        margin-top: 0px;
        opacity: 1;
    }
}


/*订单*/

@keyframes btnlist {
    0% {
        margin-top: -90px;
        opacity: 0;
    }
    50% {
        margin-top: -45px;
        opacity: 0.3;
    }
    100% {
        margin-top: 0px;
        opacity: 1;
    }
}

@keyframes btnmoney {
    0% {
        margin-top: -270px;
        opacity: 0;
    }
    50% {
        margin-top: -135px;
        opacity: 0.3;
    }
    100% {
        margin-top: 0px;
        opacity: 1;
    }
}


/*隐藏选项*/

@keyframes btnclose {
    0% {
        margin-top: 0px;
        opacity: 1;
    }
    50% {
        margin-top: -72px;
        opacity: 0.1;
    }
    100% {
        margin-top: -135px;
        opacity: 0;
    }
}

@keyframes btn2close {
    0% {
        margin-top: 0px;
        opacity: 1;
    }
    50% {
        margin-top: -45px;
        opacity: 0.3;
    }
    100% {
        margin-top: -90px;
        opacity: 0;
    }
}

@keyframes btn3close {
    0% {
        margin-top: 0px;
        opacity: 1;
    }
    50% {
        margin-top: -135px;
        opacity: 0.3;
    }
    100% {
        margin-top: -270px;
        opacity: 0;
    }
}
</style>

<body>
    <div id="tbh5v0">
        <div class="user_com">
            <div class="com_top">
	<h2><a href="<?php echo U('Mobile/User/userinfo');?>">设置</a></h2>
	<p class="tuij_cas">
	        <?php echo ($user['nickname']); ?>    (用户ID：<?php echo ($user['user_id']); ?>)
            <?php if($first_nickname != ''): ?><br />
            	<span>由( <?php echo ($first_nickname); ?> )推荐</span><?php endif; ?>
    </p>
	<dl>
		<dt>
		<img src='<?php echo ((isset($user[head_pic]) && ($user[head_pic] !== ""))?($user[head_pic]):"/Template/mobile/new/Static/images/user68.jpg"); ?>' />
        
		<!-- <dd><?php echo ($level_name); ?></dd> -->
		</dt>
	</dl>
</div>
<div class="uer_topnav">
	<ul>
		<li class="bain"><a href="<?php echo U('Mobile/User/order_list');?>" ><span><?php echo ($order_count); ?></span>我的订单</a></li>
		<li class="bain"><a href="<?php echo U('Mobile/User/collect_list');?>"><span><?php echo ($goods_collect_count); ?></span>我的收藏</a></li>
		<li><a href="<?php echo U('Mobile/User/comment');?>"><span><?php echo ($comment_count); ?></span>我的评价</a></li>
	</ul>
</div>
            <div class="Wallet">
                <ul>
                    <li class="bain1"><strong>￥<?php echo ($user['user_money']); ?>元</strong><span>余额</span></li>
                    <li><strong>￥<?php echo ($user[distribut_money]); ?></strong><span>我的奖励</span></li>
                </ul>
            </div>
            <div class="Wallet">
                <a href="javascript:;" id="dis-btn1" data-operation="no" style="z-index: 10">
                    <em class="Icon j_million"></em>
                    <dl class="b">
                        <dt>我的分销商</dt>
                        <dd class=""><span class="dis-span"><?php echo ($totle); ?>人</span></dd>
                    </dl>
                </a>
                <div class="dis-btn1-list">
                    <a href="<?php echo U('Mobile/Distribut/myleader',array('user_id'=>$user[user_id],'leader'=>1));?>">
                        <dl class="b">
                            <dt>我的一级分销商</dt>
                            <dd class=""><?php echo ($first_leader); ?>人</dd>
                        </dl>
                    </a>
                    <a href="<?php echo U('Mobile/Distribut/myleader',array('user_id'=>$user[user_id],'leader'=>2));?>">
                        <dl class="b">
                            <dt>我的二级分销商</dt>
                            <dd class=""><?php echo ($second_leader); ?>人</dd>
                        </dl>
                    </a>
                    <a href="<?php echo U('Mobile/Distribut/myleader',array('user_id'=>$user[user_id],'leader'=>3));?>">
                        <dl class="b">
                            <dt>我的三级分销商</dt>
                            <dd class=""><?php echo ($third_leader); ?>人</dd>
                        </dl>
                    </a>
                </div>
                <!-- 我的推广 -->
                <!-- <a href="javascript:;" id="dis-btn2" data-operation="no" style="z-index: 10"><em class="Icon j_million"></em><dl class="b"><dt>我的推广</dt><dd class=""><span class="dis-span">0单 (￥0)</span></dd></dl></a>
                <div class="dis-btn2-list">
                    <a href="">
                        <dl class="b">
                            <dt>下单未购买</dt>
                            <dd class="">1人</dd>
                        </dl>
                    </a>
                    <a href="#">
                        <dl class="b">
                            <dt>下单已购买</dt>
                            <dd class="">1人</dd>
                        </dl>
                    </a>
                </div> -->
                <a href="javascript:;" id="dis-btn3" data-operation="no" style="z-index: 10"><em class="Icon j_million"></em><dl class="b"><dt>我的财富</dt><dd class="">&nbsp;</dd></dl></a>
                <div class="dis-btn3-list">
                    <!--                     <a href="">
                        <dl class="b">
                            <dt>未付款订单财富</dt>
                            <dd class="">￥0</dd>
                        </dl>
                    </a>
                    <a href="#">
                        <dl class="b">
                            <dt>已付款订单财富</dt>
                            <dd class="">￥0</dd>
                        </dl>
                    </a>
                    <a href="#">
                        <dl class="b">
                            <dt>已收货订单财富</dt>
                            <dd class="">￥0</dd>
                        </dl>
                    </a>
                    <a href="#">
                        <dl class="b">
                            <dt>已分成订单财富</dt>
                            <dd class="">￥0</dd>
                        </dl>
                    </a> -->
                    <a href="javascript:;">
                        <dl class="b">
                            <dt>可提现财富</dt>
                            <dd class="">￥<?php echo ($user['user_money']); ?></dd>
                        </dl>
                    </a>
                    <a href="javascript:;">
                        <dl class="b">
                            <dt>已提现财富</dt>
                            <dd class="">￥<?php echo ($user['frozen_money']); ?></dd>
                        </dl>
                    </a>
                </div>
                <a href="<?php echo U('Mobile/Distribut/myqrcode',array('user_id'=>$user[user_id]));?>"><em class="Icon j_million"></em><dl class="b"><dt>我的推广二维码</dt><dd>&nbsp;</dd></dl></a>
                <!-- <a href="<?php echo U('Mobile/Distribut/line_up');?>">
                    <em class="Icon j_million"></em>
                    <dl class="b">
                        <dt>排队领钱啦~！</dt>
                        <dd>&nbsp;</dd>
                    </dl>
                </a> -->
            </div>
        </div>
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
</body>
<script type="text/javascript">
$("#dis-btn1").click(function() {
    var btn1type = $(this).attr("data-operation");
    if (btn1type == 'no') {
        $(this).attr("data-operation", "yes");
        $(".dis-btn1-list").addClass("dis-btn1-open");
        // $(this).children(".dis-btn1-list").addClass("dis-btn1-open");
    } else {
        $(this).attr("data-operation", "no");
        $(".dis-btn1-list").removeClass("dis-btn1-open");
        // $(this).children(".dis-btn1-list").removeClass("dis-btn1-open");
    }
})
$("#dis-btn2").click(function() {
    var btn1type = $(this).attr("data-operation");
    if (btn1type == 'no') {
        $(this).attr("data-operation", "yes");
        $(".dis-btn2-list").addClass("dis-btn2-open");
        // $(this).children(".dis-btn1-list").addClass("dis-btn1-open");
    } else {
        $(this).attr("data-operation", "no");
        $(".dis-btn2-list").removeClass("dis-btn2-open");
        // $(this).children(".dis-btn1-list").removeClass("dis-btn1-open");
    }
})
$("#dis-btn3").click(function() {
    var btn1type = $(this).attr("data-operation");
    if (btn1type == 'no') {
        $(this).attr("data-operation", "yes");
        $(".dis-btn3-list").addClass("dis-btn3-open");
        // $(this).children(".dis-btn1-list").addClass("dis-btn1-open");
    } else {
        $(this).attr("data-operation", "no");
        $(".dis-btn3-list").removeClass("dis-btn3-open");
        // $(this).children(".dis-btn1-list").removeClass("dis-btn1-open");
    }
})
</script>

</html>