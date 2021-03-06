<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>

<head>
    <meta name="Generator" content="tpshop" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title><?php echo ($goods["goods_name"]); ?>_<?php echo ($tpshop_config["shop_info_store_title"]); ?></title>
    <meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
    <meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
    <meta name="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/public.css" />
    <link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/goods.css" />
    <link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/layer.css" />
    <script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
    <script type="text/javascript" src="/Template/mobile/new/Static/js/touchslider.dev.js"></script>
    <script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/js/mobile_common.js"></script>
    <script src="/Template/mobile/new/Static/js/common.js"></script>
</head>
<style>
.cpxq-explain {
    font-size: 16px;
    color: #e01d20;
    line-height: 20px;
    /*padding: 6px 0 6px 0;*/
    /*height: 55px;*/
    overflow: hidden;
}
</style>

<body>
    <script type="text/javascript">
    var process_request = "正在处理您的请求...";
    </script>
    <div class="main">
        <div class="tab_nav">
            <div class="header">
                <div class="h-left">
                    <a class="sb-back" href="javascript:history.back(-1)" title="返回"></a>
                </div>
                <div class="h-mid">
                    <ul>
                        <li><a href="javascript:;" class="tab_head on" id="goods_ka1" onClick="setGoodsTab('goods_ka',1,3)">商品</a></li>
                        <li><a href="javascript:;" class="tab_head" id="goods_ka2" onClick="setGoodsTab('goods_ka',2,3)">详情</a></li>
                        <li><a href="javascript:;" class="tab_head" id="goods_ka3" onClick="setGoodsTab('goods_ka',3,3)">评价</a></li>
                    </ul>
                </div>
                <div class="h-right">
                    <aside class="top_bar">
                        <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more">
                            <a href="javascript:;"></a>
                        </div>
                        <a href="<?php echo U('Mobile/Cart/cart');?>" class="show_cart"><em class="global-nav__nav-shop-cart-num" id="tp_cart_info"></em></a>
                    </aside>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="/Template/mobile/new/Static/js/mobile.js" ></script>
