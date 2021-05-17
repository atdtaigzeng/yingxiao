<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Date: 2015-12-11
 */
namespace Admin\Controller;
use Think\AjaxPage;

class CouponController extends BaseController {
    /**----------------------------------------------*/
     /*                优惠券控制器                  */
    /**----------------------------------------------*/
    /*
     * 优惠券类型列表
     */
    public function index(){
        //获取优惠券列表
        
    	$count =  M('coupon')->count();
    	$Page = new \Think\Page($count,10);        
        $show = $Page->show();
        $lists = M('coupon')->order('add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('lists',$lists);
        $this->assign('page',$show);// 赋值分页输出   
        $this->assign('coupons',C('COUPON_TYPE'));
        $this->display();
    }

    /*
     * 添加编辑一个优惠券类型
     */
    public function coupon_info(){
        if(IS_POST){
        	$data = I('post.');
            $data['send_start_time'] = strtotime($data['send_start_time']);
            $data['send_end_time'] = strtotime($data['send_end_time']);
            $data['use_end_time'] = strtotime($data['use_end_time']);
            $data['use_start_time'] = strtotime($data['use_start_time']);
            if($data['send_start_time'] > $data['send_end_time']){
                $this->error('发放日期填写有误');
            }
            if(empty($data['id'])){
            	$data['add_time'] = time();
            	$row = M('coupon')->add($data);
            }else{
            	$row =  M('coupon')->where(array('id'=>$data['id']))->save($data);
            }
            if(!$row)
                $this->error('编辑代金券失败');
            $this->success('编辑代金券成功',U('Admin/Coupon/index'));
            exit;
        }
        $cid = I('get.id');
        if($cid){
        	$coupon = M('coupon')->where(array('id'=>$cid))->find();
        	$this->assign('coupon',$coupon);
        }else{
        	$def['send_start_time'] = strtotime("+1 day");
        	$def['send_end_time'] = strtotime("+1 month");
        	$def['use_start_time'] = strtotime("+1 day");
        	$def['use_end_time'] = strtotime("+2 month");
        	$this->assign('coupon',$def);
        }     
        $this->display();
    }

    /*
    * 优惠券发放
    */
    public function make_coupon(){
        //获取优惠券ID
        $cid = I('get.id');
        $type = I('get.type');
        //查询是否存在优惠券
        $data = M('coupon')->where(array('id'=>$cid))->find();
        $remain = $data['createnum'] - $data['send_num'];//剩余派发量
    	if($remain<=0) $this->error($data['name'].'已经发放完了');
        if(!$data) $this->error("优惠券类型不存在");
        if($type != 4) $this->error("该优惠券类型不支持发放");
        if(IS_POST){
            $num  = I('post.num');
            if($num>$remain) $this->error($data['name'].'发放量不够了');
            if(!$num > 0) $this->error("发放数量不能小于0");
            $add['cid'] = $cid;
            $add['type'] = $type;
            $add['send_time'] = time();
            for($i=0;$i<$num; $i++){
                do{
                    $code = get_rand_str(8,0,1);//获取随机8位字符串
                    $check_exist = M('coupon_list')->where(array('code'=>$code))->find();
                }while($check_exist);
                $add['code'] = $code;
                M('coupon_list')->add($add);
            }
            M('coupon')->where("id=$cid")->setInc('send_num',$num);
            adminLog("发放".$num.'张'.$data['name']);
            $this->success("发放成功",U('Admin/Coupon/index'));
            exit;
        }
        $this->assign('coupon',$data);
        $this->display();
    }
    
    public function ajax_get_user(){
    	//搜索条件
    	$condition = array();
    	I('mobile') ? $condition['mobile'] = I('mobile') : false;
    	I('email') ? $condition['email'] = I('email') : false;
    	$nickname = I('nickname');
    	if(!empty($nickname)){
    		$condition['nickname'] = array('like',"%$nickname%");
    	}
    	$model = M('users');
    	$count = $model->where($condition)->count();
    	$Page  = new AjaxPage($count,10);
    	foreach($condition as $key=>$val) {
    		$Page->parameter[$key] = urlencode($val);
    	}
    	$show = $Page->show();
    	$userList = $model->where($condition)->order("user_id desc")->limit($Page->firstRow.','.$Page->listRows)->select();
        
        $user_level = M('user_level')->getField('level_id,level_name',true);       
        $this->assign('user_level',$user_level);
    	$this->assign('userList',$userList);
    	$this->assign('page',$show);
    	$this->display();
    }
    
    public function send_coupon(){
    	$cid = I('cid');    	
    	if(IS_POST){
    		$level_id = I('level_id');
    		$user_id = I('user_id');
    		$insert = '';
    		$coupon = M('coupon')->where("id=$cid")->find();
    		if($coupon['createnum']>0){
    			$remain = $coupon['createnum'] - $coupon['send_num'];//剩余派发量
    			if($remain<=0) $this->error($coupon['name'].'已经发放完了');
    		}
    		
    		if(empty($user_id) && $level_id>=0){
    			if($level_id==0){
    				$user = M('users')->where("is_lock=0")->select();
    			}else{
    				$user = M('users')->where("is_lock=0 and level_id=$level_id")->select();
    			}
    			if($user){
    				$able = count($user);//本次发送量
    				if($coupon['createnum']>0 && $remain<$able){
    					$this->error($coupon['name'].'派发量只剩'.$remain.'张');
    				}
    				foreach ($user as $k=>$val){
    					$user_id = $val['user_id'];
    					$time = time();
    					$gap = ($k+1) == $able ? '' : ',';
    					$insert .= "($cid,1,$user_id,$time)$gap";
    				}
    			}
    		}else{
    			$able = count($user_id);//本次发送量
    			if($coupon['createnum']>0 && $remain<$able){
    				$this->error($coupon['name'].'派发量只剩'.$remain.'张');
    			}
    			foreach ($user_id as $k=>$v){
    				$time = time();
    				$gap = ($k+1) == $able ? '' : ',';
    				$insert .= "($cid,1,$v,$time)$gap";
    			}
    		}
			$sql = "insert into __PREFIX__coupon_list (`cid`,`type`,`uid`,`send_time`) VALUES $insert";
			M()->execute($sql);
			M('coupon')->where("id=$cid")->setInc('send_num',$able);
			adminLog("发放".$able.'张'.$coupon['name']);
			$this->success("发放成功");
			exit;
    	}
    	$level = M('user_level')->select();
    	$this->assign('level',$level);
    	$this->assign('cid',$cid);
    	$this->display();
    }
    
    public function send_cancel(){
    	
    }

    /*
     * 删除优惠券类型
     */
    public function del_coupon(){
        //获取优惠券ID
        $cid = I('get.id');
        //查询是否存在优惠券
        $row = M('coupon')->where(array('id'=>$cid))->delete();
        if($row){
            //删除此类型下的优惠券
            M('coupon_list')->where(array('cid'=>$cid))->delete();
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }


    /*
     * 优惠券详细查看
     */
    public function coupon_list(){
        //获取优惠券ID
        $cid = I('get.id');
        //查询是否存在优惠券
        $check_coupon = M('coupon')->field('id,type')->where(array('id'=>$cid))->find();
        if(!$check_coupon['id'] > 0)
            $this->error('不存在该类型优惠券');
       
        //查询该优惠券的列表的数量
        $sql = "SELECT count(1) as c FROM __PREFIX__coupon_list  l ".
                "LEFT JOIN __PREFIX__coupon c ON c.id = l.cid ". //联合优惠券表查询名称
                "LEFT JOIN __PREFIX__order o ON o.order_id = l.order_id ".     //联合订单表查询订单编号
                "LEFT JOIN __PREFIX__users u ON u.user_id = l.uid WHERE l.cid = ".$cid;    //联合用户表去查询用户名        
        
        $count = M()->query($sql);
        $count = $count[0]['c'];
    	$Page = new \Think\Page($count,10);
    	$show = $Page->show();
        
        //查询该优惠券的列表
        $sql = "SELECT l.*,c.name,o.order_sn,u.nickname FROM __PREFIX__coupon_list  l ".
                "LEFT JOIN __PREFIX__coupon c ON c.id = l.cid ". //联合优惠券表查询名称
                "LEFT JOIN __PREFIX__order o ON o.order_id = l.order_id ".     //联合订单表查询订单编号
                "LEFT JOIN __PREFIX__users u ON u.user_id = l.uid WHERE l.cid = ".$cid.    //联合用户表去查询用户名
                " limit {$Page->firstRow} , {$Page->listRows}";
        $coupon_list = M()->query($sql);
        $this->assign('coupon_type',C('COUPON_TYPE'));
        $this->assign('type',$check_coupon['type']);       
        $this->assign('lists',$coupon_list);            	
    	$this->assign('page',$show);        
        $this->display();
    }
    
    /*
     * 删除一张优惠券
     */
    public function coupon_list_del(){
        //获取优惠券ID
        $cid = I('get.id');
        if(!$cid)
            $this->error("缺少参数值");
        //查询是否存在优惠券
         $row = M('coupon_list')->where(array('id'=>$cid))->delete();
        if(!$row)
            $this->error('删除失败');
        $this->success('删除成功');
    }
    
    /**
     * 学车卷列表
     */
    public function coupon_car(){
        
        $coupon_car = M('coupon_car');
        //$where['is_use'] = 0;//搜索条件
        
        $totle = $coupon_car->where(1)->count();
        $Page = new \Think\Page($totle,10);
        $show = $Page->show();
        
        $lists = $coupon_car->join("__USERS__ on __COUPON_CAR__.uid = __USERS__.user_id")->where(1)->order('send_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        
        $this->assign('lists',$lists);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
        
    }
    
    /**
     * 删除学车卷
     */
    public function del_coupon_car(){
         
        $cid = I('get.id');
        if( $row = M('coupon_car')->where(array('id'=>$cid))->delete() ){
    
            $this->success("删除成功");
        }else{
    
            $this->error("删除失败");
        }
    }
    
    /**
     * 学车卷核销
     */
    public function deal_coupon_car(){
        
        $cid = I('get.id');
        
        $update['is_use'] = 1;
        
        if( M('coupon_car')->where(array('id'=>$cid))->save($update) ){
            echo 1;
        }else{
            echo 0;
        }
        
        
    }
    
    
    /**
     * 奖品设置
     */
    public function prize(){
        
        $this->display();
    }
    
    
    /**
     * 抽奖队列用户
     */

    public function prize_line(){
        $prize_line = M('prize_line');
        //$where['is_deal'] = 0;
        $totle = $prize_line->where($where)->count();
        $Page = new \Think\Page($totle,10);
        $show = $Page->show();
        $lists = $prize_line->join("__USERS__ on __PRIZE_LINE__.uid = __USERS__.user_id")->where($where)->order('addtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('lists',$lists);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('totle',$totle);//总人数
        $this->display('Coupon/prize_line');
    }
    //分成数的生成方法
    public function tree(){
        //先查询一级

        /*
         * 查询没有父级的分销商，自己为父级
         */
        $where='1 = 1  ';//搜索条件
        (I('user_id') != '') && $where = "$where and line_id = ".I('user_id');
        $info = M('prize_line')->join("tp_users on tp_prize_line.uid = tp_users.user_id ")->where($where)->select();
        $this->assign('father',$info);
        $this->display("Coupon/tree");
    }
    //请求下级树
    public function ajax_lower(){
        /*
         * 查询儿子，自己有父级
         */
        $str = '';
        $where='1 = 1  ';//搜索条件
        (I('get.id') !== '') && $where = "$where and p1 = ".I('get.id') ;
        $res = M('prize_line')->join("tp_users on tp_prize_line.uid = tp_users.user_id ")->where($where)->select();
        //$res = M('prize_line')->where($where)->select();
        if(is_array($res)) {
            foreach ($res as $key => $value) {
                $str = $str . "<li>
                    <span class=\"tree_span \" data-id=\"" . $value['line_id'] . "\">
                     <i class=\"icon-folder-open\"></i>
                    " . $value['line_id'] . ":" . $value['nickname'] . "
                    </span>
                     </li>";

            }
            $str = '<ul>' . $str . '</ul>';
            $this->ajaxReturn($str);
        }
    }

    /**
     * 奖品发放
     */
    public function grant_prize(){
        
    }
    
    
    /**
     * 显示所有已中奖的用户
     */
    public function prize_user(){
        $prize_line = M('prize_line');
    }

    //获取代金券列表
    public function list_coupon(){
        //查询条件
        $where = ' 1 = 1  '; // 搜索条件
        I('phone_num') && $where = "$where and mobile = ".I('phone_num');
        if(I('status') == 0){
            $status = 'use_time =0';
        }else{
            $status = 'use_time >0';
        }
        I('status') && $where = "$where and ".$status ;
        //var_export($where);
        $info = M('coupon_list')->join('tp_users on tp_coupon_list.uid = tp_users.user_id')->join('tp_coupon on tp_coupon_list.cid = tp_coupon.id')->where($where)->select();
        if($info != null){
            $this->assign('coupon_list',$info);
        }
        //var_export($info);
        $this->display('Coupon/list_coupon');
    }

    public function del_list_coupon(){
        $id = I('get.id');
        if(!$id )
            $this->error('缺少参数');
        //查询对应的优惠券
        $info = M('coupon_list')->where("id = {$id}")->delete();
        if(!$info )
            $this->error('删除失败');
        $this->success('删除成功');
    }
}