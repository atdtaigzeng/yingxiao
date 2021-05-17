<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>tpshop管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
 	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 --
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
    	folder instead of downloading all of them to reduce the load. -->
    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />   
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>    
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   						layer.closeAll();
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }
    
    //全选
    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }   
    
    function get_help(obj){
        layer.open({
            type: 2,
            title: '帮助手册',
            shadeClose: true,
            shade: 0.3,
            area: ['90%', '90%'],
            content: $(obj).attr('data-url'), 
        });
    }
    
    function delAll(obj,name){
    	var a = [];
    	$('input[name*='+name+']').each(function(i,o){
    		if($(o).is(':checked')){
    			a.push($(o).val());
    		}
    	})
    	if(a.length == 0){
    		layer.alert('请选择删除项', {icon: 2});
    		return;
    	}
    	layer.confirm('确认删除？', {btn: ['确定','取消'] }, function(){
    			$.ajax({
    				type : 'get',
    				url : $(obj).attr('data-url'),
    				data : {act:'del',del_id:a},
    				dataType : 'json',
    				success : function(data){
    					if(data == 1){
    						layer.msg('操作成功', {icon: 1});
    						$('input[name*='+name+']').each(function(i,o){
    							if($(o).is(':checked')){
    								$(o).parent().parent().remove();
    							}
    						})
    					}else{
    						layer.msg(data, {icon: 2,time: 2000});
    					}
    					layer.closeAll();
    				}
    			})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);	
    }
    </script>        
  </head>
  <body style="background-color:#ecf0f5;">
 

<div class="wrapper">
    <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>    
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>          
	</ol>
</div>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-list"></i>学车卷列表</h3>
                    </div>

                    <div class="panel-body">
                        <div class="navbar navbar-default">
                            <form class="navbar-form form-inline" action="<?php echo U('Coupon/list_coupon');?>" method="post">

                                <div class="form-group">
                                    <label>使用状态</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">使用状态</option>
                                            <option value="0">未使用</option>
                                            <option value="1">已使用</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                <label>电话号码;</label>
                                    <input name="phone_num" type="text" class="form-control" placeholder="请输入手机号" maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                                </div>
                                <button type="submit" class="btn btn-default">提交</button>


                            </form>
                        </div>
                        <div id="ajax_return">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                        <td class="text-center">用户昵称</td>
                                        <td class="text-center">手机号</td>
                                        <td class="text-center">面额</td>
                                        <td class="text-center">订单ID</td>
                                        <td class="text-center">发放时间</td>
                                        <td class="text-center">使用截止日期</td>
                                        <td class="text-center">是否使用</td>
                                        <td class="text-center">操作</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($coupon_list)): $i = 0; $__LIST__ = $coupon_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="selected[]" value="6">
                                            </td>
                                            <td class="text-center"><?php echo ($list["nickname"]); ?></td>
                                            <td class="text-center"><?php echo ($list["mobile"]); ?></td>
                                            <td class="text-center"><?php echo ($list["money"]); ?></td>
                                            <td class="text-center"><?php echo ($list["order_id"]); ?></td>
                                            <td class="text-center"><?php echo (date('Y-m-d',$list["send_time"])); ?></td>
                                            <td class="text-center"><?php echo (date('Y-m-d',$list["use_time"])); ?></td>
                                            <td class="text-center">
                                                <?php
 if($list['use_time']==0){ echo '未使用'; }else{ echo '已使用'; } ?>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?php echo U('Admin/user/detail',array('id'=>$list['user_id']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="核销"><i class="fa fa-pencil"></i></a>
                                                <a data-url="<?php echo U('Admin/Coupon/del_coupon',array('id'=>$list['id']));?>" onclick="delfun(this)" href="javascript:;" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 text-left"></div>
                            <div class="col-sm-6 text-right"><?php echo ($page); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script>
    $('.send_user').click(function(){
        var url = $(this).attr('data-url');
        layer.open({
            type: 2,
            title: '发放优惠券',
            shadeClose: true,
            shade: 0.5,
            area: ['70%', '85%'],
            content: url,
        });
    });

    function delfun(obj){
        if(confirm('确认删除')){
            $.ajax({
                type : 'post',
                url : $(obj).attr('data-url'),
                dataType : 'json',
                success : function(data){
                    if(data){
                        $(obj).parent().parent().remove();
                    }else{
                        layer.alert('删除失败', {icon: 2});  //alert('删除失败');
                    }
                }
            })
        }
        return false;
    }

</script>
</body>
</html>