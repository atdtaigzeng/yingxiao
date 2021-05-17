<?php
namespace Common\Logic;

use Think\Model\RelationModel;
/**
 *
 * Class DistributLogic
 * @package Common\Logic
 */
class DistributLogic extends RelationModel{
    
    // 生成分成记录
    public function rebate_log($order){
        //获取订单分成比例
        $first_rate = tpCache('distribut.first_rate')/100;
        $second_rate = tpCache('distribut.second_rate')/100;
        $third_rate = tpCache('distribut.third_rate')/100;
        //获取分佣金模式(0表示按商品设置的分成金额，1表示按订单设置的分成比例)
        if( $pattern = tpCache('distribut.pattern') ){
            //按订单设置的分成比例
            $order_rate = tpCache('distribut.order_rate')/100;
            $yongjing = $order['total_amount'] * $order_rate;//计算出总佣金
        }else{
            //按商品设置的分成金额
            //先获取到商品
            $goods = M('order_goods')->where("order_id={$order['order_id']}")->field("goods_id,goods_num")->select();
            $length = count($goods); //支付商品的数量
            $yongjing = 0;
            
            for($i=0; $i<$length; $i++){
                $goods_id = $goods[$i]['goods_id'];
                //当前商品的佣金
                $money = M('goods')->where("goods_id={$goods_id}")->field('commission')->find();
                $yongjing += $money['commission'] * $goods[$i]['goods_num'];//总佣金计算(佣金*该商品的数量)
            }
            //error_log(print_r($yongjing, 1), 3, "./test");
        }
        if($yongjing){
            //如果该笔订单有佣金,进行佣金三级分配
            $user = M('users')->where("user_id={$order['user_id']}")->field("nickname,first_leader,second_leader,third_leader")->find();
            $rebate_log = array(
                'buy_user_id' => $order['user_id'],
                'nickname' => $user['nickname'],
                'order_sn' => $order['order_sn'],
                'order_id' => $order['order_id'],
                'goods_price' => $order['goods_price'],
                'create_time' => time()
            );
            if($user['first_leader']){
                //一级获佣
                $get_yongjing = $yongjing*$first_rate;
                
                if($get_yongjing>500){
                    $distribut_level = $this->distribut_level($user['first_leader']);
                    if($distribut_level<2){
                        $get_yongjing = $get_yongjing/2;
                    }
                }
                
                $rebate_log['user_id'] = $user['first_leader'];
                $rebate_log['money'] = $get_yongjing;
                $rebate_log['level'] = 1;
                M('rebate_log')->add($rebate_log);
            }
            if($user['second_leader']){
                //二级获佣
                $get_yongjing = $yongjing*$second_rate;
                
                if($get_yongjing>300){
                    $distribut_level = $this->distribut_level($user['second_leader']);
                    if($distribut_level<2){
                        $get_yongjing = $get_yongjing/2;
                    }
                }
                
                $rebate_log['user_id'] = $user['second_leader'];
                $rebate_log['money'] = $get_yongjing;
                $rebate_log['level'] = 2;
                M('rebate_log')->add($rebate_log);
            }
            if($user['third_leader']){
                //三级获佣
                $get_yongjing = $yongjing*$third_rate;
                
                if($get_yongjing>200){
                    $distribut_level = $this->distribut_level($user['third_leader']);
                    if($distribut_level<2){
                        $get_yongjing = $get_yongjing/2;
                    }
                }
                
                $rebate_log['user_id'] = $user['third_leader'];
                $rebate_log['money'] = $get_yongjing;
                $rebate_log['level'] = 3;
                
                M('rebate_log')->add($rebate_log);
                
            }

        }

    }
    
    /**
     * 判断用户的分销等级
     */
    private function distribut_level($user_id){
        $user_id = (int)$user_id;
        if( $level = M('users')->where("user_id={$user_id}")->getField('distribut_level') ){
            return $level;
        }else{
            return 0;
        }
    }
    
    
    
    //自动分成
    public function auto_confirm(){
        $rebate_log = M('rebate_log');
        $users = M('users');
        $where = array(
            'status' => 2,
            'confirm_time' => 0
        );
        if($res = $rebate_log->where($where)->select()){
            $length = count($res);
            for($i=0;$i<$length;$i++){
                $rebate_id = (int)$res[$i]['id'];
                $user_id = (int)$res[$i]['user_id']; 
                $add_money = $res[$i]['money'];
                $level = $res[$i]['level'];
                $nickname = $res[$i]['nickname'];
                
                $data = array(
                    'status' => 3,
                    'confirm_time' => time()
                );
                
                if( $users->where("user_id={$user_id}")->setInc("user_money",$add_money) && $users->where("user_id={$user_id}")->setInc("distribut_money",$add_money) ){   
                    $rebate_log->where("id={$rebate_id}")->save($data);
                    
                    switch ($level){
                        case 1:
                            $content = "一级佣金到账";
                            break;
                        case 2:
                            $content = "二级佣金到账";
                            break;
                        case 3:
                            $content = "三级佣金到账";
                            break;
                    
                    }
                    $content = $content."(购买人：{$nickname})";
                    
                    $add_money = '+'.$add_money;
                    $user_info = $users->where("user_id={$user_id}")->field("openid,user_money")->find();
                    sendTempMessage($user_info['openid'],$add_money,$user_info['user_money'],$content);
                }
                
            }
            
        }
        
    }
    
    

