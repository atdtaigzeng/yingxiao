<?php
	namespace Admin\Controller;
	
	/*
	 * 该类用于企业转账
	 */
	class TransController extends BaseController{
		
	   	private $appid = '';
	   	private $appsecret = '';
	    private $mchid = '';
	    private $key = '';
	    
	    
	    public function _initialize(){
	        
	        parent::_initialize();
	        
	        $paymentPlugin = M('Plugin')->where("code='weixin' and  type = 'payment' ")->find(); // 找到微信支付插件的配置
	        $config_value = unserialize($paymentPlugin['config_value']); // 配置反序列化
	        $this->appid = $config_value['appid']; // * APPID：绑定支付的APPID（必须配置，开户邮件中可查看）
	        $this->mchid = $config_value['mchid']; // * MCHID：商户号（必须配置，开户邮件中可查看）
	        $this->key = $config_value['key']; // KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
	        $this->appsecret = $config_value['appsecret']; // 公众帐号secert（仅JSAPI支付的时候需要配置)，
	    }
	    
	    
	    public function test(){
	        
	        $apicent_cert = WWWROOT . DIRECTORY_SEPARATOR . 'tpshop' . DIRECTORY_SEPARATOR. 'plugins' . DIRECTORY_SEPARATOR. 'payment' . DIRECTORY_SEPARATOR . 'weixin' . DIRECTORY_SEPARATOR . 'cert' . DIRECTORY_SEPARATOR . 'apiclient_cert.pem';
	        $apiclient_key  = WWWROOT . DIRECTORY_SEPARATOR . 'tpshop' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR. 'payment' . DIRECTORY_SEPARATOR . 'weixin' . DIRECTORY_SEPARATOR . 'cert' . DIRECTORY_SEPARATOR . 'apiclient_key.pem';
	        
	        
	        $data = array(
	            'appid'=>$this->appid,
	            'appsecret' => $this->appsecret,
	            'mchid' => $this->mchid,
	            'key' => $this->key,
	            'apicent_cert' => $apicent_cert,
	            'apiclient_key' => $apiclient_key
	        );
	        
	        dump($data);
	    }
	   
    	
    	//企业付款调用该方法
	    public function trans($openID,$money){
	    	//接收页面传递过来的参数
// 	    	$openID = $_POST['openID'];
// 	    	$money = (int)$_POST['money'];
            $allow_ip = ['182.136.102.238'];
	        
            if(!in_array($_SERVER['REMOTE_ADDR'],$allow_ip)){
                return "无权限";
            }
	        //dump($_SERVER);die;
	        //error_log(print_r($money, 1), 3, "./testmoney");die;
	        //$money = 1;
	    	$params = array(
	    		'partner_trade_no' => $this->createPayid(),//生成订单号
	    		'openid' => $openID,
	    		'check_name' => 'NO_CHECK',
	    		'amount' => $money*100,
	    		'desc' => '佣金提现',
	    	);
	    	
	    	$apicent_cert = WWWROOT . DIRECTORY_SEPARATOR . 'tpshop' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR. 'payment' . DIRECTORY_SEPARATOR . 'weixin' . DIRECTORY_SEPARATOR . 'cert' . DIRECTORY_SEPARATOR . 'apiclient_cert.pem';
	        $apiclient_key  = WWWROOT . DIRECTORY_SEPARATOR . 'tpshop' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR. 'payment' . DIRECTORY_SEPARATOR . 'weixin' . DIRECTORY_SEPARATOR . 'cert' . DIRECTORY_SEPARATOR . 'apiclient_key.pem';
	    	//$ca = WWWROOT . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR. 'payment' . DIRECTORY_SEPARATOR . 'weixin' . DIRECTORY_SEPARATOR . 'cert' . DIRECTORY_SEPARATOR . 'rootca.pem';
	        
	        $res = $this->payToUser($params,$apicent_cert,$apiclient_key);
	        
	        //dump($res);die;
	    	
	    	if($res->result_code=='SUCCESS'){
	    	    return true;//转账成功
	    	}else{
	    	    $return_message = (string)$res->err_code_des;
	    	    return $return_message;
	    	}
	    	
	    	//获取支付结果
	    	//dump($res);
//	    	object(SimpleXMLElement)#7 (10) {
//				  ["return_code"] => string(7) "SUCCESS"
//				  ["return_msg"] => object(SimpleXMLElement)#8 (0) {
//				  }
//				  ["mch_appid"] => string(18) "wx6644becf2098b485"
//				  ["mchid"] => string(10) "1380838402"
//				  ["device_info"] => object(SimpleXMLElement)#9 (0) {
//				  }
//				  ["nonce_str"] => string(15) "848141333395157"
//				  ["result_code"] => string(7) "SUCCESS"
//				  ["partner_trade_no"] => string(16) "2016110909251350"
//				  ["payment_no"] => string(28) "1000018301201611094809686639"
//				  ["payment_time"] => string(19) "2016-11-09 09:25:15"
//				}
	    	
	    	
	    }
    	
    	
    	
    	/**
		 *  array转xml
		 */
		function arrayToXml($arr){
			
		    $xml = "<xml>";
		    foreach ($arr as $key=>$val)
		    {
		        if (is_numeric($val))
		        {
		               $xml.="<".$key.">".$val."</".$key.">"; 
		
		        }
		        else
		        $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
		    }
		    $xml.="</xml>";
		    return $xml; 
		}
		
		
		public function createNoncestr( $length = 15 ) {
			$chars = "01234567890123456789";  
			$str ="";
			for ( $i = 0; $i < $length; $i++ )  {  
				$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
			}  
			return $str;
		}
		
		/**
	    *   作用：使用证书，以post方式提交xml到对应的接口url
	    */
	    function postXmlSSLCurl($xml, $url, $second, $cert, $key){
	    	
	        $ch = curl_init();
	        //超时时间
	        curl_setopt($ch,CURLOPT_TIMEOUT,$second ? $second : $this->timeout);
	        
	        //这里设置代理，如果有的话
	        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
	        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
	        curl_setopt($ch,CURLOPT_URL, $url);
	        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
	        //设置header
	        curl_setopt($ch,CURLOPT_HEADER,FALSE);
	        //要求结果为字符串且输出到屏幕上
	        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
	        //设置证书
	        //使用证书：cert 与 key 分别属于两个.pem文件
	        //默认格式为PEM，可以注释
	        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
	        curl_setopt($ch,CURLOPT_SSLCERT,$cert);
	        //默认格式为PEM，可以注释
	        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
	        curl_setopt($ch,CURLOPT_SSLKEY, $key);
	        
	        //curl_setopt ($ch, CURLOPT_CAINFO, $ca);
	        //post提交方式
	        curl_setopt($ch,CURLOPT_POST, true);
	        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
	        $data = curl_exec($ch);
	        
	        //返回结果
	        if($data){
	        	curl_close($ch);
	        	//file_put_contents("./nimamama",$data);
	            $restran = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);//解析XML到对象
	    		//$restran = json_decode($restran,true);
	            return $restran;
	        }
	        else {
	            $error = curl_errno($ch);
	            echo "curl出错，错误码:$error"."<br>"; 
	            curl_close($ch);
	            return false;
	        }
	    }
	    
	    
	    
	    //生成订单号(最好在其它业务里生成该订单号,传到该类需要的函数中,Powered BY UNIX8.NET)
	    function createPayid()
	    {
	        return date('Ymdhis', time()) . substr(floor(microtime() * 1000), 0, 1) . rand(0, 9);
	    }
	    
	    
	    
	    //企业向个人付款
	    public function payToUser($params, $apicent_cert, $apiclient_key) {
	        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
	        
	        //检测必填参数
	        if($params["partner_trade_no"] == null) {   //
	            exit("退款申请接口中，缺少必填参数partner_trade_no！"."<br>");
	        }elseif($params["openid"] == null){
	            exit("退款申请接口中，缺少必填参数openid！"."<br>");
	        }elseif($params["check_name"] == null){             //NO_CHECK：不校验真实姓名 FORCE_CHECK：强校验真实姓名（未实名认证的用户会校验失败，无法转账）OPTION_CHECK：针对已实名认证的用户才校验真实姓名（未实名认证用户不校验，可以转账成功）
	            exit("退款申请接口中，缺少必填参数check_name！"."<br>");
	        }elseif(($params["check_name"] == 'FORCE_CHECK' or $params["check_name"] == 'OPTION_CHECK') && ($params["re_user_name"] == null)){  //收款用户真实姓名。
	            exit("退款申请接口中，缺少必填参数re_user_name！"."<br>");
	        }elseif($params["amount"] == null){
	            exit("退款申请接口中，缺少必填参数amount！"."<br>");
	        }elseif($params["desc"] == null){
	            exit("退款申请接口中，缺少必填参数desc！"."<br>");
	        }
	        
	        $params["mch_appid"] = $this->appid;//公众账号ID
	        $params["mchid"] = $this->mchid;//商户号
	        $params["nonce_str"] = $this->createNoncestr();//随机字符串
	        $params['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'] == '::1' ? '192.127.1.1' : $_SERVER['REMOTE_ADDR'];//获取IP
	        
	        
	        $params["sign"] = $this->getSign($params);//获取签名
	        
	        $xml = $this->arrayToXml($params);
	        
	        return $this->postXmlSSLCurl($xml, $url, false, $apicent_cert, $apiclient_key);
	    }
	    
	    
	    function formatBizQueryParaMap($paraMap, $urlencode)
		{
			//var_dump($paraMap);//die;
			$buff = "";
			ksort($paraMap);
			foreach ($paraMap as $k => $v)
			{
				if($urlencode)
				{
					$v = urlencode($v);
				}
				//$buff .= strtolower($k) . "=" . $v . "&";
				$buff .= $k . "=" . $v . "&";
			}
			$reqPar;
			if (strlen($buff) > 0)
			{
				$reqPar = substr($buff, 0, strlen($buff)-1);
			}
			//var_dump($reqPar);//die;
			return $reqPar;
		}
		
		/**
		 * 	作用：生成签名
		 */
		function getSign($Obj)
		{
			//var_dump($Obj);//die;
			foreach ($Obj as $k => $v)
			{
				$Parameters[$k] = $v;
			}
			//签名步骤一：按字典序排序参数
			ksort($Parameters);
			$String = $this->formatBizQueryParaMap($Parameters, false);
			//echo '【string1】'.$String.'</br>';
			//签名步骤二：在string后加入KEY
			$String = $String."&key=".$this->key;
			//echo "【string2】".$String."</br>";
			//签名步骤三：MD5加密
			$String = md5($String);
			//echo "【string3】 ".$String."</br>";
			//签名步骤四：所有字符转为大写
			$result_ = strtoupper($String);
			//echo "【result】 ".$result_."</br>";
			return $result_;
		}

	    
	    
	    
    
    
	}

?>