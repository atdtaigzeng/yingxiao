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
 * 2015-11-21
 */
namespace Mobile\Controller;

use Home\Logic\UsersLogic;

use Think\Page;
use Think\Verify; 

class DistributController extends MobileBaseController
{

    public $user_id = 0;
    public $user = array();

    /*
    * 初始化操作
    */
    
    
    public function _initialize()
    {
        parent::_initialize();
        if (session('?user')) {
            $user = session('user');
            $user = M('users')->where("user_id = {$user['user_id']}")->find();
            session('user', $user);  //覆盖session 中的 user
            $this->user = $user;
            $this->user_id = $user['user_id'];
            
            $this->assign('user', $user); //存储用户信息
        }
        
        //error_log(print_r($user, 1), 3, "./userinfo2");
        
        $nologin = array(
            'login', 'pop_login', 'do_login', 'logout', 'verify', 'set_pwd', 'finished',
            'verifyHandle', 'reg', 'send_sms_reg_code', 'find_pwd', 'check_validate_code',
            'forget_pwd', 'check_captcha', 'check_username', 'send_validate_code', 'express',
        );
        if (!$this->user_id && !in_array(ACTION_NAME, $nologin)) {
            header("location:" . U('Mobile/User/login'));
            exit;
        }
        
        
        $order_status_coment = array(
            'WAITPAY' => '待付款 ', //订单查询状态 待支付
            'WAITSEND' => '待发货', //订单查询状态 待发货
            'WAITRECEIVE' => '待收货', //订单查询状态 待收货
            'WAITCCOMMENT' => '待评价', //订单查询状态 待评价
        );
        $this->assign('order_status_coment', $order_status_coment);
        
        $this->get_userinfo();
    } 

    /*
     * 发展收益首页
     */
    public function index(){
        
        $users = M('users');
        //先判断该用户是否是分销商
        $res = $users->where("user_id={$this->user_id}")->field("is_distribut")->find();
        if($res['is_distribut']==0){
            //该用户还不是分销商
            echo "<script type='text/javascript'>alert('你还不是分销商');history.go(-1);</script>";die;
        }
        
        //获取所有的分销人数
        //$user_id = $this->user_id;
        $first_leader = $users->where("first_leader = {$this->user_id}")->count();
        $second_leader = $users->where("second_leader = {$this->user_id}" )->count();
        $third_leader = $users->where("third_leader = {$this->user_id}" )->count();
        
        $totle = $first_leader + $second_leader + $third_leader;
        
        $fenxiao = array(
            'first_leader' => $first_leader,
            'second_leader' => $second_leader,
            'third_leader' => $third_leader,
            'totle' => $totle,
        );
        
        $this->assign($fenxiao);//分销总人数
        
        $this->display('index');
    }
    
    
    /**
     * 进入排队抽奖页面
     */
    public function line_up(){
        $user_id = $this->user_id;
        
        //先判断该用户是否加入队列
        $prize_line = M('prize_line');
        if( $res = $prize_line->where("uid={$user_id}")->order("line_id desc")->find() ){
            
            $is_out = $res['is_out'];
            $this->assign('is_out',$is_out);//是否出队(0表示未出队，1表示出队)
            
        }else{
            echo "<script type='text/javascript'>alert('未加入队列');history.go(-1);</script>";die;
        }
        
        $this->display();
    }
    
    public function get_userinfo(){
        $order_count = M('order')->where("user_id = {$this->user_id}")->count(); // 我的订单数
        $goods_collect_count = M('goods_collect')->where("user_id = {$this->user_id}")->count(); // 我的商品收藏
        $comment_count = M('comment')->where("user_id = {$this->user_id}")->count();//  我的评论数
        $coupon_count = M('coupon_list')->where("uid = {$this->user_id}")->count(); // 我的优惠券数量
        $level_name = M('user_level')->where("level_id = '{$this->user['level']}'")->getField('level_name'); // 等级名称
        $this->assign('level_name', $level_name);
        $this->assign('order_count', $order_count);
        $this->assign('goods_collect_count', $goods_collect_count);
        $this->assign('comment_count', $comment_count);
        $this->assign('coupon_count', $coupon_count);
    }
    
    
    public function myqrcode(){
        
        $user_id = I('get.user_id');
        
        $qrcode = "./Public/upload/qrcode/".$user_id.".png";
        
        if(!file_exists($qrcode)) {
            //拼接二维码url
            //$url = "http://shop.17pche.com/Mobile/Index/index/user_id/".$user_id;
            
            $url = SITE_URL.'/index.php?m=Mobile&c=Index&a=index&first_leader='.$user_id.'&from=singlemessage';
//             dump($url);
//             die;
        
            //将该连接生成二维码
            vendor('phpqrcode.phpqrcode');
        
            $errorCorrectionLevel = "L";
            $matrixPointSize = "6";
        
            //生成二维码图片
            \QRcode::png($url, $qrcode , $errorCorrectionLevel, $matrixPointSize, 2);
        }
        
        $qrcode = substr($qrcode, 1);
        $this->assign('qrcode',$qrcode);
        
        $this->display('myqrcode');
        
    }
    
    /*
     * 获取我的分销商
     */
    public function myleader(){
        
        $data = I('get.');
//         error_log(print_r($data, 1), 3, "./userinfo2");
        
        $user_id = (int)$data['user_id'];
        $leader = (int)$data['leader'];
        
        //$order = M('users');
        
        if( $leader==1 ){
            //一级
            $userinfo = M('users')->where("first_leader={$user_id}")->select();
            
        }elseif($leader==2){
            //二级
            $userinfo = M('users')->where("second_leader={$user_id}")->select();
            
        }elseif($leader==3){
            //三级
            $userinfo = M('users')->where("third_leader={$user_id}")->select();
            
        } 
        
        $number = count($userinfo);
        
        for($i=0; $i<$number; $i++){
            
            if($userinfo[$i]['reg_time']){
                $userinfo[$i]['reg_time'] = date('Y-m-d H:i:s',$userinfo[$i]['reg_time']);
            }
            
        }
        
        
        $this->assign('number',$number);
        $this->assign('leader',$leader);
        $this->assign('userinfo',$userinfo);  
        
        //echo 'nima';
        //dump($userinfo);
        
        $this->display('leader');
        
    }
    
    
    
    
    
}