    /**
     * @return array
     */
     /* public function auto_confirm()
    {
        //查询分成日志表
        $log_list = M('rebate_log')->where('confirm != 0 and status = 2 and confirm_time = 0')->getField('id,user_id,money,order_sn');
        $list = array();
        if (is_array($log_list) && $log_list != null) {
            //获佣用户id相同的日志
            foreach ($log_list as $key => $value) {
                $list[$value['user_id']][$value['id']] = $value;
            }
            $log = array();
            foreach ($list as $key => $value) {
                foreach ($value as $k => $v) {
                    $log[$v['user_id']][$v['id']] = $v['money'];
                    $order[$v['user_id']][$v['id']]  = $v['order_sn'];//对应的订单号数组
                }
            }
            //计算每个获佣用户在一定时间段内的获佣总金额,并获取用户对应的获佣日志ID，以方便求改其状态
            foreach ($log as $k => $v) {
                $all[$k] = array_sum($v);
                $id[$k] = $k;
                $status[$k] = array_keys($v);
            }
            foreach ($order as $k=>$v){
                    $order[$k]=$v;
            }
            //查询原有的获佣总金额
            $money = M('users');
            $where['user_id'] = array("in", $id);
            $list = $money->where($where)->getField('user_id,distribut_money');
            foreach ($id as $k => $v) {
                $arr_money[$k] = $list[$v];
                $distribut_money[$k] = $all[$v] + $list[$v];
            }
            //拼接sql语句
            $user_ids = implode(',', array_keys($all));
            $sql = "UPDATE tp_users SET distribut_money = CASE user_id ";
            foreach ($distribut_money as $user_id => $money) {
                $sql .= sprintf("WHEN %d THEN %.2f ", $user_id, $money);
            }
            $sql .= "END WHERE user_id IN ($user_ids)";
            $info = M('users');
            $res = $info->execute($sql);
            if ($res !== false) {
                //进行状态改变，一旦入库操作完成，则修改状态
                $money = M('rebate_log');
                foreach ($status as $k => $v) {
                    $where['id'] = array("in", $v);
                    $data = array('status'=>'3','confirm_time'=>time());
                    $list = $money->where($where)->setField($data);
                }
                //改变订单表的分成状态
                $is_distribut = M('order');
                foreach($order as $k=>$v){
                    $where['order_sn'] = array("in", $v);
                    $list = $is_distribut->where($where)->setField('is_distribut', 1);
                    if($list != false ){
                            echo "已修改订单表";
                    }
                }
                if($res !== 0) {//还未写入表中
                    //加入账户余额,首先判断是否已近加过了
                    
                    //读取原有账户余额
                     
                    $money = M('users');
                    $where['user_id'] = array("in", $id);
                    $list_arr = $money->where($where)->getField('user_id,user_money');
                    //将现有的金额和获佣总金额相加
                    foreach ($id as $k => $v) {
                        $all_money[$k] = $all[$v] + $list_arr[$v];
                    }
                    $user_ids = implode(',', array_keys($all));
                    $sql = "UPDATE tp_users SET user_money = CASE user_id ";
                    foreach ($all_money as $user_id => $money) {
                        $sql .= sprintf("WHEN %d THEN %.2f ", $user_id, $money);
                    }
                    $sql .= "END WHERE user_id IN ($user_ids)";
                    $info = M('users');
                    $res = $info->execute($sql);
                    if ($res !== false) {
                        //分钱成功后，发送资金变动信息
                        //分成人员ID
                        $id;
                       //分成前的余额
                        $arr_money;
                        //分成余额
                        $list_arr;
                        //分成后的余额
                        $distribut_money;
                        error_log(print_r($id, 1), 3, "./id");
                        error_log(print_r($arr_money, 1), 3, "./arr_money");
                        error_log(print_r($list_arr, 1), 3, "./list_arr");
                        error_log(print_r($distribut_money, 1), 3, "./distribut_money");
                        $info = M('users');
                        foreach ($id as $k => $v) {
                            $arr = $info ->join('tp_rebate_log on tp_users.user_id = tp_rebate_log.user_id')->where("user_id =".$k." ")->find();
                            error_log(print_r(var_export($arr), 1), 3, "./arr");
                            sendTempMessage($arr['openid'],$list_arr[$k],$all_money[$k],$arr['level']);
                        }
                        echo "已打款";
                    }
                }
            }
        }
    }  */
}