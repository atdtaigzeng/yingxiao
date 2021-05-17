<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: IT宇宙人 2015-08-10 $
 */ 
 
/**
 * tpshop检验登陆
 * @param
 * @return bool
 */
function is_login(){
    if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0){
        return $_SESSION['admin_id'];
    }else{
        return false;
    }
}
/**
 * 获取用户信息
 * @param $user_id_or_name  用户id 邮箱 手机 第三方id
 * @param int $type  类型 0 user_id查找 1 邮箱查找 2 手机查找 3 第三方唯一标识查找
 * @param string $oauth  第三方来源
 * @return mixed
 */
function get_user_info($user_id_or_name,$type = 0,$oauth=''){
    $map = array();
    if($type == 0)
        $map['user_id'] = $user_id_or_name;
    if($type == 1)
        $map['email'] = $user_id_or_name;
    if($type == 2)
        $map['mobile'] = $user_id_or_name;
    if($type == 3){
        $map['openid'] = $user_id_or_name;
        $map['oauth'] = $oauth;
    }
    $user = M('users')->where($map)->find();
    return $user;
}

/**
 * 更新会员等级,折扣，消费总额
 * @param $user_id  用户ID
 * @return boolean
 */
function update_user_level($user_id){
    $level_info = M('user_level')->order('level_id')->select();
    $total_amount = M('order')->where("user_id=$user_id AND pay_status=1 and order_status not in (3,5)")->sum('order_amount');
    if($level_info){
    	foreach($level_info as $k=>$v){
    		if($total_amount >= $v['amount']){
    			$level = $level_info[$k]['level_id'];
    			$discount = $level_info[$k]['discount']/100;
    		}
    	}
    	$user = session('user');
    	$updata['total_amount'] = $total_amount;//更新累计修复额度
    	//累计额度达到新等级，更新会员折扣
    	if(isset($level) && $level>$user['level']){
    		$updata['level'] = $level;
    		$updata['discount'] = $discount;	
    	}
    	M('users')->where("user_id=$user_id")->save($updata);
    }
}

/**
 *  商品缩略图 给于标签调用 拿出商品表的 original_img 原始图来裁切出来的
 * @param type $goods_id  商品id
 * @param type $width     生成缩略图的宽度
 * @param type $height    生成缩略图的高度
 */
function goods_thum_images($goods_id,$width,$height){

     if(empty($goods_id))
		 return '';
    //判断缩略图是否存在
    $path = "Public/upload/goods/thumb/$goods_id/";
    $goods_thumb_name ="goods_thumb_{$goods_id}_{$width}_{$height}";
  
    // 这个商品 已经生成过这个比例的图片就直接返回了
    if(file_exists($path.$goods_thumb_name.'.jpg'))  return '/'.$path.$goods_thumb_name.'.jpg'; 
    if(file_exists($path.$goods_thumb_name.'.jpeg')) return '/'.$path.$goods_thumb_name.'.jpeg'; 
    if(file_exists($path.$goods_thumb_name.'.gif'))  return '/'.$path.$goods_thumb_name.'.gif'; 
    if(file_exists($path.$goods_thumb_name.'.png'))  return '/'.$path.$goods_thumb_name.'.png'; 
        
    $original_img = M('Goods')->where("goods_id = $goods_id")->getField('original_img');
    if(empty($original_img)) return '';
    
    $original_img = '.'.$original_img; // 相对路径
    if(!file_exists($original_img)) return '';

    $image = new \Think\Image();
    $image->open($original_img);
        
    $goods_thumb_name = $goods_thumb_name. '.'.$image->type();
    //生成缩略图
    if(!is_dir($path)) 
        mkdir($path,0777,true);
    
    //参考文章 http://www.mb5u.com/biancheng/php/php_84533.html  改动参考 http://www.thinkphp.cn/topic/13542.html
    $image->thumb($width, $height,2)->save($path.$goods_thumb_name,NULL,100); //按照原图的比例生成一个最大为$width*$height的缩略图并保存
    
    //图片水印处理
    $water = tpCache('water');
    if($water['is_mark']==1){
    	$imgresource = './'.$path.$goods_thumb_name;
    	if($width>$water['mark_width'] && $height>$water['mark_height']){
    		if($water['mark_type'] == 'img'){
    			$image->open($imgresource)->water(".".$water['mark_img'],$water['sel'],$water['mark_degree'])->save($imgresource);
    		}else{
    		    //检查字体文件是否存在
    			if(file_exists('./zhjt.ttf')){
    				$image->open($imgresource)->text($water['mark_txt'],'./zhjt.ttf',20,'#000000',$water['sel'])->save($imgresource);
    			}
    		}
    	}
    }
    return '/'.$path.$goods_thumb_name;
}

/**
 * 商品相册缩略图
 */
function get_sub_images($sub_img,$goods_id,$width,$height){
	//判断缩略图是否存在
	$path = "Public/upload/goods/thumb/$goods_id/";
	$goods_thumb_name ="goods_sub_thumb_{$sub_img['img_id']}_{$width}_{$height}";
	//这个缩略图 已经生成过这个比例的图片就直接返回了
	if(file_exists($path.$goods_thumb_name.'.jpg'))  return '/'.$path.$goods_thumb_name.'.jpg';
	if(file_exists($path.$goods_thumb_name.'.jpeg')) return '/'.$path.$goods_thumb_name.'.jpeg';
	if(file_exists($path.$goods_thumb_name.'.gif'))  return '/'.$path.$goods_thumb_name.'.gif';
	if(file_exists($path.$goods_thumb_name.'.png'))  return '/'.$path.$goods_thumb_name.'.png';
	
	$original_img = '.'.$sub_img['image_url']; //相对路径
	if(!file_exists($original_img)) return '';
	
	$image = new \Think\Image();
	$image->open($original_img);
	
	$goods_thumb_name = $goods_thumb_name. '.'.$image->type();
	// 生成缩略图
	if(!is_dir($path))
		mkdir($path,777,true);
	$image->thumb($width, $height,2)->save($path.$goods_thumb_name,NULL,100); //按照原图的比例生成一个最大为$width*$height的缩略图并保存
	return '/'.$path.$goods_thumb_name;
}

/**
 * 刷新商品库存, 如果商品有设置规格库存, 则商品总库存 等于 所有规格库存相加
 * @param type $goods_id  商品id
 */
function refresh_stock($goods_id){
    $count = M("SpecGoodsPrice")->where("goods_id = $goods_id")->count();
    if($count == 0) return false; // 没有使用规格方式 没必要更改总库存

    $store_count = M("SpecGoodsPrice")->where("goods_id = $goods_id")->sum('store_count');
    M("Goods")->where("goods_id = $goods_id")->save(array('store_count'=>$store_count)); // 更新商品的总库存
}

/**
 * 根据 order_goods 表扣除商品库存
 * @param type $order_id  订单id
 */
