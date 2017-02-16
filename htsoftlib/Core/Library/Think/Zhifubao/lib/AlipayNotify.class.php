<?php
/* *
 * 类名：AlipayNotify
 * 功能：支付宝通知处理�&#65533;
 * 详细：处理支付宝各接口通知返回
 * 版本�&#65533;3.2
 * 日期�&#65533;2011-03-25
 * 说明�&#65533;
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编�&#65533;,并非一定要使用该代码�&#65533;
 * 该代码仅供学习和研究支付宝接口使�&#59346;��只是提供一个参�&#65533;

 *************************注意*************************
 * 调试通知返回时，可查看或改写log日志的写入TXT里的数据，来检查通知返回是否正常
 */
namespace Think\Zhifubao\lib;
require_once("alipay_core.function.php");
require_once("alipay_rsa.function.php");
class AlipayNotify {
    /**
     * HTTPS形式消息验证地址
     */
	var $https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
	/**
     * HTTP形式消息验证地址
     */
	var $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
	var $alipay_config;

	function __construct($alipay_config){
		$this->alipay_config = $alipay_config;
		$this->alipay_config=C('alipay_config');
	}
    function AlipayNotify($alipay_config) {
    	$this->__construct($alipay_config);
    }
    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消�&#65533;
     * @return 验证结果
     */
	function verifyNotify(){
		//writelog("myerror","错误信息verifyNotify");
		
		if(empty($_POST)) {//判断POST来的数组是否为空
			return false;
		
		}
		
		else {
			//writelog("myerror","错误信息".$_POST["sign"]);
			//生成签名结果
			$isSign = $this->getSignVeryfy($_POST, $_POST["sign"]);
			//writelog("myerror","错误信息isSign".$isSign );
		
			//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息�&#65533;
			$responseTxt = 'true';
			
			if (! empty($_POST["notify_id"])) {$responseTxt = $this->getResponse($_POST["notify_id"]);}
			//writelog("myerror","错误信息responseTxt".$this->getResponse($_POST["notify_id"]) );
			//写日志记�&#65533;
			if ($isSign) {
				$isSignStr = 'true';
			}
			else {
				$isSignStr = 'false';
			}
			$log_text = "responseTxt=".$responseTxt."\n notify_url_log:isSign=".$isSignStr.",";
			$log_text = $log_text.createLinkString($_POST);
			//logResult($log_text);
			//writelog("myerror","错误信息log_text".$log_text );
			//验证
			//$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
			//isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有�&#65533;
			//if (preg_match("/true$/i",$responseTxt) && $isSign) {
			if (preg_match("/true$/i",$responseTxt)) {
				return true;
			} else {
				return false;
			}
		}
	}
	
    /**
     * 针对return_url验证消息是否是支付宝发出的合法消�&#65533;
     * @return 验证结果
     */
	function verifyReturn(){
		
		if(empty($_GET)) {//判断POST来的数组是否为空
			return false;
		}
		else {
			//生成签名结果
			$isSign = $this->getSignVeryfy($_GET, $_GET["sign"]);
			//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息�&#65533;
			$responseTxt = 'true';
			if (! empty($_GET["notify_id"])) {$responseTxt = $this->getResponse($_GET["notify_id"]);}
			
			//写日志记�&#65533;
			if ($isSign) {
				$isSignStr = 'true';
			}
			else {
				$isSignStr = 'false';
			}
			$log_text = "responseTxt=".$responseTxt."\n return_url_log:isSign=".$isSignStr.",";
			$log_text = $log_text.createLinkString($_GET);
			//logResult($log_text);
			
			//验证
			//$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
			//isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有�&#65533;
			if (preg_match("/true$/i",$responseTxt) && $isSign) {
				return true;
			} else {
				return false;
			}
		}
	}
	
    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结�&#65533;
     * @return 签名验证结果
     */
	function getSignVeryfy($para_temp, $sign) {
		//writelog("myerror","错误信息.getSignVeryfy");
		//writelog("myerror","错误信息.getSignVeryfy".$this->alipay_config['ali_public_key_path']);		
		unset($para_temp['_URL_']); 
		//除去待签名参数数组中的空值和签名参数
		$para_filter = paraFilter($para_temp);
		
		//对待签名参数数组排序
		$para_sort = argSort($para_filter);
		
		//把数组所有元素，按照“参�&#65533;=参数值”的模式用�&#65533;&”字符拼接成字符�&#65533;
		$prestr = createLinkstring($para_sort);
		//writelog("myerror","错误信息--prestr".$prestr);
		$isSgin = false;
		switch (strtoupper(trim($this->alipay_config['sign_type']))) {
			case "RSA" :
				$isSgin = rsaVerify($prestr, trim($this->alipay_config['ali_public_key_path']), $sign);
				break;
			default :
				$isSgin = false;
		}
		
		return $isSgin;
	}

    /**
     * 获取远程服务器ATN结果,验证返回URL
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空 
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
	function getResponse($notify_id) {
		$transport = strtolower(trim($this->alipay_config['transport']));
		$partner = trim($this->alipay_config['partner']);
		$veryfy_url = '';
		if($transport == 'https') {
			$veryfy_url = $this->https_verify_url;
		}
		else {
			$veryfy_url = $this->http_verify_url;
		}
		$veryfy_url = $veryfy_url."partner=" . $partner . "&#172;ify_id=" . $notify_id;
		$responseTxt = getHttpResponseGET($veryfy_url, $this->alipay_config['cacert']);
		
		return $responseTxt;
	}
}
?>