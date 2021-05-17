<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>我的二维码</title>
    </head>
    <style>
    html,
    body {
        width: 100%;
        height: 100%;
        background: #333333;
        overflow: hidden;
    }
    #box {
        margin: 0;
        padding: 0;
        background: #333333;
        z-index: 3;
        text-align: center;
    }
    
    .qrcode {
        position: absolute;
        top: 10%;
        left: 10%;
        width: 80%;
        height: 70%;
        background: white;
        z-index: 5;
        box-shadow: 0px 0px 25px 6px white;
    }
    
    img {
        width: 70%;
    }
    
    .qrcode_p p {
        color: red;
        font: 28px bold 黑体;
    }
    
    .banner {
        margin-top: 10%;
    }
    </style>

    <body>
        <div id="box">
            <div class="qrcode">
                <div class="banner">
                    <img src="/Public/images/qrcode_title.jpg" alt="广告区">
                </div>
                <img src="<?php echo ($qrcode); ?>" />
                <div class="qrcode_p">
                    <p>扫一扫或长按识别二维码，</p>
                    <p>即刻带您进入轻松赚钱模式！</p>
                    <p>24小时免费客服热线：13890118579</p>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
    var name = "<?php echo ($user['nickname']); ?>";
    var imgurl = "<?php echo ($user['head_pic']); ?>";
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            "onMenuShareTimeline",
            "onMenuShareAppMessage",
        ]
    });
    wx.ready(function() {
        // 在这里调用 API
        wx.hideOptionMenu();
        // 朋友圈
        wx.onMenuShareTimeline({
            title: ''+name+'的二维码', // 分享标题
            link: '', // 分享链接
            imgUrl: imgurl, // 分享图标
            success: function() {
                // 用户确认分享后执行的回调函数
                // alert("分享成功");
            },
            cancel: function() {
                // 用户取消分享后执行的回调函数
                // alert("取消分享");
            }
        });
        //好友
        wx.onMenuShareAppMessage({
            title: ''+name+'的二维码', // 分享标题
            desc: ''+name+'的推广二维码,请扫描此二维码',
            link: '', // 分享链接
            imgUrl: imgurl, // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function() {
                // 用户确认分享后执行的回调函数
            },
            cancel: function() {
                // 用户取消分享后执行的回调函数
            }
        });
    });
    wx.error(function(res) {

        // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。

    });
    </script>

    </html>