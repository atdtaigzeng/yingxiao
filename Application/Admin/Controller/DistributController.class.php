<?php
/**
 * Created by PhpStorm.
 * User: zd
 * Date: 2017/3/25
 * Time: 14:17
 */
namespace Admin\Controller;
use Admin\Logic\GoodsLogic;
use Admin\Logic\UsersLogic;
use Think\AjaxPage;
use Think\Page;

class DistributController extends BaseController{

    //分销商品列表
    public function goods_list(){
        $GoodsLogic = new GoodsLogic();
        $brandList = $GoodsLogic->getSortBrands();
        $categoryList = $GoodsLogic->getSortCategory();
        $this->assign('categoryList',$categoryList);
        $this->assign('brandList',$brandList);
        $this->display();
    }
    //分销商品列表
    public function ajaxGoodsList(){
        $where = ' 1 = 1 and commission != 0.00 '; // 搜索条件
        I('intro')    && $where = "$where and ".I('intro')." = 1" ;
        I('brand_id') && $where = "$where and brand_id = ".I('brand_id') ;
        (I('is_on_sale') !== '') && $where = "$where and is_on_sale = ".I('is_on_sale') ;
        $cat_id = I('cat_id');
        // 关键词搜索
        $key_word = I('key_word') ? trim(I('key_word')) : '';
        if($key_word)
        {
            $where = "$where and (goods_name like '%$key_word%' or goods_sn like '%$key_word%')" ;
        }
        if($cat_id > 0)
        {
            $grandson_ids = getCatGrandson($cat_id);
            $where .= " and cat_id in(".  implode(',', $grandson_ids).") "; // 初始化搜索条件
        }
        $model = M('Goods');
        $count = $model->where($where)->count();
        $Page  = new AjaxPage($count,10);
        /**  搜索条件下 分页赋值
        foreach($condition as $key=>$val) {
        $Page->parameter[$key]   =   urlencode($val);
        }
         */
        $show = $Page->show();
        $order_str = "`{$_POST['orderby1']}` {$_POST['orderby2']}";
        $goodsList = $model->where($where)->order($order_str)->limit($Page->firstRow.','.$Page->listRows)->select();
        //计算分佣比例
        foreach($goodsList as $key=>$value){
            $goodsList[$key]["scale"] =  $value['commission']/$value['shop_price'];
        }
        //var_export($goodsList);
        $catList = D('goods_category')->select();
        $catList = convert_arr_key($catList, 'id');
        $this->assign('catList',$catList);
        $this->assign('goodsList',$goodsList);
        $this->assign('page',$show);// 赋值分页输出
        $this->display("Distribut/ajaxGoodsList");
    }
    //分销商列表
    public function ajaxDistributor_list(){
        $where = ' 1 = 1 and is_distribut = 1 '; // 搜索条件
        (I('user_id') != '') && $where = "$where and user_id = ".I('user_id');
        (I('nickname') !== '') && $where = "$where and nickname = ".I('nickname') ;
        //实例化对象
        $model = M('users');
        $count = $model->where($where)->count();
        $Page  = new AjaxPage($count,10);
        $show = $Page->show();
        //查询用户
        $usersList = $model->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        //获取下级人数
        foreach($usersList as $key=>$value){
            $first = M('users')->where("first_leader = '".$value['user_id']."'")->select();
            $second = $model->where("second_leader = '".$value['user_id']."'")->select();
            $third = $model->where("third_leader = '".$value['user_id']."'")->select();
            $usersList[$key]['first'] = count($first);
            $usersList[$key]['second'] = count($second);
            $usersList[$key]['third'] = count($third);
            $usersList[$key]['all_num']=  count($first)+count($second)+count($third);
        }
        $this->assign('usersList',$usersList);
        $this->assign('page',$show);// 赋值分页输出
        $this->display("Distribut/ajaxDistributor_list");
    }

    //分销设置方法
    public function set(){
        $inc_type =  I('get.inc_type','distribut');
        $config = tpCache($inc_type);
        $this->assign('config',$config);//当前配置项
        $this->display("System/distribut");
    }

    //生成分销树的方法
    public function tree(){
        //先查询一级
        /*
         * 查询没有父级的分销商，自己为父级
         */
        $where='1 = 1 and is_distribut = 1 and first_leader =0 ';//搜索条件
        (I('user_id') != '') && $where = "$where and user_id = ".I('user_id');
        $info = M('users')->where($where)->select();
        $this->assign('father',$info);
        $this->display("Distribut/tree");
    }
    //请求下级树
    public function ajax_lower(){
        /*
         * 查询儿子，自己有父级
         */

        $str = '';
        $where='1 = 1 and is_distribut = 1  ';//搜索条件
        (I('get.id') !== '') && $where = "$where and first_leader = ".I('get.id') ;
        $res = M('users')->where($where)->select();
        if(is_array($res)) {
            foreach ($res as $key => $value) {
                $str = $str . "<li>
                    <span class=\"tree_span \" data-id=\"" . $value['user_id'] . "\">
                     <i class=\"icon-folder-open\"></i>
                    " . $value['user_id'] . ":" . $value['nickname'] . "
                    </span>
                     </li>";

            }
            $str = '<ul>' . $str . '</ul>';
            $this->ajaxReturn($str);
        }
    }

    //分成日志
    public function rebate_log(){
        $categoryList = array(0=>"未付款",1=>"已付款",2=>"等待分成",3=>"已分成",4=>"已取消");
        $this->assign("categoryList",$categoryList);
        $this->display();
    }

    //读取分成日志
    public function ajaxRebate_log(){
        $where = ' 1 = 1  '; // 搜索条件
        I('order_sn') && $where = "$where and order_sn = ".I('order_sn');
        I('status') && $where = "$where and status = ".I('status') ;
        (I('user_id') !== '') && $where = "$where and user_id = ".I('user_id') ;
        // 时间搜索
        $time = I('create_time') ? explode(' - ',I('create_time')) : '';
        //将日期转换为时间戳
        $arrayTime = array();
        for($i = 0;$i<count($time);$i++){
            $arrayTime[$i] = strtotime($time[$i]);
        }
        if(!empty($arrayTime))
        {
            $where = "$where and (create_time >= '%$arrayTime[0]%' or create_time <= '%$arrayTime[1]%')" ;
        }
        $model = M('rebate_log');
        $count = $model->where($where)->count();
        $Page  = new AjaxPage($count,10);
        $show = $Page->show();
        $logList = $model->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('logList',$logList);
        $this->assign('page',$show);// 赋值分页输出
        $this->display("Distribut/ajaxRebate_log");
    }

    //编辑分成日志
    public function editRebate(){
       $where =' 1 = 1 ';//搜索条件
        (I('id') !== '') && $where = "$where and id = ".I('id') ;
        $model = M('rebate_log');
        $logList = $model->where($where)->select();
        if(count($logList)!= 1){
            echo "出错啦";
        }else{
            $logList = $logList[0];
        }
        $this->assign('logList',$logList);
        $this->display("Distribut/editRebate");
    }
    //保存编辑日志
    public function saveRebate(){
        $where = '1 = 1';
        $str = I('remark');
        (I('id') != '') && $where = "$where and id = ".I('id');
        $model = M('rebate_log');
        $model->remark = $str;
        $res = $model->where($where)->save();
        if ($res != null){
            $this->success('修改成功',U('Distribut/rebate_log'));
        }else{
            $this->error('修改失败');
        }
    }


    //汇款方法
    public function remittance(){
        $this->display();
    }



    public function withdrawals(){

    }

    public function editWithdrawals(){

    }

    public function delWithdrawals(){

    }
}