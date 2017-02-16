<?php
define('ALIPAY_URL', '');//配置域名
if(file_exists("data/conf/db.php")){
	$db=include "data/conf/db.php";
}else{
	$db=array();
}
if(file_exists("data/conf/config.php")){
	$runtime_config=include "data/conf/config.php";
}else{
	$runtime_config=array();
}
$configs= array(
	"LOAD_EXT_FILE"=>"extend",
	'UPLOADPATH' => 'data/upload/',
	//'SHOW_ERROR_MSG'        =>  true,    // 显示错误信息
	'SHOW_PAGE_TRACE'		=> false,
	'TMPL_STRIP_SPACE'		=> true,// 是否去除模板文件里面的html空格与换行
	'THIRD_UDER_ACCESS'		=> false, //第三方用户是否有全部权限，没有则需绑定本地账号
	/* 标签库 */
	'TAGLIB_BUILD_IN' => HTSOFT_CORE_TAGLIBS,
	//'APP_GROUP_LIST'        => 'Admin,Portal,Asset,Api,Member,Wx,Toptic,Strap',      // 项目分组设定,多个组之间用逗号分隔,例如'Home,Admin'
	'MODULE_ALLOW_LIST'  => array('Htsoft','Portal','Asset','Api','User','Wx','Comment','Qiushi','Tpl','Topic','Install','Bug','Better','Pay','App','Shop'),
	'URL_MODULE_MAP'    =>    array('htsoft'=>'admin'),
	'TMPL_DETECT_THEME'     => false,       // 自动侦测模板主题
	'TMPL_TEMPLATE_SUFFIX'  => '.html',     // 默认模板文件后缀
	'DEFAULT_MODULE'        =>  'Portal',  // 默认模块
	'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
	'DEFAULT_ACTION'        =>  'index', // 默认操作名称
	'DEFAULT_M_LAYER'       =>  'Model', // 默认的模型层名称
	'DEFAULT_C_LAYER'       =>  'Controller', // 默认的控制器层名称

	'DEFAULT_FILTER'        =>  'htmlspecialchars', // 默认参数过滤方法 用于I函数...htmlspecialchars

	'LANG_SWITCH_ON'        => true,   // 开启语言包功能

	'VAR_MODULE'            =>  'g',     // 默认模块获取变量
	'VAR_CONTROLLER'        =>  'm',    // 默认控制器获取变量
	'VAR_ACTION'            =>  'a',    // 默认操作获取变量

	'APP_USE_NAMESPACE'     =>   true, // 关闭应用的命名空间定义
	'APP_AUTOLOAD_LAYER'    =>  'Controller,Model', // 模块自动加载的类库后缀

	'SP_TMPL_PATH'     		=> 'tpl/',       // 前台模板文件根目录
	'SP_DEFAULT_THEME'		=> 'simplebootx',       // 前台模板文件
	'SP_TMPL_ACTION_ERROR' 	=> 'error', // 默认错误跳转对应的模板文件,注：相对于前台模板路径
	'SP_TMPL_ACTION_SUCCESS' 	=> 'success', // 默认成功跳转对应的模板文件,注：相对于前台模板路径
	'SP_ADMIN_STYLE'		=> 'flat',
	'SP_ADMIN_TMPL_PATH'    => 'tpl_admin/',       // 各个项目后台模板文件根目录
	'SP_ADMIN_DEFAULT_THEME'=> 'htsoft_tpl_admin',       // 各个项目后台模板文件
	'SP_ADMIN_TMPL_ACTION_ERROR' 	=> 'Admin/error.html', // 默认错误跳转对应的模板文件,注：相对于后台模板路径
	'SP_ADMIN_TMPL_ACTION_SUCCESS' 	=> 'Admin/success.html', // 默认成功跳转对应的模板文件,注：相对于后台模板路径
	'TMPL_EXCEPTION_FILE'   => SPSTATIC.'exception.html',

	'AUTOLOAD_NAMESPACE' => array('plugins' => './plugins/'), //扩展模块列表

	'ERROR_PAGE'            =>'',//不要设置，否则会让404变302

	'VAR_SESSION_ID'        => 'session_id',

	"UCENTER_ENABLED"		=>0, //UCenter 开启1, 关闭0
	"COMMENT_NEED_CHECK"	=>0, //评论是否需审核 审核1，不审核0
	"COMMENT_TIME_INTERVAL"	=>60, //评论时间间隔 单位s

	/* URL设置 */
	'URL_CASE_INSENSITIVE'  => true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
	'URL_MODEL'             => 0,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
	// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式，提供最好的用户体验和SEO支持
	'URL_PATHINFO_DEPR'     => '/',	// PATHINFO模式下，各参数之间的分割符号
	'URL_HTML_SUFFIX'       => '',  // URL伪静态后缀设置

	'VAR_PAGE'				=>"p",

	'URL_ROUTER_ON'			=> true,

	/*性能优化*/

	'OUTPUT_ENCODE'			=>true,// 页面压缩输出

	'HTML_CACHE_ON'     =>    false, // 开启静态缓存
	'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
	'HTML_FILE_SUFFIX'  =>    '.html', // 设置静态缓存文件后缀
	'SitePath'=>'127.0.0.1/',
	'IpPath'=>'http://127.0.0.1',
	'PicPath'=>'/data/upload/',
	'TMPL_PARSE_STRING'=>array(
		'/Public/upload'=>'/data/upload',
		'__UPLOAD__' => __ROOT__.'/data/upload/',
		'__STATICS__' => __ROOT__.'/statics/',
	),
	//容联云短信配置
	'ACCOUNT_SID'=>"aaf98f894e3e5b81014e4d8c4b240f25",
	'ACCOUNT_TOKEN'=>"425a5e882a374ab28509c1e959467722",
	'APP_ID'=>"8a48b5514ecd7fa8014ed8974dc5109c",
	'SMSTMP_ID'=>"75203",
	'alipay_config' => array(
		// 合作者ID，财付通有该配置，开通财付通账户后给予
		'partner' => '2088221219352973',
		'seller_id' => '2088221219352973',
		'key'=>'idf5nsi5t0qbemwo12hztbftm53tbv6p',
		'private_key_path' =>getcwd().'/rsa_private_key.pem',
		'ali_public_key_path' => getcwd().'/alipay_public_key.pem',
		'sign_type' =>  strtoupper('RSA'),
		'input_charset' => strtolower('utf-8'),
		'cacert' => getcwd().'/cacert.pem',
		'transport' =>'http'
	),
	'alipay'   =>array(
		//这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
		'seller_email'=>'2163331412@qq.com',

		//这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
		'notify_url'=>ALIPAY_URL.'/index.php/Portal/Alipay/notifyUrl',

		//这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
		'return_url'=>ALIPAY_URL.'/index.php/Portal/Alipay/returnUrl',

	),
);

/* if(!APP_DEBUG){
	$configs['APP_STATUS']="release";
} */

return  array_merge($configs,$db,$runtime_config);
