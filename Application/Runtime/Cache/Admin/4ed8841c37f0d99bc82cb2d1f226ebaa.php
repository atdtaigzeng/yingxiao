<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>后台登陆</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <style>#imgVerify{width: 120px;margin: 0 auto; text-align: center;display: block;}	</style>
  </head>
  <body class="login-page">
    <div class="login-box ma_t_cm">
    
<?php if(isset($message)) {?>    
      <!--处理成功-->
      <div class="login-box-body">
        <h4 class="login-box-msg ver_cm"><span class="glyphicon glyphicon-ok ver_cm"></span> <?php echo($message); ?></h4>
          <a href="javascript:void(0);">页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b></a><br /><br />  
          <a href="/" target="_parent">网站前台</a>
          <a href="/index.php?m=Admin&c=Index&a=index" target="_parent">管理员后台</a>

      </div>      
<?php }else{?>     
      <!--处理失败-->
       <div class="login-box-body">
        <h4 class="login-box-msg ver_cm"><span class="glyphicon glyphicon-remove ver_cm"></span> <?php echo($error); ?></h4>
          <a href="javascript:void(0);">页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b></a><br /><br />
          <a href="/" target="_parent">网站前台</a>
          <a href="/index.php?m=Admin&c=Index&a=index" target="_parent">管理员后台</a>
      </div>
<?php }?>      
	    <div class="margin text-center">
	        <div class="copyright">
	            <?php echo date('Y');?> &copy; <a href="#"> v1.0</a>
	            <!-- <br/>
	            <a href="#">深圳搜豹网络有限公司</a>出品 -->
	        </div>
	    </div>
    </div><!-- /.login-box -->

<script type="text/javascript">

(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();

</script>    
  </body>
</html>