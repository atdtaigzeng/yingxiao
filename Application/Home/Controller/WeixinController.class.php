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
 * 微信交互类
 */ 
namespace Home\Controller;
use Think\Controller;
class WeixinController extends BaseController {
    public $client;
    public $wechat_config;
    
    private $tpl = array(
    
        //发送文本消息模板
        'text' => '	<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>',
        	
        //发送图片消息模板
        'image' => '<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[image]]></MsgType>
							<Image>
							<MediaId><![CDATA[%s]]></MediaId>
							</Image>
							</xml>',
        //发送图文消息模板
        'list' => 	'<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>%s</ArticleCount>
							<Articles>
							%s
							</Articles>
							</xml>',
        	
        'item' => 	'<item>
							<Title><![CDATA[%s]]></Title>
							<Description><![CDATA[%s]]></Description>
							<PicUrl><![CDATA[%s]]></PicUrl>
							<Url><![CDATA[%s]]></Url>
							</item>',
        //音乐消息
        'music' => '<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[music]]></MsgType>
							<Music>
							<Title><![CDATA[%s]]></Title>
							<Description><![CDATA[%s]]></Description>
							<MusicUrl><![CDATA[%s]]></MusicUrl>
							<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
							<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
							</Music>
							</xml>'
    );
    
    
    
    
    public function _initialize(){
        parent::_initialize();
        //获取微信配置信息
        $this->wechat_config = M('wx_user')->find();        
        $options = array(
 			'token'=>$this->wechat_config['w_token'], //填写你设定的key
 			'encodingaeskey'=>$this->wechat_config['aeskey'], //填写加密用的EncodingAESKey
 			'appid'=>$this->wechat_config['appid'], //填写高级调用功能的app id
 			'appsecret'=>$this->wechat_config['appsecret'], //填写高级调用功能的密钥
		);

    }

    public function oauth(){

    }
    
    public function index(){
        if($this->wechat_config['wait_access'] == 0)        
            exit($_GET["echostr"]);
        else        
            $this->responseMsg();
    }    
    
    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      	//extract post data
	    if (empty($postStr))                 	
        	exit("");
         
        /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
           the best way is to check the validity of xml by yourself */
        libxml_disable_entity_loader(true);
      	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        switch($postObj->MsgType){
            case 'event': //事件处理
                $this->_doEvent($postObj);
                break;
            case 'text': //文本处理
                $this->_doText($postObj);
                break;
            case 'image': //图片处理
                $this->_doImage($postObj);
                break;
            case 'voice': //声音处理
                $this->_doVoice($postObj);
                break;
            case 'video': //视频处理
                $this->_doVideo($postObj);
                break;
            case 'location'://定位处理
                $this->_doLocation($postObj);
                break;
            default: exit;
        }
                
      
    } 
    
    /**
     *_doEvent():处理事件消息
     *@postObj:响应的消息对象
     **/
    private function _doEvent($postObj){ //事件处理
        switch($postObj->Event){
            case  'subscribe': //订阅
                
                //将关注的用户存入数据库
                $data['sub_openid'] = (string)$postObj->FromUserName;
                M('subscriber')->add($data);
                
                $str = sprintf($this->tpl['text'],$postObj->FromUserName,$postObj->ToUserName,time(),'欢迎来到绵州学车');
                //还可以保存用户的信息到数据库
                echo $str;
                break;
            case 'unsubscribe': //取消订阅
                //把用户的信息从数据库中删除
                //将关注的用户存入数据库
                $data['sub_openid'] = (string)$postObj->FromUserName;
                M('subscriber')->where($data)->delete();
                
                break;
            case 'CLICK':
                $this->_doClick($postObj);
                break;
            default:;
        }
    }
    
    /**
     *_doText():处理文本消息
     *@postObj:响应的消息对象
     **/
    private function _doText($postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time(); 
        if(!empty( $keyword ))
        {
            // 图文回复
                $wx_img = M('wx_img')->where("keyword like '%$keyword%'")->find();
                if($wx_img)
                {
                    $textTpl = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <ArticleCount><![CDATA[%s]]></ArticleCount>
                                <Articles>
                                    <item>
                                        <Title><![CDATA[%s]]></Title> 
                                        <Description><![CDATA[%s]]></Description>
                                        <PicUrl><![CDATA[%s]]></PicUrl>
                                        <Url><![CDATA[%s]]></Url>
                                    </item>                               
                                </Articles>
                                </xml>";                                        
                    $resultStr = sprintf($textTpl,$fromUsername,$toUsername,$time,'news','1',$wx_img['title'],$wx_img['desc']
                            , $wx_img['pic'], $wx_img['url']);
                    exit($resultStr);                   
                }
                
                
                // 文本回复
                $wx_text = M('wx_text')->where("keyword like '%$keyword%'")->find();
                if($wx_text)
                {
                    $textTpl = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                <FuncFlag>0</FuncFlag>
                                </xml>";                    
                    $contentStr = $wx_text['text'];
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', $contentStr);
                    exit($resultStr);                   
                }
                
                
                // 其他文本回复                
                    $textTpl = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                <FuncFlag>0</FuncFlag>
                                </xml>";                    
                    $contentStr = '欢迎来到绵州学车';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', $contentStr);
                    exit($resultStr);   
        }
        exit("Input something...");
    }
    
    /**
     *_doClick():处理菜单点击事件
     *@postObj:响应的消息对象
     **/
    private function _doClick($postObj){
        $content = (string)$postObj->EventKey;
        $str = sprintf($this->tpl['text'],$postObj->FromUserName,$postObj->ToUserName,time(),$content);
        //还可以保存用户的信息到数据库
        echo $str;
        
    }
    
    
    
    
    
    
    
    
    
}