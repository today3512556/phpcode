<?php

// define('UNIONPAY_URL', 'http://bannong.ibona.cn');
// cvn2加密 1：加密 0:不加密
const SDK_CVN2_ENC = 0;
// 有效期加密 1:加密 0:不加密
const SDK_DATE_ENC = 0;
// 卡号加密 1：加密 0:不加密
const SDK_PAN_ENC = 0;
 
// 签名证书路径
const SDK_SIGN_CERT_PATH = '/www/web/Public/cert/PM_700000000000001_acp.pfx';

// 签名证书密码
 const SDK_SIGN_CERT_PWD = '******';

// 密码加密证书
const SDK_ENCRYPT_CERT_PATH = '/www/web/Public/cert/encryptpub.cer';

// 验签证书路径（请配到文件夹，不要配到具体文件）
const SDK_VERIFY_CERT_DIR = '/www/web/Public/cert/';

// 前台请求地址
const SDK_FRONT_TRANS_URL = 'https://gateway.95516.com/gateway/api/frontTransReq.do';

// 后台请求地址
const SDK_BACK_TRANS_URL = 'https://gateway.95516.com/gateway/api/backTransReq.do';


//文件传输请求地址
const SDK_FILE_QUERY_URL = 'https://gateway.95516.com/';

const SDK_App_Request_Url="https://gateway.95516.com/gateway/api/appTransReq.do";

//有卡交易地址
const SDK_Card_Request_Url = 'https://gateway.95516.com/gateway/api/cardTransReq.do';


// 前台通知地址 (商户自行配置通知地址)
const SDK_FRONT_NOTIFY_URL = 'http://******/index.php/Mobile/UnionPay/createNote';
// 后台通知地址 (商户自行配置通知地址)
const SDK_BACK_NOTIFY_URL = 'http://*******/index.php/Mobile/UnionPay/sureNote';


//文件下载目录 
const SDK_FILE_DOWN_PATH = '/www/web/logs/';

//日志 目录 
const SDK_LOG_FILE_PATH = '/www/web/logs/';

//日志级别
const SDK_LOG_LEVEL = 'INFO';	
?>