function minus_stock($order_id){
    $orderGoodsArr = M('OrderGoods')->where("order_id = $order_id")->select();
    foreach($orderGoodsArr as $key => $val)
    {
        // 有选择规格的商品
        if(!empty($val['spec_key']))
        {   // 先到规格表里面扣除数量 再重新刷新一个 这件商品的总数量
            M('SpecGoodsPrice')->where("goods_id = {$val['goods_id']} and `key` = '{$val['spec_key']}'")->setDec('store_count',$val['goods_num']);
            refresh_stock($val['goods_id']);
        }else{
            M('Goods')->where("goods_id = {$val['goods_id']}")->setDec('store_count',$val['goods_num']); // 直接扣除商品总数量
        }
        M('Goods')->where("goods_id = {$val['goods_id']}")->setInc('sales_sum',$val['goods_num']); // 增加商品销售量
        //更新活动商品购买量
        if($val['prom_type']==1 || $val['prom_type']==2){
        	$prom = get_goods_promotion($val['goods_id']);
        	if($prom['is_end']==0){
        		$tb = $val['prom_type']==1 ? 'flash_sale' : 'group_buy';
        		M($tb)->where("id=".$val['prom_id'])->setInc('buy_num',$val['goods_num']);
        		M($tb)->where("id=".$val['prom_id'])->setInc('order_num');
        	}
        }
    }
}

/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject   邮件标题
 * @param string $content   邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
