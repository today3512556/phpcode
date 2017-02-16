<?php
namespace Portal\Controller;
use Common\Controller\HomeBaseController;
class AlipayController extends HomeBaseController{
       //在类初始化方法中，引入相关类库  http://120.25.68.163/citytravel/index.php/portal/Alipay/doAlipay
    public function _initialize() {
        vendor('AlipayMobile.CoreFunction');
        vendor('AlipayMobile.Rsafunction');
        vendor('AlipayMobile.Notify');
        vendor('AlipayMobile.Submit');    
    }
    
    //doalipay方法
        /*该方法其实就是将接口文件包下alipayapi.php的内容复制过来
          然后进行相关处理
        */
    public function doAlipay(){
        $alipay_config=C('alipay_config'); 
        $orderNum="1235431312323";//商户订单号
        $sum="0.01";//交易金额
            //支付类型
        $payment_type = "1";
        //必填，不能修改
        $notify_url = C('alipay.notify_url'); //服务器异步通知页面路径
        $return_url = C('alipay.return_url'); //页面跳转同步通知页面路径
        //商户订单号
        $out_trade_no = $orderNum;//$_POST['WIDout_trade_no'];//必填
        //订单名称
        $subject = "购买商品";//必填
        //付款金额
        $total_fee = $sum;//$_POST['WIDtotal_fee'];//必填
        $show_url = "http://jxbnw.com";//$_POST['WIDshow_url'];//必填
        //订单描述
        //选填
        $body = $_POST['WIDbody'];
        //超时时间
        $it_b_pay = $_POST['WIDit_b_pay'];
        //钱包token
        $extern_token = $_POST['WIDextern_token'];
        /************************************************************/
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service"       =>"create_direct_pay_by_user",
            "partner"       => $alipay_config['partner'],
            "seller_id"  => $alipay_config['seller_id'],
            "payment_type"  => $payment_type,
            "notify_url"	=>$notify_url,
            "return_url"	=> $return_url,

            "anti_phishing_key"=>$alipay_config['anti_phishing_key'],
            "exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
            //如"参数名"=>"参数值"

        );
       // print_r($parameter); exit;
        //建立请求
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }
        /******************************
        服务器异步通知页面方法
        其实这里就是将notify_url.php文件中的代码复制过来进行处理
        
        *******************************/
    function notifyUrl(){
        header("Content-type: text/html; charset=utf-8");
        $alipay_config=C('alipay_config'); 
       //计算得出通知验证结果
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        $order = array();
        if($verify_result) {
            
            echo "success";     //请不要修改或删除
        }
        else {
            //验证失败
            echo "fail";
        }
    }
    
    /*
        页面跳转处理方法；
        这里其实就是将return_url.php这个文件中的代码复制过来，进行处理； 
        */
    function returnUrl(){
        header("Content-type: text/html; charset=utf-8");
        $alipay_config=C('alipay_config'); 
        $order = array();
        unset($_GET['_URL_']);
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn(); 
        if($verify_result) {//验证成功

            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                
            }
            else {
              echo "trade_status=".$_GET['trade_status'];
            }
                
            echo "验证成功<br />";
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }
 
}
?>