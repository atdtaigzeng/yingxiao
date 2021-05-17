<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="jiachang" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="applicable-device" content="mobile">
<title><?php echo ($tpshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<meta name="Keywords" content="佳昌微商城" />
<meta name="Description" content="佳昌微商城 "/>
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/user.css">
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script src="/Public/js/global.js"></script>
<script src="/Public/js/mobile_common.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/modernizr.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
</head>

<style>
#ag-btn{
    z-index: 1000;
    position: fixed;font-size: 12px;margin-left: 5%;bottom: 2%;
    display: none;
}
#ag-btn button {
    width: 49.4%;
    padding: 3%;
    border: none;
    outline: none;
    color: #fff;
    font-weight: 600
}

#ag-box dl {
    padding: 3%;
}

#ag-box dl dt {
    font-weight: bold;
}

#Agreement {
    font-size: 18px;
    color: blue;
}
</style>

<body>
    <header>
        <div class="tab_nav">
            <div class="header">
                <div class="h-left">
                    <a class="sb-back" href="javascript:history.back(-1)" title="返回"></a>
                </div>
                <div class="h-mid">信息修改</div>
                <div class="h-right">
                    <aside class="top_bar">
                        <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more">
                            <a href="javascript:;"></a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </header>
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
    <div id="tbh5v0">
        <div class="Personal">
            <div id="bg-box" style="position: absolute;"></div>
            <div id="ag-box" style="border-radius: 10px;position: absolute;overflow: auto;font-size: 12px;margin-left: 5%;margin-top: 15%;display: none;background: #fff">
                <h2 style="text-align: center;padding: 3% 0;border-bottom: 1px solid;">绵州学车注册协议</h2>
                <dl>
                    <dt>
                        一、总则
                    </dt>
                    <dd>
                        1.1 绵州学车网的所有权和运营权归绵阳市佳昌商贸有限责任公司所有。
                    </dd>
                    <dd>1.2 用户在注册之前，应当仔细阅读本协议，并同意遵守本协议后方可成为注册用户。一旦注册成功，则用户与绵州学车网之间自动形成协议关系，用户应当受本协议的约束。用户在使用特殊的服务或产品时，应当同意接受相关协议后方能使用。
                    </dd>
                    <dd>
                        1.3 本协议则可由绵州学车网随时更新，用户应当及时关注并同意本站不承担通知义务。本站的通知、公告、声明或其它类似内容是本协议的一部分。
                    </dd>
                </dl>
                <dl>
                    <dt>二、服务内容</dt>
                    <dd>2.1 绵州学车网的具体内容由本站根据实际情况提供。</dd>
                    <dd>2.2 本站仅提供相关的网络服务，除此之外与相关网络服务有关的设备(如个人电脑、手机、及其他与接入互联网或移动网有关的装置)及所需的费用(如为接入互联网而支付的电话费及上网费、为使用移动网而支付的手机费)均应由用户自行负担。</dd>
                </dl>
                <dl>
                    <dt>三、用户帐号</dt>
                    <dd>
                        3.1 经本站注册系统完成注册程序并通过身份认证的用户即成为正式用户，可以获得本站规定用户所应享有的一切权限；未经认证仅享有本站规定的部分会员权限。绵州学车网有权对会员的权限设计进行变更。
                    </dd>
                    <dd>
                        3.2 用户只能按照注册要求使用真实姓名，及身份证号注册。用户有义务保证密码和帐号的安全，用户利用该密码和帐号所进行的一切活动引起的任何损失或损害，由用户自行承担全部责任，本站不承担任何责任。如用户发现帐号遭到未授权的使用或发生其他任何安全问题，应立即修改帐号密码并妥善保管，如有必要，请通知本站。因黑客行为或用户的保管疏忽导致帐号非法使用，本站不承担任何责任。
                    </dd>
                </dl>
                <dl>
                    <dt>
                        四、使用规则
                    </dt>
                    <dd>
                        4.1 遵守中华人民共和国相关法律法规，包括但不限于《中华人民共和国计算机信息系统安全保护条例》、《计算机软件保护条例》、《最高人民法院关于审理涉及计算机网络著作权纠纷案件适用法律若干问题的解释(法释[2004]1号)》、《全国人大常委会关于维护互联网安全的决定》、《互联网电子公告服务管理规定》、《互联网新闻信息服务管理规定》、《互联网著作权行政保护办法》和《信息网络传播权保护条例》等有关计算机互联网规定和知识产权的法律和法规、实施办法。
                    </dd>
                    <dd>
                        4.2 用户对其自行发表、上传或传送的内容负全部责任，所有用户不得在本站任何页面发布、转载、传送含有下列内容之一的信息，否则本站有权自行处理并不通知用户：
                        <br> (1)违反宪法确定的基本原则的；
                        <br> (2)危害国家安全，泄漏国家机密，颠覆国家政权，破坏国家统一的；
                        <br> (3)损害国家荣誉和利益的；
                        <br> (4)煽动民族仇恨、民族歧视，破坏民族团结的；
                        <br> (5)破坏国家宗教政策，宣扬邪教和封建迷信的；
                        <br> (6)散布谣言，扰乱社会秩序，破坏社会稳定的；
                        <br> (7)散布淫秽、色情、赌博、暴力、恐怖或者教唆犯罪的；
                        <br> (8)侮辱或者诽谤他人，侵害他人合法权益的；
                        <br> (9)煽动非法集会、结社、游行、示威、聚众扰乱社会秩序的；
                        <br> (10)以非法民间组织名义活动的；
                        <br> (11)含有法律、行政法规禁止的其他内容的。
                        <dd>
                            4.3 用户承诺对其发表或者上传于本站的所有信息(即属于《中华人民共和国著作权法》规定的作品，包括但不限于文字、图片、音乐、电影、表演和录音录像制品和电脑程序等)均享有完整的知识产权，或者已经得到相关权利人的合法授权；如用户违反本条规定造成本站被第三人索赔的，用户应全额补偿本站一切费用(包括但不限于各种赔偿费、诉讼代理费及为此支出的其它合理费用)；
                        </dd>
                    </dd>
                    <dd>
                        4.4 当第三方认为用户发表或者上传于本站的信息侵犯其权利，并根据《信息网络传播权保护条例》或者相关法律规定向本站发送权利通知书时，用户同意本站可以自行判断决定删除涉嫌侵权信息，除非用户提交书面证据材料排除侵权的可能性，本站将不会自动恢复上述删除的信息；
                        <br> (1)不得为任何非法目的而使用网络服务系统；
                        <br> (2)遵守所有与网络服务有关的网络协议、规定和程序；
                        <br> (3)不得利用本站进行任何可能对互联网的正常运转造成不利影响的行为；
                        <br> (4)不得利用本站进行任何不利于本站的行为。
                    </dd>
                    <dd>
                        4.5 如用户在使用网络服务时违反上述任何规定，本站有权要求用户改正或直接采取一切必要的措施(包括但不限于删除用户张贴的内容、暂停或终止用户使用网络服务的权利)以减轻用户不当行为而造成的影响。
                    </dd>
                </dl>
                <dl>
                    <dt>五、隐私保护</dt>
                    <dd>
                        5.1 本站不对外公开或向第三方提供单个用户的注册资料及用户在使用网络服务时存储在本站的非公开内容，但下列情况除外：
                        <br> (1)事先获得用户的明确授权；
                        <br> (2)根据有关的法律法规要求；
                        <br>(3)按照相关政府主管部门的要求；
                        <br>(4)为维护社会公众的利益。
                    </dd>
                    <dd>
                        5.2 本站可能会与第三方合作向用户提供相关的网络服务，在此情况下，如该第三方同意承担与本站同等的保护用户隐私的责任，则本站有权将用户的注册资料等提供给该第三方。
                    </dd>
                    <dd>
                        5.3 在不透露单个用户隐私资料的前提下，本站有权对整个用户数据库进行分析并对用户数据库进行商业上的利用。
                    </dd>
                </dl>
                <dl>
                    <dt>六、版权声明</dt>
                    <dd>
                        6.1 本站的文字、图片、音频、视频等版权均归绵阳市佳昌商贸有限责任公司享有或与作者共同享有，未经本站许可，不得任意转载。
                    </dd>
                    <dd>
                        6.2 本站特有的标识、版面设计、编排方式等版权均属绵阳市佳昌商贸有限责任公司享有，未经本站许可，不得任意复制或转载。
                    </dd>
                    <dd>
                        6.3 使用本站的任何内容均应注明“来源于绵州学车网”及署上作者姓名，按法律规定需要支付稿酬的，应当通知本站及作者及支付稿酬，并独立承担一切法律责任。
                    </dd>
                    <dd>
                        6.4 本站享有所有作品用于其它用途的优先权，包括但不限于网站、电子杂志、平面出版等，但在使用前会通知作者，并按同行业的标准支付稿酬。
                    </dd>
                    <dd>
                        6.5 本站所有内容仅代表作者自己的立场和观点，与本站无关，由作者本人承担一切法律责任。
                    </dd>
                    <dd>
                        6.6 恶意转载本站内容的，本站保留将其诉诸法律的权利。
                    </dd>
                </dl>
                <dl>
                    <dt>
                        七、责任声明
                    </dt>
                    <dd>
                        7.1 用户明确同意其使用本站网络服务所存在的风险及一切后果将完全由用户本人承担，绵州学车网对此不承担任何责任。
                    </dd>
                    <dd>7.2 本站无法保证网络服务一定能满足用户的要求，也不保证网络服务的及时性、安全性、准确性。</dd>
                    <dd>7.3 本站不保证为方便用户而设置的外部链接的准确性和完整性，同时，对于该等外部链接指向的不由本站实际控制的任何网页上的内容，本站不承担任何责任。</dd>
                    <dd>
                        7.4 对于因不可抗力或本站不能控制的原因造成的网络服务中断或其它缺陷，本站不承担任何责任，但将尽力减少因此而给用户造成的损失和影响。
                    </dd>
                    <dd>
                        7.5 对于站向用户提供的下列产品或者服务的质量缺陷本身及其引发的任何损失，本站无需承担任何责任：
                        <br> (1)本站向用户免费提供的各项网络服务；
                        <br>(2)本站向用户赠送的任何产品或者服务。
                    </dd>
                    <dd>7.6 本站有权于任何时间暂时或永久修改或终止本服务(或其任何部分)，而无论其通知与否，本站对用户和任何第三人均无需承担任何责任。</dd>
                    <dd>
                        7.7绵州学车网展示的各种优惠券、以及产品或服务、分销奖励制度的供应商家，解释权归对应的供应商所有，绵州学车网不承担解释权利和法律责任。用户可以向网站客服投诉，绵州学车网根据投诉的事实核定后，对相关产品、服务、优惠券给予下线处理
                    </dd>
                    <dd>
                        7.8特别声明：
                        <br> （1）有关“全团了”消费激励券的使用，仅由提供消费激励券的供应商负责向“全团了”团购平台提供和上传商家让利信息，能否激励多少，以及多长时间能够激励完毕，由“全团了”团购平台负责。绵州学车网及激励券提供商均不承担相应的法律责任。
                        <br> （2）有关保险产品的优惠券使用，由相应的保险公司另行与用户签订保险合同，并承担保险责任。
                        <br> （3）绵州学车网会员专区提供的驾驶培训服务产品，一经网络预订，支付成功，即视为与培训服务的产品提供商（驾校）签订了电子版本的《机动车驾驶员培训合同》，如因各种原因退费，须按照合同承担违约责任：C1精品班按照培训总价的20%承担违约责任，C1贵宾星级班按照培训总价的40%承担违约责任。
                    </dd>
                </dl>
                <dl>
                    <dt>八、附则</dt>
                    <dd>8.1 本协议的订立、执行和解释及争议的解决均应适用中华人民共和国法律。</dd>
                    <dd>8.2 如本协议中的任何条款无论因何种原因完全或部分无效或不具有执行力，本协议的其余条款仍应有效并且有约束力。</dd>
                    <dd>8.3 本协议解释权及修订权归绵阳市佳昌商贸有限责任公司所有。</dd>
                </dl>
                <p style="text-align: right;">绵阳市佳昌商贸有限责任公司</p>
            </div>
            <div id="ag-btn">
                    <?php if($user[is_agree] == 0): ?><button style="background: #00FF00" id="Agree">同意</button>
                        <button style="background: red;" id="Disagree">不同意</button>
                    <?php else: ?>
                        <button style="width: 100%;background: #00FF00">已同意</button><?php endif; ?>
                </div>
            <div id="tbh5v0">
                <div class="innercontent1">
                    <span style="font-size: 14px;">请先阅读注册协议，否则不能进行本网站的核心操作</span>
                    <p id="Agreement" style="text-align: center;">绵州学车注册协议</p>
                    <form method="post" action="" id="edit_profile" onSubmit="return checkinfo()">
                        <div class="name"><span>昵　 称</span>
                            <input type="text" name="nickname" id="nickname" value="<?php echo ($user["nickname"]); ?>" placeholder="*昵称" class="c-f-text">
                        </div>
                        <div class="name1"><span>性　 别</span>
                            <ul>
                                <li <?php if($user[ 'sex']==0) {echo 'class="on"';} ?> >
                                    <label for="sex0">
                                        <input type="radio" name="sex" value="0" tabindex="2" class="radio" id="sex0" <?php if($user[ 'sex']==0) {echo 'checked="checked"';} ?>> 保密
                                    </label>
                                </li>
                                <li <?php if($user[ 'sex']==1) {echo 'class="on"';} ?> >
                                    <label for="sex1">
                                        <input type="radio" name="sex" value="1" tabindex="3" class="radio" id="sex1" <?php if($user[ 'sex']==1) {echo 'checked="checked"';} ?> > 男
                                    </label>
                                </li>
                                <li <?php if($user[ 'sex']==2) {echo 'class="on"';} ?> >
                                    <label for="sex2">
                                        <input type="radio" name="sex" value="2" tabindex="4" class="radio" id="sex2" <?php if($user[ 'sex']==2) {echo 'checked="checked"';} ?>> 女
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="name">
                            <label for="email_ep"> <span>邮箱</span>
                                <input name="email" value="<?php echo ($user["email"]); ?>" id="email_ep" placeholder="*电子邮件地址" type="text" />
                            </label>
                        </div>
                        <div class="field submit-btn">
                            <input type="submit" value="确认修改" class="btn_big1" />
                        </div>
                    </form>
                </div>
                <div class="innercontent1">
                    <form method="post" action="" id="edit_mobile" onSubmit="return checkMobileForm()">
                        <div class="name">
                            <label for="mobile_ep"> <span>手机</span>
                                <input name="mobile" value="<?php echo ($user["mobile"]); ?>" id="mobile_ep" placeholder="*手机号码" type="text" />
                            </label>
                        </div>
                        <div class="name">
                            <label for="mobile_code"> <span>验证码</span>
                                <input type="text" id="mobile_code" name="mobile_code" placeholder="手机验证码" />
                                <input id="zphone" type="button" rel="mobile" value="获取手机验证码 " onClick="sendcode(this)" class="zphone">
                            </label>
                        </div>
                        <div class="field submit-btn">
                            <input type="submit" value="确认修改" class="btn_big1" />
                        </div>
                    </form>
                </div>
                <div class="innercontent1">
                    <form method="post" action="" id="higher-up" onSubmit="return higherid()">
                        <div class="name">
                            <label for="higher-id"> <span>推荐人ID:</span>
                                <input name="leader" value="<?php echo ($user["first_leader"]); ?>" id="higher_id" placeholder="推荐人ID或手机号" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" type="text" <?php if($user["first_leader"] != 0): ?>disabled<?php endif; ?> />
                            </label>
                        </div>
                        <?php if($user["first_leader"] == 0): ?><div class="field submit-btn">
                                <input type="submit" value="确认修改" class="btn_big1" />
                            </div><?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        <script>
        $('.name1 ul li').click(function() {
            $(this).find("input").attr("checked", "checked");
            $('.name1 ul li').removeClass("on");
            $(this).addClass("on");
        })
        </script>
    </div>
    <script language="javascript">
        //获取网页高宽度
    var Awidth = document.body.scrollWidth;
    var Aheight = document.body.scrollHeight;
    var agree = "<?php echo ($user['is_agree']); ?>";
    $("#ag-btn").css('width', Awidth*0.9);
    if(agree == 0){
        $("#ag-box").css({
            "width": Awidth * 0.9,
            "height": Aheight * 0.7
        }).slideDown("slow");
        $("#bg-box").css({
            "width": Awidth,
            "height": Aheight,
            "background": "black",
            "opacity": "0.4",
            "overflow": "hidden"
        }).show();
        $("#ag-btn").show();
    }else if(agree == 1){
        $("#ag-box,#bg-box").hide();
    }
    $(function() {
        $('input[type=text],input[type=password]').bind({
            focus: function() {
                $(".global-nav").css("display", 'none');
            },
            blur: function() {
                $(".global-nav").css("display", 'flex');
            }
        });
    })

    var email_empty = "请输入您的电子邮件地址！";
    var email_error = "您输入的电子邮件地址格式不正确！";
    var old_password_empty = "请输入您的原密码！";
    var new_password_empty = "请输入6位以上新密码！";
    var confirm_password_empty = "请输入6位以上确认密码！";
    var both_password_error = "您现两次输入的密码不一致！";
    /* 会员修改密码 */
    function editPassword() {
        var frm = document.forms['formPassword'];
        var old_password = frm.elements['old_password'].value;
        var new_password = frm.elements['new_password'].value;
        var confirm_password = frm.elements['comfirm_password'].value;

        var msg = '';
        var reg = null;

        if (old_password.length == 0) {
            msg += old_password_empty + '\n';
        }

        if (new_password.length < 6) {
            msg += new_password_empty + '\n';
        }

        if (confirm_password.length < 6) {
            msg += confirm_password_empty + '\n';
        }

        if (new_password.length > 0 && confirm_password.length > 0) {
            if (new_password != confirm_password) {
                msg += both_password_error + '\n';
            }
        }

        if (msg.length > 0) {
            alert(msg);
            return false;
        } else {
            return true;
        }
    }


    /*
     *用户添加上级
     */
    function higherid() {
        if(agree == 0){
            alert("您还没同意本商城注册协议，无法修改个人信息，请先同意本商城的注册协议");
            return false
        }else if(agree == 1){

        }else{
            alert("出现错误，联系系统管理员");
        }
        var first_leader = $("#higher_id").val();

        if (first_leader == '') {
            alert('上级不能为空!');
            return false;
        } else {
            $.ajax({
                async: false, //同步请求 
                url: '/index.php?m=Mobile&c=User&a=check_leader&t=' + Math.random(),
                type: 'post',
                dataType: 'json',
                data: {
                    leader: first_leader
                },
                success: function(res) {
                    if (res.status == 1) {
                        check_leader = true;
                    } else {
                        check_leader = false;
                        layer.open({
                            content: res.msg,
                            time: 2
                        });
                    }
                }
            });

            return check_leader;
        }
    }

    function checkinfo() {
        if(agree == 0){
            alert("您还没同意本商城注册协议，无法修改个人信息，请先同意本商城的注册协议");
            return false
        }else if(agree == 1){

        }else{
            alert("出现错误，联系系统管理员");
        }
        var nickname = $('#nickname').val();
        var email = $('#email_ep').val();
        if (nickname == '') {
            alert("昵称不能为空");
            return false;
        }

        if (!checkEmail(email)) {
            alert("邮箱格式不正确");
            return false;
        }
        return true;
    }

    function checkMobileForm() {
        if(agree == 0){
            alert("您还没同意本商城注册协议，无法修改个人信息，请先同意本商城的注册协议");
            return false
        }else if(agree == 1){

        }else{
            alert("出现错误，联系系统管理员");
        }
        var mobile = $('#mobile_ep').val();
        var mobile_code = $('#mobile_code').val();
        if (!checkMobile(mobile)) {
            alert("手机格式不正确");
            return false;
        }
        if (mobile_code == '') {
            alert("请填写手机验证码");
            return false;
        }
        if (!mobile_flag) {
            alert("请先获取手机验证码");
            return false;
        }
        return true;
    }


    var mobile_flag = false;
    //发送验证码
    function sendcode(o) {
        var mobile = $('#mobile_ep').val();
        if (!checkMobile(mobile)) {
            alert("手机格式不正确");
        } else {
            $.ajax({
                url: '/index.php?m=Mobile&c=User&a=send_validate_code&t=' + Math.random(),
                type: 'post',
                dataType: 'json',
                data: {
                    type: $(o).attr('rel'),
                    send: $.trim($('#mobile_ep').val())
                },
                success: function(res) {
                    if (res.status == 1) {
                        mobile_flag = true;
                        countdown(o);
                    } else {
                        mobile_flag = false;
                        layer.open({
                            content: res.msg,
                            time: 2
                        });
                    }
                }
            });
        }
    }

    var wait = 150;
    function countdown(obj, msg) {
        obj = $(obj);
        if (wait == 0) {
            obj.removeAttr("disabled");
            obj.val(msg);
            wait = 150;
        } else {
            if (msg == undefined || msg == null) {
                msg = obj.val();
            }
            obj.attr("disabled", "disabled");
            obj.val(wait + "秒后重新获取");
            wait--;
            setTimeout(function() {
                countdown(obj, msg)
            }, 1000)
        }
    }


    // 查看协议
    $("#Agreement").click(function(event) {
        /* Act on the event */
        $("#ag-box").css({
            "width": Awidth * 0.9,
            "height": Aheight * 0.7
        }).slideDown("slow");
        $("#bg-box").css({
            "width": Awidth,
            "height": Aheight,
            "background": "black",
            "opacity": "0.4",
            "overflow": "hidden"
        }).show();
        $("#ag-btn").show();
    });
    // 同意按钮
    $("#Agree").click(function(event) {
        /* Act on the event */
        $("#ag-box").hide(400, function() {
            alert("您已同意本协议，您可进行核心操作");
            $.ajax({
                url:"/index.php?m=Mobile&c=User&a=is_agree",
                type:"post",
                dataType:"json",
                data:{
                    dateAgree:1,
                    userid:"<?php echo ($user[user_id]); ?>",
                },
                success:function(data){
                    agree = data;
                },
                error:function(e){
                    alert(e);
                },
            });
        });
        $("#bg-box").hide(400);
        $("#ag-btn").hide();
    });
    $("#Disagree").click(function(event) {
        /* Act on the event */
        $("#ag-box").hide(400, function() {
            alert("由于您不同意此协议，您暂时不能使用本商城的核心功能");
        });
        $("#bg-box").hide(400);
        $("#ag-btn").hide();
    });
    $("#bg-box").click(function(event) {
        /* Act on the event */
        $("#bg-box,#ag-box,#ag-btn").hide(400);


    });
    </script>
</body>

</html>