function send_email($to,$subject='',$content=''){
    require_once THINK_PATH.'Library/Vendor/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $config = tpCache('smtp');
	$mail->CharSet  = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //调试输出格式
	//$mail->Debugoutput = 'html';
    //smtp服务器
    $mail->Host = $config['smtp_server'];
    //端口 - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];
	
	if($mail->Port === 465) $mail->SMTPSecure = 'ssl';// 使用安全协议
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //用户名
    $mail->Username = $config['smtp_user'];
    //密码
    $mail->Password = $config['smtp_pwd'];
    //Set who the message is to be sent from
    $mail->setFrom($config['smtp_user']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if(is_array($to)){
    	foreach ($to as $v){
    		$mail->addAddress($v);
    	}
    }else{
    	$mail->addAddress($to);
    }

    $mail->isHTML(true);// send as HTML
    //标题
    $mail->Subject = $subject;
    //HTML内容转换
    $mail->msgHTML($content);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body';
    //添加附件
    //$mail->addAttachment('images/phpmailer_mini.png');
    //send the message, check for errors
    return $mail->send();
}

/**
 * 发送短信
 * @param $mobile  手机号码
 * @param $content  内容
 * @return bool

function sendSMS($mobile,$content)
{
    $config = F('sms','',TEMP_PATH);
    $http = $config['sms_url'];			//短信接口
    $uid = $config['sms_user'];			//用户账号
    $pwd = $config['sms_pwd'];			//密码
    $mobileids = $mobile;         		//号码发送状态接收唯一编号
    $data = array
    (
        'uid'=>$uid,					//用户账号
        'pwd'=>md5($pwd.$uid),			//MD5位32密码,密码和用户名拼接字符
        'mobile'=>$mobile,				//号码，以英文逗号隔开
        'content'=>$content,			//内容
        'mobileids'=>$mobileids,
    );
    //即时发送
    $res = httpRequest($http,'POST',$data);//POST方式提交
    $stat = strpos($res,'stat=100');
    if($stat){
        return true;
    }else{
        return false;
    }
}
 */
//    /**
//     * 发送短信
//     * @param $mobile  手机号码
//     * @param $code    验证码
//     * @return bool    短信发送成功返回true失败返回false
//     */
function sendSMS($mobile, $code)
{
    //时区设置：亚洲/上海
    date_default_timezone_set('Asia/Shanghai');
    //这个是你下面实例化的类
    vendor('Alidayu.TopClient');
    //这个是topClient 里面需要实例化一个类所以我们也要加载 不然会报错
    vendor('Alidayu.ResultSet');
    //这个是成功后返回的信息文件
    vendor('Alidayu.RequestCheckUtil');
    //这个是错误信息返回的一个php文件
    vendor('Alidayu.TopLogger');
    //这个也是你下面示例的类
    vendor('Alidayu.AlibabaAliqinFcSmsNumSendRequest');

    $c = new \TopClient;
    $config =  tpCache('sms');
    //短信内容：公司名/名牌名/产品名
    $product = $config['sms_product'];
    //App Key的值 这个在开发者控制台的应用管理点击你添加过的应用就有了
    $c->appkey = $config['sms_appkey'];
    //App Secret的值也是在哪里一起的 你点击查看就有了
    $c->secretKey = $config['sms_secretKey'];
    //这个是用户名记录那个用户操作
    $req = new \AlibabaAliqinFcSmsNumSendRequest;
    //代理人编号 可选
    $req->setExtend("123456");
    //短信类型 此处默认 不用修改
    $req->setSmsType("normal");
    //短信签名 必须
    //$req->setSmsFreeSignName("注册验证");
    $req->setSmsFreeSignName($config['sms_product']);
    //短信模板 必须
    $req->setSmsParam("{\"code\":\"$code\",\"product\":\"$product\"}");
    //短信接收号码 支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，
    $req->setRecNum("$mobile");
    //短信模板ID，传入的模板必须是在阿里大鱼“管理中心-短信模板管理”中的可用模板。
    $req->setSmsTemplateCode($config['sms_templateCode']); // templateCode
    
    //error_log(print_r($config, 1), 3, "./messageconfig");
    
    $c->format='json'; 
    //发送短信
    $resp = $c->execute($req);
    //短信发送成功返回True，失败返回false
    //if (!$resp)
    if ($resp && $resp->result)   // if($resp->result->success == true)
    {
        // 从数据库中查询是否有验证码
        $data = M('sms_log')->where("code = '$code' and add_time > ".(time() - 60*60))->find();
        // 没有就插入验证码,供验证用
        empty($data) && M('sms_log')->add(array('mobile' => $mobile, 'code' => $code, 'add_time' => time(), 'session_id' => SESSION_ID));
        return true;        
    }
    else 
    {
        return false;
    }
}

/**
 * 查询快递
 * @param $postcom  快递公司编码
 * @param $getNu  快递单号
 * @return array  物流跟踪信息数组
 */
function queryExpress($postcom , $getNu) {
    $url = "http://wap.kuaidi100.com/wap_result.jsp?rand=".time()."&id={$postcom}&fromWeb=null&postid={$getNu}";
    //$resp = httpRequest($url,'GET');
    $resp = file_get_contents($url);
    if (empty($resp)) {
        return array('status'=>0, 'message'=>'物流公司网络异常，请稍后查询');
    }
    preg_match_all('/\\<p\\>&middot;(.*)\\<\\/p\\>/U', $resp, $arr);
    if (!isset($arr[1])) {
        return array( 'status'=>0, 'message'=>'查询失败，参数有误' );
    }else{
        foreach ($arr[1] as $key => $value) {
            $a = array();
            $a = explode('<br /> ', $value);
            $data[$key]['time'] = $a[0];
            $data[$key]['context'] = $a[1];
        }     
        return array( 'status'=>1, 'message'=>'ok','data'=> array_reverse($data));
    }
}

/**
 * 获取某个商品分类的 儿子 孙子  重子重孙 的 id
 * @param type $cat_id
 */
function getCatGrandson ($cat_id)
{
    $GLOBALS['catGrandson'] = array();
    $GLOBALS['category_id_arr'] = array();
    // 先把自己的id 保存起来
    $GLOBALS['catGrandson'][] = $cat_id;
    // 把整张表找出来
    $GLOBALS['category_id_arr'] = M('GoodsCategory')->cache(true,TPSHOP_CACHE_TIME)->getField('id,parent_id');
    // 先把所有儿子找出来
    $son_id_arr = M('GoodsCategory')->where("parent_id = $cat_id")->cache(true,TPSHOP_CACHE_TIME)->getField('id',true);
    foreach($son_id_arr as $k => $v)
    {
        getCatGrandson2($v);
    }
    return $GLOBALS['catGrandson'];
}

/**
 * 获取某个文章分类的 儿子 孙子  重子重孙 的 id
 * @param type $cat_id
 */
function getArticleCatGrandson ($cat_id)
{
    $GLOBALS['ArticleCatGrandson'] = array();
    $GLOBALS['cat_id_arr'] = array();
    // 先把自己的id 保存起来
    $GLOBALS['ArticleCatGrandson'][] = $cat_id;
    // 把整张表找出来
    $GLOBALS['cat_id_arr'] = M('ArticleCat')->getField('cat_id,parent_id');
    // 先把所有儿子找出来
    $son_id_arr = M('ArticleCat')->where("parent_id = $cat_id")->getField('cat_id',true);
    foreach($son_id_arr as $k => $v)
    {
        getArticleCatGrandson2($v);
    }
    return $GLOBALS['ArticleCatGrandson'];
}

/**
 * 递归调用找到 重子重孙
 * @param type $cat_id
 */
function getCatGrandson2($cat_id)
{
    $GLOBALS['catGrandson'][] = $cat_id;
    foreach($GLOBALS['category_id_arr'] as $k => $v)
    {
        // 找到孙子
        if($v == $cat_id)
        {
            getCatGrandson2($k); // 继续找孙子
        }
    }
}


/**
 * 递归调用找到 重子重孙
 * @param type $cat_id
 */
function getArticleCatGrandson2($cat_id)
{
    $GLOBALS['ArticleCatGrandson'][] = $cat_id;
    foreach($GLOBALS['cat_id_arr'] as $k => $v)
    {
        // 找到孙子
        if($v == $cat_id)
        {
            getArticleCatGrandson2($k); // 继续找孙子
        }
    }
}

/**
 * 查看某个用户购物车中商品的数量
 * @param type $user_id
 * @param type $session_id
 * @return type 购买数量
 */
function cart_goods_num($user_id = 0,$session_id = '')
{
    $where = " session_id = '$session_id' ";
    $user_id && $where .= " or user_id = $user_id ";
    // 查找购物车数量
    $cart_count =  M('Cart')->where($where)->sum('goods_num');
    $cart_count = $cart_count ? $cart_count : 0;
    return $cart_count;
}

/**
 * 获取商品库存
 * @param type $goods_id 商品id
 * @param type $key  库存 key
 */
function getGoodNum($goods_id,$key)
{
    if(!empty($key))
        return  M("SpecGoodsPrice")->where("goods_id = $goods_id and `key` = '$key'")->getField('store_count');
    else
        return  M("Goods")->where("goods_id = $goods_id")->getField('store_count');
}
 
/**
 * 获取缓存或者更新缓存
 * @param string $config_key 缓存文件名称
 * @param array $data 缓存数据  array('k1'=>'v1','k2'=>'v3')
 * @return array or string or bool
 */
function tpCache($config_key,$data = array()){
    $param = explode('.', $config_key);
    if(empty($data)){
        //如$config_key=shop_info则获取网站信息数组
        //如$config_key=shop_info.logo则获取网站logo字符串
        $config = F($param[0],'',TEMP_PATH);//直接获取缓存文件
        if(empty($config)){
            //缓存文件不存在就读取数据库
            $res = D('config')->where("inc_type='$param[0]'")->select();
            if($res){
                foreach($res as $k=>$val){
                    $config[$val['name']] = $val['value'];
                }
                F($param[0],$config,TEMP_PATH);
            }
        }
        if(count($param)>1){
            return $config[$param[1]];
        }else{
            return $config;
        }
    }else{
        //更新缓存
        $result =  D('config')->where("inc_type='$param[0]'")->select();
        if($result){
            foreach($result as $val){
                $temp[$val['name']] = $val['value'];
            }
            foreach ($data as $k=>$v){
                $newArr = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
                if(!isset($temp[$k])){
                    M('config')->add($newArr);//新key数据插入数据库
                }else{
                    if($v!=$temp[$k])
                        M('config')->where("name='$k'")->save($newArr);//缓存key存在且值有变更新此项
                }
            }
            //更新后的数据库记录
            $newRes = D('config')->where("inc_type='$param[0]'")->select();
            foreach ($newRes as $rs){
                $newData[$rs['name']] = $rs['value'];
            }
        }else{
            foreach($data as $k=>$v){
                $newArr[] = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
            }
            M('config')->addAll($newArr);
            $newData = $data;
        }
        return F($param[0],$newData,TEMP_PATH);
    }
}

/**
 * 记录帐户变动
 * @param   int     $user_id        用户id
 * @param   float   $user_money     可用余额变动
 * @param   int     $pay_points     消费积分变动
 * @param   string  $desc    变动说明
 * @param   float   distribut_money 分佣金额
 * @return  bool
 */
function accountLog($user_id, $user_money = 0,$pay_points = 0,$coupon_id,$coupon_price, $desc = '',$distribut_money = 0){
    /* 插入帐户变动记录 */
    $account_log = array(
        'user_id'       => $user_id,
        'user_money'    => $user_money,
        'pay_points'    => $pay_points,
        'change_time'   => time(),
        'desc'   => $desc,
    );
    /* 更新用户信息 */
    $sql = "UPDATE __PREFIX__users SET user_money = user_money + $user_money," .
        " pay_points = pay_points + $pay_points, distribut_money = distribut_money + $distribut_money WHERE user_id = $user_id";
    /*更新抵用券信息*/
    if($coupon_id != null && $coupon_price != null){
    $sql2 = "UPDATE __PREFIX__coupon_list SET coupon_money = coupon_money - $coupon_price WHERE  id = $coupon_id ";
    D('coupon_list')->execute($sql2);
    }
    if( D('users')->execute($sql)){
    	M('account_log')->add($account_log);
        return true;
    }else{
        return false;
    }
}

/**
 * 订单操作日志
 * 参数示例
 * @param type $order_id  订单id
 * @param type $action_note 操作备注
 * @param type $status_desc 操作状态  提交订单, 付款成功, 取消, 等待收货, 完成
 * @param type $user_id  用户id 默认为管理员
 * @return boolean
 */
function logOrder($order_id,$action_note,$status_desc,$user_id = 0)
{
    $status_desc_arr = array('提交订单', '付款成功', '取消', '等待收货', '完成','退货');
    // if(!in_array($status_desc, $status_desc_arr))
    // return false;

    $order = M('order')->where("order_id = $order_id")->find();
    $action_info = array(
        'order_id'        =>$order_id,
        'action_user'     =>$user_id,
        'order_status'    =>$order['order_status'],
        'shipping_status' =>$order['shipping_status'],
        'pay_status'      =>$order['pay_status'],
        'action_note'     => $action_note,
        'status_desc'     =>$status_desc, //''
        'log_time'        =>time(),
    );
    return M('order_action')->add($action_info);
}

/*
 * 获取地区列表
 */
function get_region_list(){
    //获取地址列表 缓存读取
    if(!S('region_list')){
        $region_list = M('region')->select();
        $region_list = convert_arr_key($region_list,'id');        
        S('region_list',$region_list);
    }

    return $region_list ? $region_list : S('region_list');
}
/*
 * 获取用户地址列表
 */
function get_user_address_list($user_id){
    $lists = M('user_address')->where(array('user_id'=>$user_id))->select();
    return $lists;
}

/*
 * 获取指定地址信息
 */
function get_user_address_info($user_id,$address_id){
    $data = M('user_address')->where(array('user_id'=>$user_id,'address_id'=>$address_id))->find();
    return $data;
}
/*
 * 获取用户默认收货地址
 */
function get_user_default_address($user_id){
    $data = M('user_address')->where(array('user_id'=>$user_id,'is_default'=>1))->find();
    return $data;
}
/**
 * 获取订单状态的 中文描述名称
 * @param type $order_id  订单id
 * @param type $order     订单数组
 * @return string
 */
function orderStatusDesc($order_id = 0, $order = array())
{
    if(empty($order))
        $order = M('Order')->where("order_id = $order_id")->find();

    // 货到付款
    if($order['pay_code'] == 'cod')
    {
        if(in_array($order['order_status'],array(0,1)) && $order['shipping_status'] == 0)
            return 'WAITSEND'; //'待发货',
    }
    else // 非货到付款
    {
        if($order['pay_status'] == 0 && $order['order_status'] == 0)
            return 'WAITPAY'; //'待支付',
        if($order['pay_status'] == 1 &&  in_array($order['order_status'],array(0,1)) && $order['shipping_status'] != 1)
            return 'WAITSEND'; //'待发货',
    }
    if(($order['shipping_status'] == 1) && ($order['order_status'] == 1))
        return 'WAITRECEIVE'; //'待收货',
    if($order['order_status'] == 2)
        return 'WAITCCOMMENT'; //'待评价',
    if($order['order_status'] == 3)
        return 'CANCEL'; //'已取消',
    if($order['order_status'] == 4)
        return 'FINISH'; //'已完成',
    if($order['order_status'] == 5)
    	return 'CANCELLED'; //'已作废',
    return 'OTHER';
}

/**
 * 获取订单状态的 显示按钮
 * @param type $order_id  订单id
 * @param type $order     订单数组
 * @return array()
 */
function orderBtn($order_id = 0, $order = array())
{
    if(empty($order))
        $order = M('Order')->where("order_id = $order_id")->find();
    /**
     *  订单用户端显示按钮
    去支付     AND pay_status=0 AND order_status=0 AND pay_code ! ="cod"
    取消按钮  AND pay_status=0 AND shipping_status=0 AND order_status=0
    确认收货  AND shipping_status=1 AND order_status=0
    评价      AND order_status=1
    查看物流  if(!empty(物流单号))
     */
    $btn_arr = array(
        'pay_btn' => 0, // 去支付按钮
        'cancel_btn' => 0, // 取消按钮
        'receive_btn' => 0, // 确认收货
        'comment_btn' => 0, // 评价按钮
        'shipping_btn' => 0, // 查看物流
        'return_btn' => 0, // 退货按钮 (联系客服)
    );


    // 货到付款
    if($order['pay_code'] == 'cod')
    {
        if(($order['order_status']==0 || $order['order_status']==1) && $order['shipping_status'] == 0) // 待发货
        {
            $btn_arr['cancel_btn'] = 1; // 取消按钮 (联系客服)
        }
        if($order['shipping_status'] == 1 && $order['order_status'] == 1) //待收货
        {
            $btn_arr['receive_btn'] = 1;  // 确认收货
            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
        }       
    }
    // 非货到付款
    else
    {
        if($order['pay_status'] == 0 && $order['order_status'] == 0) // 待支付
        {
            $btn_arr['pay_btn'] = 1; // 去支付按钮
            $btn_arr['cancel_btn'] = 1; // 取消按钮
        }
        if($order['pay_status'] == 1 && in_array($order['order_status'],array(0,1)) && $order['shipping_status'] == 0) // 待发货
        {
            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
        }
        if($order['pay_status'] == 1 && $order['order_status'] == 1  && $order['shipping_status'] == 1) //待收货
        {
            $btn_arr['receive_btn'] = 1;  // 确认收货
            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
        }
    }
    if($order['order_status'] == 2)
    {
        $btn_arr['comment_btn'] = 1;  // 评价按钮
        $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
    }
    if($order['shipping_status'] != 0)
    {
        $btn_arr['shipping_btn'] = 1; // 查看物流
    }
    if($order['shipping_status'] == 2 && $order['order_status'] == 1) // 部分发货
    {            
        $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
    }
    
    return $btn_arr;
}

/**
 * 给订单数组添加属性  包括按钮显示属性 和 订单状态显示属性
 * @param type $order
 */
function set_btn_order_status($order)
{
    $order_status_arr = C('ORDER_STATUS_DESC');
    $order['order_status_code'] = $order_status_code = orderStatusDesc(0, $order); // 订单状态显示给用户看的
    $order['order_status_desc'] = $order_status_arr[$order_status_code];
    $orderBtnArr = orderBtn(0, $order);
    return array_merge($order,$orderBtnArr); // 订单该显示的按钮
}


/**
 * 支付完成修改订单
 * $order_sn 订单号
 * $pay_status 默认1 为已支付
 */
function update_pay_status($order_sn,$pay_status = 1)
{
	if(stripos($order_sn,'recharge') !== false){
		//用户在线充值
		$count = M('recharge')->where("order_sn = '$order_sn' and pay_status = 0")->count();   // 看看有没已经处理过这笔订单  支付宝返回不重复处理操作
		if($count == 0) return false;
		$order = M('recharge')->where("order_sn = '$order_sn'")->find();
		M('recharge')->where("order_sn = '$order_sn'")->save(array('pay_status'=>1,'pay_time'=>time()));
		accountLog($order['user_id'],$order['account'],0,'会员在线充值');
	}else{
		// 如果这笔订单已经处理过了
		$count = M('order')->where("order_sn = '$order_sn' and pay_status = 0")->count();   // 看看有没已经处理过这笔订单  支付宝返回不重复处理操作
		if($count == 0) return false;
		// 找出对应的订单
		$order = M('order')->where("order_sn = '$order_sn'")->find();
		// 修改支付状态  已支付
		M('order')->where("order_sn = '$order_sn'")->save(array('pay_status'=>1,'pay_time'=>time()));
		// 减少对应商品的库存
		minus_stock($order['order_id']);
		// 给他升级, 根据order表查看消费记录 给他会员等级升级 修改他的折扣 和 总金额
		update_user_level($order['user_id']);
		// 记录订单操作日志
		logOrder($order['order_id'],'订单付款成功','付款成功',$order['user_id']);
		//分销设置
		M('rebate_log')->where("order_id = {$order['order_id']}")->save(array('status'=>1));
		// 成为分销商条件
		$distribut_condition = tpCache('distribut.condition');
		if($distribut_condition == 1){
		    // 购买指定商品付款才可以成为分销商
		    $order_goods = M("order_goods")->where("order_id={$order['order_id']}")->select();
		    $order_goods_number = count($order_goods);//本次购买商品的数量
		    
		    $goods = M('goods');
		    for($i=0; $i<$order_goods_number; $i++){
		        
		        $order_goods_id = $order_goods[$i]['goods_id'];//购买商品的id
		        
		        $distribut_attr = $goods->where("goods_id={$order_goods_id}")->getField("distribut_attr");
		        
		        if( $distribut_attr==2 ){
		            $distribut_data = array(
		                'is_distribut' => 1,
		                'distribut_level' =>2//分销等级
		            );
		            break;//防止购买的商品中有一级分销商品将其覆盖
		        }elseif( $distribut_attr==1 ){
		            
		            $distribut_data = array(
		                'is_distribut' => 1,
		                'distribut_level' =>1//分销等级
		            );
		        }elseif( $distribut_attr==3 ){
		            //升级
		             $distribut_data = array(
		                'distribut_level' =>2//分销等级
		            );
		        }
		        
		    }
		    
		    
		    if($distribut_data){
		        M('users')->where("user_id = {$order['user_id']}")->save($distribut_data);
		    }
		    
		}  
		
		//这里需要添加锁机制
		$fp = fopen('./Public/line.lock','r');
		flock($fp,LOCK_EX);//排他锁
		line_prize($order['order_id'], $order['user_id']);//队列排奖
		
		flock($fp,LOCK_UN);//释放锁
		fclose($fp);
		
	}

}


    /**
     * 队列排奖与学车卷的发放
     */
     function line_prize($order_id,$user_id){
         
         $goods = M("order_goods")->join("__GOODS__ on __ORDER_GOODS__.goods_id=__GOODS__.goods_id")->where("order_id={$order_id}")->select();
         $goods_num = count($goods);//购买商品的种类数
         
         for($i=0; $i<$goods_num; $i++){
             
             if($goods[$i]['is_line_prize']==1){//队列排奖商品
                 
                 //赠送学车卷
                 send_coupon_car($user_id,$order_id,$goods[$i]['deposit_money'],$goods[$i]['goods_num']);
                 
                 //先判断该用户是否出队
                 /* $prize_line = M('prize_line');
                 
                 if( !$user_is_out = $prize_line->where("uid={$user_id}")->order("line_id desc")->limit(1)->getField("is_out") ){
                     //没有出局，不让其加入队列
                     return;
                 }
                 
                 
                 //加入排奖队列
                 if( $line_id = join_line($user_id,$goods[$i]['deposit_money']) ){
                     
                     $p3 = $prize_line->where("line_id={$line_id}")->getField("p3");
                     //出局用户判断
                     if($p3>0){
                         $p3_count = $prize_line->where("p3={$p3}")->count();
                         
                         //error_log(print_r($p3_count, 1), 3, "./pc_count");
                         
                         if($p3_count==27 || $p3_count>27){
                             
                             $is_out['is_out'] = 1;
                             //p3出局
                             if( $prize_line->where("line_id={$p3}")->save($is_out) ){
                                 // 如果有微信公众号 则推送一条消息到微信
                                 $uid = $prize_line->where("line_id={$p3}")->field('uid')->find();
                                 $uid = (int)$uid['uid'];
                                 
                                 $user = M('users')->where("user_id = {$uid}")->find();
                                 if($user['oauth']== 'weixin')
                                 {
                                     $wx_user = M('wx_user')->find();
                                     $jssdk = new \Mobile\Logic\Jssdk($wx_user['appid'],$wx_user['appsecret']);
                                     $wx_content = "排奖队列已出局，您可以再次购买相关产品加入队列！";
                                     $jssdk->push_msg($user['openid'],$wx_content);
                                 }
                             }
                             
                             
                         }
                     }
                     
                     //如果成功加入排奖队列,进行奖金分配
                     share_money($line_id,$order_id);
                 } */
             }
             
         }
         
     }
     
     /**
      * 发放学车卷
      */
     function send_coupon_car($user_id,$order_id,$money,$goods_num){
         $send_time = time();
         $use_time = $send_time + 3*365*24*3600;
         
         for($i=0; $i<$goods_num; $i++){
             
             $coupon = array(
                 'money' => $money,//学车卷金额
                 'uid' => $user_id,
                 'order_id' => $order_id,//对应的订单
                 'use_time' => $use_time,
                 'send_time' => $send_time
             );
              
             if( M('coupon_car')->add($coupon) ){
                  
                 // 如果有微信公众号 则推送一条消息到微信
                 $user = M('users')->where("user_id = {$user_id}")->find();
                 if($user['oauth']== 'weixin')
                 {
                     $wx_user = M('wx_user')->find();
                     $jssdk = new \Mobile\Logic\Jssdk($wx_user['appid'],$wx_user['appsecret']);
                     $wx_content = "您已获得价值{$money}元的学车卷，可进入个人中心查看！";
                     $jssdk->push_msg($user['openid'],$wx_content);
                 }
             }
             
         }
         
     }
     
     
     function join_line($user_id,$money){
         
         $line = M('prize_line');
         //先查询队列中的最后一名用户
         if( $user = $line->where(1)->order("line_id desc")->limit(1)->find() ){
             
             //找到该用户的line_id,p1,p2,p3
             $line_id=(int)$user['line_id']; $p1=(int)$user['p1']; $p2=(int)$user['p2']; $p3=(int)$user['p3'];
             
             if( $p1!=0 ){
                 //查询出的最后一个用户有父级,先找到该父级的信息
                 $parent = $line->where("line_id={$p1}")->find();
                 $child_num = (int)$parent['child_num']; //该父级的孩子数
                 
                 if($child_num<3){
                     //孩子小于3个，继续增加
                     $parent_id = $p1;
                     $data = array(
                         'uid' => $user_id,
                         'p1' => $parent_id,
                         'p2' => $p2,
                         'p3' => $p3,
                         'addtime' => time(),
                         'line_money' => $money
                     );
                 }else{
                     //孩子数达到3个，为下一用户增加孩子,此时p1为下一父级的line_id,p2为其p1,p3为其p2
                     $parent_id = $p1 + 1;
                     $next_parent = $line->where("line_id={$parent_id}")->find();
                     
                     $data = array(
                         'uid' => $user_id,
                         'p1' => $parent_id,
                         'p2' => $next_parent['p1'],
                         'p3' => $next_parent['p2'],
                         'addtime' => time(),
                         'line_money' => $money
                     );
                     
                 }
                 
                 if( $new_line_id = $line->add($data) ){
                     
                     $line->where("line_id={$parent_id}")->setInc("child_num");//为父级的孩子数加一
                     return $new_line_id;
                 }
                 
             }else{
                 //此时p1为0,表示查询出来的用户为最高级
                 $data = array(
                     'uid' => $user_id,
                     'p1'  => $line_id,
                     'addtime' => time(),
                     'line_money' => $money
                 );
                 
                 if( $new_line_id = $line->add($data) ){
                     
                     $line->where("line_id={$line_id}")->setInc("child_num");//为父级的孩子数加一
                     return $new_line_id;
                 }
             }
             
             
         }else{
             //第一个进入的用户
             $data['uid'] = $user_id;
             $data['addtime'] = time();
             $data['line_money'] = $money;
             if( $line->add($data) ){
                 //return true;
             }
         }
         
     }
     
     
     /**
      * 奖金分配
      */
    function share_money($line_id,$order_id){
        $line = M('prize_line');
        
        $share_line = $line->where("line_id={$line_id}")->find();
        $p1=(int)$share_line['p1']; $p2=(int)$share_line['p2']; $p3=(int)$share_line['p3'];
        $line_money = $share_line['line_money'];
        $join_uid = (int)$share_line['uid'];
        
        $users = M('users');
        $first_leader = $users->where("user_id={$join_uid}")->getField("first_leader");
        
        //1、查询p1的uid
        if( $p1_uid = $line->where("line_id={$p1}")->getField("uid") ){
            //判断join_uid和p1_uid是否是直推关系
            
            if($first_leader == $p1_uid){
                //是直推关系
                if($line_money==680){
                    $share_p1 = 100;
                }else if($line_money==980){
                    $share_p1 = 148;
                }
            }else{
                //不是直推关系
                if($line_money==680){
                    $share_p1 = 100*0.6;
                }else if($line_money==980){
                    $share_p1 = 148*0.6;
                }
                
            }
            
            //为p1账户增加余额
            $res = $users->where("user_id={$p1_uid}")->field("user_money,distribut_money,oauth,openid")->find();
            $res['user_money'] = $share_p1+$res['user_money'];
            $res['distribut_money'] = $share_p1+$res['distribut_money'];
            
            if( $users->where("user_id={$p1_uid}")->save($res) ){
                
                prize_log($p1_uid,$order_id,1,$share_p1);//分钱记录
                if($res['oauth']== 'weixin')
                {
                    $content_message = "一级佣金到账";
                    $share_p1 = "+".$share_p1;
                    //账户资金变动提醒
                    sendTempMessage($res['openid'],$share_p1,$res['user_money'],$content_message);
                }
            }
            
        }
        
        //2、查询p2的uid
        if( $p2_uid = $line->where("line_id={$p2}")->getField("uid") ){
            
            
            if($first_leader == $p2_uid){
                //是直推关系
                if($line_money==680){
                    $share_p2 = 150;
                }else if($line_money==980){
                    $share_p2 = 248;
                }
            }else{
                //不是直推关系
                if($line_money==680){
                    $share_p2 = 150*0.6;
                }else if($line_money==980){
                    $share_p2 = 248*0.6;
                }
            
            }
            
            //为p2账户增加余额
            $res = $users->where("user_id={$p2_uid}")->field("user_money,distribut_money,oauth,openid")->find();
            $res['user_money'] = $share_p2+$res['user_money'];
            $res['distribut_money'] = $share_p2+$res['distribut_money'];
            
            if( $users->where("user_id={$p2_uid}")->save($res) ){
                
                prize_log($p2_uid,$order_id,2,$share_p2);//分钱记录
                //账户资金变动提醒
                if($res['oauth']== 'weixin')
                {
                    $content_message = "二级佣金到账";
                    $share_p2 = "+".$share_p2;
                    sendTempMessage($res['openid'],$share_p2,$res['user_money'],$content_message);
                }
                
            }
            
        
        }
        
        //3、查询p3的uid
        if( $p3_uid = $line->where("line_id={$p3}")->getField("uid") ){
            
            if($first_leader == $p3_uid){
                //是直推关系
                if($line_money==680){
                    $share_p3 = 200;
                }else if($line_money==980){
                    $share_p3 = 298;
                }
            }else{
                //不是直推关系
                if($line_money==680){
                    $share_p3 = 200*0.6;
                }else if($line_money==980){
                    $share_p3 = 298*0.6;
                }
            
            }
            
            
            //为p3账户增加余额
            $res = $users->where("user_id={$p3_uid}")->field("user_money,distribut_money,oauth,openid")->find();
            $res['user_money'] = $share_p3+$res['user_money'];
            $res['distribut_money'] = $share_p3+$res['distribut_money'];
            
            if( $users->where("user_id={$p3_uid}")->save($res) ){
                
                prize_log($p3_uid,$order_id,3,$share_p3);//分钱记录
                //账户资金变动提醒
                if($res['oauth']== 'weixin')
                {
                    $content_message = "三级佣金到账";
                    $share_p3 = "+".$share_p3;
                    sendTempMessage($res['openid'],$share_p3,$res['user_money'],$content_message);
                }
            }
        
        }
        
        
        //M()->commit();
        
    }
    
    function prize_log($uid,$order_id,$grade,$share_money){
        
        $data = array(
            'uid' => $uid,
            'order_id' => $order_id,
            'grade' => $grade,
            'add_time' => time(),
            'share_money' => $share_money
        );
        
        M('prize_log')->add($data);
    }
    
    /**
     * 模板消息推送
     */
    function sendTempMessage($openid,$change_money,$totle_money,$content){
        
        $wx_user = M('wx_user')->find();
        $jssdk = new \Mobile\Logic\Jssdk($wx_user['appid'],$wx_user['appsecret']);
        
        
        //发送提现模板消息
        $template_id = "8CslHvf3fh5bF4kIFmjZp4ga_i5oDoR4RMtMOLFu9rI";
        $change_time = date("Y-m-d H:i:s");
        //账户资金变动提醒data
        $data = array(
            "touser" => $openid,
            "template_id" => $template_id,
            "url" => "",
            "data" => array(
                "first" => array(
                    "value" => urlencode($content),
                    "color" => "#173177"
                ),
                "date" => array(
                    "value" => urlencode($change_time),
                    "color" => "#173176"
                ),
                "adCharge" => array(
                    "value" => urlencode($change_money.'元'),
                    "color" => "#173176"
                ),
                "cashBalance" => array(
                    "value" => urlencode($totle_money.'元'),
                    "color" => "#173176"
                )
        
            )
        
        );
        
        $jssdk->sendTemp($data);
        
    }
    
    



    /**
     * 订单确认收货
     * @param $id   订单id
     */
    function confirm_order($id,$user_id = 0){
        
        $where = "order_id = $id";
        $user_id && $where .= " and user_id = $user_id ";
        
        $order = M('order')->where($where)->find();
        if($order['order_status'] != 1)
            return array('status'=>-1,'msg'=>'该订单不能收货确认');
        
        $data['order_status'] = 2; // 已收货        
        $data['pay_status'] = 1; // 已付款        
        $data['confirm_time'] = time(); // 收货确认时间
        if($order['pay_code'] == 'cod'){
        	$data['pay_time'] = time();
        }
        $row = M('order')->where(array('order_id'=>$id))->save($data);
        if(!$row)        
            return array('status'=>-3,'msg'=>'操作失败');

        order_give($order);// 调用送礼物方法, 给下单这个人赠送相应的礼物
        
        //分销设置
        M('rebate_log')->where("order_id = $id")->save(array('status'=>2,'confirm'=>time()));
               
        return array('status'=>1,'msg'=>'操作成功');
    }

/**
 * 给订单送券送积分 送东西
 */
function order_give($order)
{
	$order_goods = M('order_goods')->where("order_id=".$order['order_id'])->cache(true)->select();
    
	//查找购买商品送优惠券活动
	foreach ($order_goods as $val)
    {
		if($val['prom_type'] == 3)
        {
			$prom = M('prom_goods')->where('type=3 and id='.$val['prom_id'])->find();
			if($prom){
				$coupon = M('coupon')->where("id=".$prom['expression'])->find();//查找优惠券模板

				if($coupon && $coupon['createnum']>0){					                                        
                    $remain = $coupon['createnum'] - $coupon['send_num'];//剩余派发量
                    if($remain > 0)                                            
                    {
                        $data = array('cid'=>$coupon['id'],'type'=>$coupon['type'],'uid'=>$order['user_id'],'send_time'=>time());
                        M('coupon_list')->add($data);
                        M('Coupon')->where("id = {$coupon['id']}")->setInc('send_num'); // 优惠券领取数量加一
                    }
				}
		 	}
		 }
	}
	
	// 如果有微信公众号 则推送一条消息到微信
	if($coupon){
	    $info = M('Coupon')->where("id = {$coupon['id']}")->find();
	    $user = M('users')->where("user_id = {$order['user_id']}")->find();
	    if($user['oauth']== 'weixin')
	    {
	        $wx_user = M('wx_user')->find();
	        $jssdk = new \Mobile\Logic\Jssdk($wx_user['appid'],$wx_user['appsecret']);
	        $wx_content = "您已获得价值{$info['money']}元的优惠卷，可进入个人中心查看！";
	        $jssdk->push_msg($user['openid'],$wx_content);
	    }
	}
	
	
	//查找订单满额送优惠券活动
	$pay_time = $order['pay_time'];
	$prom = M('prom_order')->where("type>1 and end_time>$pay_time and start_time<$pay_time and money<=".$order['order_amount'])->order('money desc')->find();
	if($prom){
		if($prom['type']==3){
			$coupon = M('coupon')->where("id=".$prom['expression'])->find();//查找优惠券模板
			if($coupon){
				if($coupon['createnum']>0){
					$remain = $coupon['createnum'] - $coupon['send_num'];//剩余派发量
                    if($remain > 0)
                    {
                       $data = array('cid'=>$coupon['id'],'type'=>$coupon['type'],'uid'=>$order['user_id'],'send_time'=>time());
                       M('coupon_list')->add($data);           
                       M('Coupon')->where("id = {$coupon['id']}")->setInc('send_num'); // 优惠券领取数量加一
                    }				
				}
			}
		}else if($prom['type']==2){
			accountLog($order['user_id'], 0 , $prom['expression'] ,"订单活动赠送积分");
		}
	}
    

    $points = M('order_goods')->where("order_id = {$order[order_id]}")->sum("give_integral * goods_num");
    $points && accountLog($order['user_id'], 0,$points,"下单赠送积分");
}
/**
* 查看商品是否有活动,根据用户是否有上级进入不同的活动
 * @param goods_id 商品ID
 */
function get_goods_promotion($goods_id,$user_id=0){
    $now = time();
    $goods = M('goods')->where("goods_id=$goods_id")->find();
    $where = "end_time>$now and start_time<$now and id=".$goods['prom_id'];

    $prom['price'] = $goods['shop_price'];
    $prom['prom_type'] = $goods['prom_type'];
    $prom['prom_id'] = $goods['prom_id'];
    $prom['is_end'] = 0;

    if($goods['prom_type'] == 1){//抢购
        $prominfo = M('flash_sale')->where($where)->find();
        if(!empty($prominfo)){
            if($prominfo['goods_num'] == $prominfo['buy_num']){
                $prom['is_end'] = 2;//已售馨
            }else{
                //核查用户购买数量
                $where = "user_id = $user_id and order_status!=3 and  add_time>".$prominfo['start_time']." and add_time<".$prominfo['end_time'];
                $order_id_arr = M('order')->where($where)->getField('order_id',true);
                if($order_id_arr){
                    $goods_num = M('order_goods')->where("prom_id={$goods['prom_id']} and prom_type={$goods['prom_type']} and order_id in (".implode(',', $order_id_arr).")")->sum('goods_num');
                    if($goods_num < $prominfo['buy_limit']){
                        $prom['price'] = $prominfo['price'];
                    }
                }else{
                    $prom['price'] = $prominfo['price'];
                }
            }
        }
    }

    if($goods['prom_type']==2){//团购
        $prominfo = M('group_buy')->where($where)->find();
        if(!empty($prominfo)){
            if($prominfo['goods_num'] == $prominfo['buy_num']){
                $prom['is_end'] = 2;//已售馨
            }else{
                $prom['price'] = $prominfo['price'];
            }
        }
    }
    if($goods['prom_type'] == 3){//优惠促销
        $parse_type = array('0'=>'直接打折','1'=>'减价优惠','2'=>'固定金额出售','3'=>'买就赠优惠券','4'=>'买M件送N件');
        $prominfo = M('prom_goods')->where($where)->find();
        if(!empty($prominfo)){
            if($prominfo['type'] == 0){
                $prom['price'] = $goods['shop_price']*$prominfo['expression']/100;//打折优惠
            }elseif($prominfo['type'] == 1){
                $prom['price'] = $goods['shop_price']-$prominfo['expression'];//减价优惠
            }elseif($prominfo['type']==2){
                $prom['price'] = $prominfo['expression'];//固定金额优惠
            }
        }
    }

    if(!empty($prominfo)){
        $prom['start_time'] = $prominfo['start_time'];
        $prom['end_time'] = $prominfo['end_time'];
    }else{
        $prom['prom_type'] = $prom['prom_id'] = 0 ;//活动已过期
        $prom['is_end'] = 1;//已结束
    }

    if($prom['prom_id'] == 0){
        M('goods')->where("goods_id=$goods_id")->save($prom);
    }
    return $prom;
}
/**
 * 查看订单是否满足条件参加活动
 * @param order_amount 订单应付金额
 */
function get_order_promotion($order_amount){
	$parse_type = array('0'=>'满额打折','1'=>'满额优惠金额','2'=>'满额送倍数积分','3'=>'满额送优惠券','4'=>'满额免运费');
	$now = time();
	$prom = M('prom_order')->where("type<2 and end_time>$now and start_time<$now and money<=$order_amount")->order('money desc')->find();
	$res = array('order_amount'=>$order_amount,'order_prom_id'=>0,'order_prom_amount'=>0);
	if($prom){
		if($prom['type'] == 0){
			$res['order_amount']  = round($order_amount*$prom['expression']/100,2);//满额打折
			$res['order_prom_amount'] = $order_amount - $res['order_amount'] ;
			$res['order_prom_id'] = $prom['id'];
		}elseif($prom['type'] == 1){
			$res['order_amount'] = $order_amount- $prom['expression'];//满额优惠金额
			$res['order_prom_amount'] = $prom['expression'];
			$res['order_prom_id'] = $prom['id'];
		}
	}
	return $res;		
}

/**
 * 计算订单金额
 * @param type $user_id  用户id
 * @param type $order_goods  购买的商品
 * @param type $shipping  物流code
 * @param type $shipping_price 物流费用, 如果传递了物流费用 就不在计算物流费
 * @param type $province  省份
 * @param type $city 城市
 * @param type $district 县
 * @param type $pay_points 积分
 * @param type $user_money 余额
 * @param type $coupon_id  优惠券
 * @param type $couponCode  优惠码
 * @param type $pay_method  购买方式
 */
 
function calculate_price($user_id=0,$order_goods,$shipping_code='',$shipping_price=0,$province=0,$city=0,$district=0,$pay_points=0,$user_money=0,$coupon_id=0,$couponCode='',$pay_method='')
{    
    $cartLogic = new \Home\Logic\CartLogic();               
    $user = M('users')->where("user_id = $user_id")->find();// 找出这个用户
    
    if(empty($order_goods)) 
        return array('status'=>-9,'msg'=>'商品列表不能为空','result'=>'');  
    
    $goods_id_arr = get_arr_column($order_goods,'goods_id');
    $goods_arr = M('goods')->where("goods_id in(".  implode(',',$goods_id_arr).")")->getField('goods_id,weight,market_price,is_free_shipping'); // 商品id 和重量对应的键值对
    
        foreach($order_goods as $key => $val)
        {       
            // 如果传递过来的商品列表没有定义会员价
            if(!array_key_exists('member_goods_price',$val))  
            {
                $user['discount'] = $user['discount'] ? $user['discount'] : 1; // 会员折扣 不能为 0
                $order_goods[$key]['member_goods_price'] = $val['member_goods_price'] = $val['goods_price'] * $user['discount'];
            }
			//如果商品不是包邮的
            if($goods_arr[$val['goods_id']]['is_free_shipping'] == 0)
	            $goods_weight += $goods_arr[$val['goods_id']]['weight'] * $val['goods_num']; //累积商品重量 每种商品的重量 * 数量
				
            $order_goods[$key]['goods_fee'] = $val['goods_num'] * $val['member_goods_price'];    // 小计            
            $order_goods[$key]['store_count']  = getGoodNum($val['goods_id'],$val['spec_key']); // 最多可购买的库存数量
            if($order_goods[$key]['store_count'] <= 0) 
                return array('status'=>-10,'msg'=>$order_goods[$key]['goods_name']."库存不足,请重新下单",'result'=>'');  
            
            $goods_price += $order_goods[$key]['goods_fee']; // 商品总价
            $cut_fee     += $val['goods_num'] * $val['market_price'] - $val['goods_num'] * $val['member_goods_price']; // 共节约
            $anum        += $val['goods_num']; // 购买数量
        }        
        // 优惠券处理操作
        $coupon_price = 0;
        if($coupon_id && $user_id)
        {
            $coupon_price = $cartLogic->getCouponMoney($user_id, $coupon_id,1); // 下拉框方式选择优惠券                    
        }        
        if($couponCode && $user_id)
        {                 
             $coupon_result = $cartLogic->getCouponMoneyByCode($couponCode,$goods_price); // 根据 优惠券 号码获取的优惠券             
             if($coupon_result['status'] < 0) 
               return $coupon_result;
             $coupon_price = $coupon_result['result'];            
        }
        // 处理物流
        if($shipping_price == 0)
        {
            $shipping_price = $cartLogic->cart_freight2($shipping_code,$province,$city,$district,$goods_weight);        
            $freight_free = tpCache('shopping.freight_free'); // 全场满多少免运费
            if($freight_free > 0 && $goods_price >= $freight_free)
               $shipping_price = 0;               
        }
        if($pay_points && ($pay_points > $user['pay_points']))
            return array('status'=>-5,'msg'=>"你的账户可用积分为:".$user['pay_points'],'result'=>''); // 返回结果状态                
        if($user_money  && ($user_money > $user['user_money']))
            return array('status'=>-6,'msg'=>"你的账户可用余额为:".$user['user_money'],'result'=>''); // 返回结果状态
        
        /* if($shipping_code=='totle'){
            //全款支付
            $order_amount = $goods_price + $shipping_price - $coupon_price; // 应付金额 = 商品价格 + 物流费 - 优惠券
            $pay_method = '全款支付';
        }else{
            //定金支付
            $order_amount=100;
            $pay_method = '定金支付';
        } */
        /**
         * 应付金额现在修改为。1,。首先读取该买商品的最大抵用额度并与优惠券的面值进行比较（1）若最大抵用额度小于拥有优惠券的面值
         *则应付金额=商品价格 + 物流费 - 最大抵用额度。
         *优惠券面值则变为：面值 = 原有面值 - 最大抵用额度
         *(2).若最大抵用额度大于拥有优惠券的面值
         *则应付金额 = 商品价格 + 物流费 - 优惠券的面值。
         *该优惠券的状态改变：变为已使用*/
        //获取支付队列商品的总的最大抵用金额，若是定金支付则不能用优惠券
        $offset_arr = M('goods')->where("goods_id in(".  implode(',',$goods_id_arr).")")->getField('offset',true);
        //获取商品支付队列里面商品的购买数量
        $goods_num = get_arr_column($order_goods,'goods_num');
        //计算抵用的总金额
        if(count($offset_arr) == count($goods_num)){
            for($i=0;$i<count($offset_arr);$i++){
                $offset_arr[$i] = $offset_arr[$i]*$goods_num[$i];
            }
         }
        $total_offset = array_sum($offset_arr);
      // $order_amount = $goods_price + $shipping_price - $coupon_price; // 应付金额 = 商品价格 + 物流费 - 优惠券
       $buy_method = "全款支付";//默认全款支付,全款支付抵用券的处理
        //与优惠券的面值进行比较
        if($total_offset >=$coupon_price ){
            $order_amount = $goods_price + $shipping_price - $coupon_price; // 应付金额 = 商品价格 + 物流费 - 优惠券
            $coupon_price = $coupon_price;
        }else{
            $order_amount = $goods_price + $shipping_price - $total_offset;//应付金额=商品价格 + 物流费 - 最大抵用额度。
            $coupon_price = $total_offset;
        }
       if($pay_method){
           //如果有支付方式
           if($pay_method != 'totle'){
               //不是全款支付
               $order_amount = $pay_method - $coupon_price;//应付金额 = 定金 - 优惠券
               $buy_method = "定金支付";
         }
       }
       $pay_points = ($pay_points / tpCache('shopping.point_rate')); // 积分支付 100 积分等于 1块钱                              
       $pay_points = ($pay_points > $order_amount) ? $order_amount : $pay_points; // 假设应付 1块钱 而用户输入了 200 积分 2块钱, 那么就让 $pay_points = 1块钱 等同于强制让用户输入1块钱               
       $order_amount = $order_amount - $pay_points; //  积分抵消应付金额       
      
       $user_money = ($user_money > $order_amount) ? $order_amount : $user_money;  // 余额支付原理等同于积分
       $order_amount = $order_amount - $user_money; //  余额支付抵应付金额
      
       $total_amount = $goods_price + $shipping_price;
           //订单总价  应付金额  物流费  商品总价 节约金额 共多少件商品 积分  余额  优惠券
        $result = array(
            'total_amount'      => $total_amount, // 商品总价
            'order_amount'      => $order_amount, // 应付金额
            'shipping_price'    => $shipping_price, // 物流费
            'buy_method'        => $buy_method,//购买方式
            'goods_price'       => $goods_price, // 商品总价
            'cut_fee'           => $cut_fee, // 共节约多少钱
            'anum'              => $anum, // 商品总共数量
            'integral_money'    => $pay_points,  // 积分抵消金额
            'user_money'        => $user_money, // 使用余额
            'coupon_price'      => $coupon_price,// 优惠券抵消金额
            'order_goods'       => $order_goods, // 商品列表 多加几个字段原样返回
        );
        //var_export($result);
        //exit();
    return array('status'=>1,'msg'=>"计算价钱成功",'result'=>$result); // 返回结果状态
}

/**
 * 获取商品一二三级分类
 * @return type
 */
function get_goods_category_tree(){
	$result = array();
	$cat_list = M('goods_category')->where("is_show = 1")->order('sort_order')->cache(true)->select();//所有分类
	
	foreach ($cat_list as $val){
		if($val['level'] == 2){
			$arr[$val['parent_id']][] = $val;
		}
		if($val['level'] == 3){
			$crr[$val['parent_id']][] = $val;
		}
		if($val['level'] == 1){
			$tree[] = $val;
		}
	}

	foreach ($arr as $k=>$v){
		foreach ($v as $kk=>$vv){
			$arr[$k][$kk]['sub_menu'] = empty($crr[$vv['id']]) ? array() : $crr[$vv['id']];
		}
	}
	
	foreach ($tree as $val){
		$val['tmenu'] = empty($arr[$val['id']]) ? array() : $arr[$val['id']];
		$result[$val['id']] = $val;
	}
	return $result;
}


