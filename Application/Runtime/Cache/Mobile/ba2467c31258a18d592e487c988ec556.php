<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>

<head>
    <meta name="Generator" content="TPshop v1.1" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title><?php echo ($article["title"]); ?></title>
    <meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
    <meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/public.css" />
    <link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/index.css" />
    <script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
    <script type="text/javascript" src="/Template/mobile/new/Static/js/TouchSlide.1.1.js"></script>
    <script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.json.js"></script>
    <script type="text/javascript" src="/Template/mobile/new/Static/js/touchslider.dev.js"></script>
    <script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/js/mobile_common.js"></script>
</head>
<style>
    body{
        padding: 0px 10px
    }
    section img{
        width: 100%
    }
</style>
<body>
    <header>
        <p><?php echo ($article["title"]); ?></p>
    </header>
    <article>
        <span class="layui-breadcrumb" lay-separator="—">
        <a href="javascript:;"><?php echo (date('Y-m-d H:i:s',$article["add_time"])); ?></a>
        <a href="javascript:;">绵州学车</a>
        </span>
    </article>
    <section>
        <?php echo (htmlspecialchars_decode($article["content"])); ?> 
    </section>
    <footer>
        <span class="layui-breadcrumb" lay-separator="—">
        <a href="javascript:;">阅读量(<?php echo ($article["click"]); ?>)</a>
        </span>
    </footer>
</body>

</html>