<div class="goods_nav hid" id="menu">
      <div class="Triangle">
        <h2></h2>
      </div>
      <ul>
        <li><a href="<?php echo U('Index/index');?>"><span class="menu1"></span><i>首页</i></a></li>
        <li><a href="<?php echo U('Goods/categoryList');?>"><span class="menu2"></span><i>分类</i></a></li>
        <li><a href="<?php echo U('Cart/cart');?>"><span class="menu3"></span><i>购物车</i></a></li>
        <li style=" border:0;"><a href="<?php echo U('User/index');?>"><span class="menu4"></span><i>我的</i></a></li>
   </ul>
 </div> 
        <div class="main" id="user_goods_ka_1" style="display:block;">
            <div class="banner">
                <div id="slider" class="slider" style="overflow: hidden; visibility: visible; list-style: none; position: relative;">
                    <ul id="sliderlist" class="sliderlist" style="position: relative; overflow: hidden; transition: left 600ms ease; -webkit-transition: left 600ms ease;">
                        <?php if(is_array($goods_images_list)): foreach($goods_images_list as $key=>$pic): ?><li style="float: left; display: block; width: 100%;"><span><a  href="javascript:void(0)">
        <img title="" width="100%" src="<?php echo ($pic["image_url"]); ?>"></a></span></li><?php endforeach; endif; ?>
                    </ul>
                    <div id="pagenavi">
                        <?php if(is_array($goods_images_list)): foreach($goods_images_list as $k=>$pic): ?><a href="javascript:void(0);" <?php if($k == 0): ?>class="active"<?php endif; ?>></a><?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
            <div class="s_bottom"></div>
            <script type="text/javascript">
            $(function() {
                $("div.module_special .wrap .major ul.list li:last-child").addClass("remove_bottom_line");
            });
            var active = 0,
                as = document.getElementById('pagenavi').getElementsByTagName('a');

            for (var i = 0; i < as.length; i++) {
                (function() {
                    var j = i;
                    as[i].onclick = function() {
                        t2.slide(j);
                        return false;
                    }
                })();
            }
            var t2 = new TouchSlider({
                id: 'sliderlist',
                speed: 600,
                timeout: 6000,
                before: function(index) {
                    as[active].className = '';
                    active = index;
                    as[active].className = 'active';
                }
            });
            </script>
            <form name="buy_goods_form" method="post" id="buy_goods_form">
                <div class="product_info">
                    <div class="info_dottm">
                        <h3 class="name"><?php echo ($goods["goods_name"]); ?>
                            <div class="cpxq-explain" style="max-height: 150px">
                            <?php if($flash_sale['description'] != ''): echo ($flash_sale['description']); ?>
                                <?php else: ?> <?php echo ($goods["goods_remark"]); endif; ?>
                        </div>
                            </h3>
                    </div>
                    <dl class="goods_price">
                        <script type="text/javascript" src="/Template/mobile/new/Static/js/lefttime.js"></script>
                        <dt> <span id="goods_price">￥<?php echo ($goods["shop_price"]); ?>元</span>
                            <font>价格：￥<?php echo ($goods["market_price"]); ?>元</font>
                        </dt>
                    </dl>
                    <ul class="price_dottm">
                        <li style=" text-align:left">折扣：<?php echo ($goods["discount"]); ?>折</li>
                        <li><?php echo ($commentStatistics["c0"]); ?>人评价</li>
                        <li style=" text-align:right"><?php echo ($goods["sale_num"]); ?>人已付款</li>
                    </ul>
                </div>
                <?php if(($prom_goods != null) OR ($prom_order != null)): ?><section id="search_ka" class="huodong">
                        <div class="subNav">
                            <div class="att_title"> <span>惠</span>
                                <p>促销活动</p>
                            </div>
                        </div>
                        <div class="navContent">
                            <?php if($prom_goods != null): ?><ul class="youhui_list1">
                                    <li>
                                        <a href="javascript:void(0);" title="<?php echo ($prom_goods[name]); ?>"><img src="/Template/mobile/new/Static/images/hui.png"></a>
                                        <a href="javascript:void(0);"><?php echo ($prom_goods[name]); ?>&nbsp;&nbsp;(活动时间：<?php echo (date("m月d日",$prom_goods[start_time])); ?> - <?php echo (date("m月d日",$prom_goods[end_time])); ?>)</a>
                                    </li>
                                </ul><?php endif; ?>
                            <?php
 $md5_key = md5("select * from `__PREFIX__prom_order` order by  id desc limit 5"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("select * from `__PREFIX__prom_order` order by  id desc limit 5"); S("sql_".$md5_key,$sql_result_v,31104000); } foreach($sql_result_v as $k=>$v): ?><ul class="youhui_list1" style="margin-top:0px;">
                                    <li><img src="/Template/mobile/new/Static/images/hui.png"><?php echo ($v['name']); ?>&nbsp;&nbsp;(活动时间：<?php echo (date("m月d日",$v[start_time])); ?> - <?php echo (date("m月d日",$v[end_time])); ?>)</li>
                                </ul><?php endforeach; ?>
                            <div class="blank10"></div>
                        </div>
                    </section><?php endif; ?>
                <!-------商品属性-------->
                <?php if($filter_spec != ''): ?><section id="search_ka">
                        <!---属性---->
                        <div class="ui-sx bian1">
                            <div class="subNavBox">
                                <div class="subNav"><strong>选择商品属性</strong></div>
                                <ul class="navContent">
                                    <?php if(is_array($filter_spec)): foreach($filter_spec as $key=>$spec): ?><li>
                                            <div class="title"><?php echo ($key); ?></div>
                                            <div class="item">
                                                <?php if(is_array($spec)): foreach($spec as $k2=>$v2): ?><a href="javascript:;" onclick="switch_spec(this);" title="<?php echo ($v2[item]); ?>" <?php if($k2 == 0): ?>class="hover"<?php endif; ?>>
              <input type="radio" style="display:none;" name="goods_spec[<?php echo ($key); ?>]" value="<?php echo ($v2[item_id]); ?>" <?php if($k2 == 0 ): ?>checked="checked"<?php endif; ?>/>
              <?php echo ($v2[item]); ?>            
              </a><?php endforeach; endif; ?>
                                            </div>
                                        </li><?php endforeach; endif; ?>
                                </ul>
                            </div>
                        </div>
                    </section><?php endif; ?>
                <section id="search_ka">
                    <div class="ui-sx bian1">
                        <div class="subNavBox">
                            <div class="subNav on"><strong>购买数量</strong></div>
                            <ul class="navContent" style="display: block;">
                                <li style=" border-bottom:1px solid #eeeeee">
                                    <div class="item1">
                                        <span class="ui-number">
                  <button type="button" class="decrease" onClick="goods_cut();">-</button>
                    <input type="text" class="num" id="number" name="goods_num" value="1" min="1" max="1000"/>
                    <input type="hidden" name="goods_id" value="<?php echo ($goods["goods_id"]); ?>"/>
                  <button type="button" class="increase" onClick="goods_add();">+</button>
                  </span> </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
                <!-- <section id="search_ka">
                    <div class="ui-sx bian1">
                        <div class="subNavBox">
                            <div class="subNav"><strong>会员专享价</strong></a>
                            </div>
                            <ul class="navContent">
                                <li class="user_price">
                                    <p> <span class="key">铜牌会员：</span> <b class="p-price-v">9.8折</b> </p>
                                    <p> <span class="key">金牌会员：</span> <b class="p-price-v">9.5折</b> </p>
                                    <p> <span class="key">钻石会员：</span> <b class="p-price-v">9折</b> </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section> -->
                <script type="text/javascript">
                function ajaxComment(commentType, page) {
                    $.ajax({
                        type: "GET",
                        url: "/index.php?m=Mobile&c=goods&a=ajaxComment&goods_id=<?php echo ($goods['goods_id']); ?>&commentType=" + commentType + "&p=" + page, //+tab,
                        success: function(data) {
                            $(".my_comment_list").empty().append(data);
                            var myPhotoSwipe = $("#gallery a").photoSwipe({
                                enableMouseWheel: false,
                                enableKeyboard: false,
                                allowUserZoom: false,
                                loop: false
                            });
                        }
                    });
                }
                $(function() {
                    $(".subNav").click(function() {
                        $(this).next(".navContent").slideToggle(300).siblings(".navContent").slideUp(500);
                        $(this).toggleClass("on").siblings(".subNav").removeClass("on");
                        if ($(".is_scroll").length <= 0) {
                            $('html,body').animate({
                                'scrollTop': $('body')[0].scrollHeight
                            }, 600);
                        }
                    });
                    commentType = 1; // 评论类型
                    ajaxComment(1, 1); // ajax 加载评价列表
                })
                </script>
                <script type="text/javascript">
                function click_search() {
                    var search_ka = document.getElementById("search_ka");
                    if (search_ka.className == "s-buy open ui-section-box") {
                        search_ka.className = "s-buy ui-section-box";
                    } else {
                        search_ka.className = "s-buy open ui-section-box";
                    }
                }

                function changeAtt(t) {
                    t.lastChild.checked = 'checked';
                    for (var i = 0; i < t.parentNode.childNodes.length; i++) {
                        if (t.parentNode.childNodes[i].className == 'hover') {
                            t.parentNode.childNodes[i].className = '';
                            t.childNodes[0].checked = "checked";
                        }
                    }
                    t.className = "hover";
                    changePrice();
                }

                function changeAtt1(t) {
                    t.lastChild.checked = 'checked';
                    for (var i = 0; i < t.parentNode.childNodes.length; i++) {
                        if (t.className == 'hover') {
                            t.className = '';
                            t.childNodes[0].checked = false;
                        } else {
                            t.className = "hover";
                            t.childNodes[0].checked = true;
                        }
                    }
                    changePrice();
                }

                function goods_cut() {
                    var num_val = document.getElementById('number');
                    var new_num = num_val.value;
                    var Num = parseInt(new_num);
                    if (Num > 1) Num = Num - 1;
                    num_val.value = Num;
                }

                function goods_add() {
                    var num_val = document.getElementById('number');
                    var new_num = num_val.value;
                    var Num = parseInt(new_num);
                    Num = Num + 1;
                    num_val.value = Num;
                }
                </script>
                <div style=" height:8px; background:#eeeeee; margin-top:-1px;"></div>
                <!--
      <div class="is_scroll">
        <section id="search_ka">
          <div class="ui-sx bian1">
            <div class="subNavBox" >
              <div class="subNav" style=" border:0;"><a href="pocking.php?id=22" style=" border:0px;"><strong>自提点</strong></a></div>
            </div>
          </div>
        </section>
      </div>
      -->
                <!--
      <div class="is_scroll">
        <input type="hidden" id="chat_supp_id" value="1" />
        <div style=" height:8px; background:#eeeeee; margin-top:-1px;"></div>
        <section class="rzs_info">
          <div class="top_info">
            <dl>
              <dt><a href="supplier.php?suppId=1">
                <div style="background-image:url(./..//data/supplier/logo/logo_supplier1.jpg)"></div>
                </a></dt>
              <dd><strong>卖家: <a href="supplier.php?suppId=1" style="color:#333; font-size:18px;">天天果园旗舰店</a></strong><em>初级店铺</em></dd>
            </dl>
            <ul>
              <li><span>宝贝描述</span><strong>:5.0</strong><em>高</em></li>
              <li><span>卖家服务</span><strong>:5.0</strong><em>高</em></li>
              <li><span>物流服务</span><strong>:5.0</strong><em>高</em></li>
            </ul>
          </div>
          <div class="s_dianpu"> <span><a href="tel:03350785268" style=" margin-left:7%;"><em class="bg1"></em>联系客服</a></span> <span><a href="supplier.php?suppId=1" style=" margin-left:3%;"><em class="bg2"></em>进入店铺</a></span> </div>
        </section>
      </div> 
      -->
            </form>
        </div>
        <div class="main" id="user_goods_ka_2" style="display:none">
            <div class="product_main" style=" margin-top:40px;">
                <!-- 产品图片 -->
                <div class="product_images product_desc" id="product_desc"> <?php echo (htmlspecialchars_decode($goods["goods_content"])); ?> </div>
            </div>
            <section class="index_floor">
                <h2 style=" border-bottom:1px solid #ddd "> <span></span> 商品信息 </h2>
                <ul class="xiangq">
                    <?php if(is_array($goods_attr_list)): foreach($goods_attr_list as $k=>$v): ?><li>
                            <p><?php echo ($goods_attribute[$v[attr_id]]); ?>:</p><span><?php echo ($v[attr_value]); ?></span></li><?php endforeach; endif; ?>
                    <li>
                        <p>上架时间：</p><span><?php echo (date('Y-m-d H:i',$goods["on_time"])); ?></span></li>
                    <li></li>
                </ul>
            </section>
        </div>
        <div class="tab_attrs tab_item hide" id="user_goods_ka_3" style="display:none;">
            <div id="ECS_COMMENT">
                <link href="/Template/mobile/new/Static/css/photoswipe.css" rel="stylesheet" type="text/css">
                <script src="/Template/mobile/new/Static/js/klass.min.js"></script>
                <script src="/Template/mobile/new/Static/js/photoswipe.js"></script>
                <div class="my_comment_list" id="ECS_MYCOMMENTS"> </div>
            </div>
        </div>
    </div>
    <script>
    function goTop() {
        $('html,body').animate({
            'scrollTop': 0
        }, 600);
    }
    </script>
    <a href="javascript:goTop();" class="gotop"><img src="/Template/mobile/new/Static/images/topup.png"></a>
    <div style=" height:60px;"></div>
    <div class="footer_nav">
        <ul>
            <li class="bian"><a href="<?php echo U('Index/index');?>"><em class="goods_nav1"></em><span>首页</span></a> </li>
            <li class="bian"><a href="tel:<?php echo ($tpshop_config['shop_info_phone']); ?>"><em class="goods_nav2"></em><span>客服</span></a> </li>
            <li><a href="javascript:collect_goods(<?php echo ($goods["goods_id"]); ?>)" id="favorite_add"><em class="goods_nav3"></em><span>收藏</span></a></li>
        </ul>
        <dl>
            <dd class="flow"><a class="button active_button" href="javascript:void(0);" onClick="AjaxAddCart(<?php echo ($goods["goods_id"]); ?>,1,0);">加入购物车</a> </dd>
            <dd class="goumai"><a style="display:block;" href="javascript:void(0);" onclick="AjaxAddCart(<?php echo ($goods["goods_id"]); ?>,1,1);">立即购买</a> </dd>
        </dl>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
        // 更新商品价格
        get_goods_price();
    });

    function switch_spec(spec) {
        $(spec).siblings().removeClass('hover');
        $(spec).addClass('hover');
        $(spec).siblings().children('input').prop('checked', false);
        $(spec).children('input').prop('checked', true);
        //更新商品价格
        get_goods_price();
    }

    function get_goods_price() {
        var goods_price = {
            <?php echo ($goods["shop_price"]); ?>
        }; // 商品起始价
        var store_count = {
            <?php echo ($goods["store_count"]); ?>
        }; // 商品起始库存  
        var spec_goods_price = {
            <?php echo ($spec_goods_price); ?>
        }; // 规格 对应 价格 库存表   //alert(spec_goods_price['28_100']['price']);  
        // 如果有属性选择项
        if (spec_goods_price != null) {
            goods_spec_arr = new Array();
            $("input[name^='goods_spec']:checked").each(function() {
                goods_spec_arr.push($(this).val());
            });
            var spec_key = goods_spec_arr.sort(sortNumber).join('_'); //排序后组合成 key  
            goods_price = spec_goods_price[spec_key]['price']; // 找到对应规格的价格   
            store_count = spec_goods_price[spec_key]['store_count']; // 找到对应规格的库存
        }
        var goods_num = parseInt($("#goods_num").val());
        // 库存不足的情况
        if (goods_num > store_count) {
            goods_num = store_count;
            alert('库存仅剩 ' + store_count + ' 件');
            $("#goods_num").val(goods_num);
        }
        var flash_sale_price = parseFloat("<?php echo ($goods['flash_sale']['price']); ?>");
        (flash_sale_price > 0) && (goods_price = flash_sale_price);
        $("#goods_price").html('￥' + goods_price + '元'); // 变动价格显示

    }

    function sortNumber(a, b) {
        return a - b;
    }



    $(document).ready(function() {
        var cart_cn = getCookie('cn');
        if (cart_cn == '') {
            $.ajax({
                type: "GET",
                url: "/index.php?m=Home&c=Cart&a=header_cart_list", //+tab,
                success: function(data) {
                    cart_cn = getCookie('cn');
                }
            });
        }
        $('#tp_cart_info').html(cart_cn);
    });
    </script>
    <script src="/Public/js/jqueryUrlGet.js"></script>
    <!--获取get参数插件-->
    <script>
    set_first_leader(); //设置推荐人
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

</html>