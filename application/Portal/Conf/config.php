<?php

if(file_exists("data/conf/route/portal.php")){
	$routes = include 'data/conf/route/portal.php';
}else{
	$routes = array();
}

$runtime_home_config= array();
$configs= array(
		'TAGLIB_BUILD_IN' => HTSOFT_CORE_TAGLIBS.',Portal\Lib\Taglib\Portal',
		'TMPL_EXCEPTION_FILE'   => SPSTATIC.'exception.html',// 异常页面的模板文件
		'TMPL_TEMPLATE_SUFFIX'  => '.html',     // 默认模板文件后缀
 		'TMPL_FILE_DEPR'        =>  '/', //模板文件MODULE_NAME与ACTION_NAME之间的分割符
		'URL_ROUTE_RULES' =>$routes,
		'TMPL_CACHE_ON'   => false,  // 默认开启模板编译缓存 false 的话每次都重新编译模板
		//'ACTION_CACHE_ON'  => false,  // 默认关闭Action 缓存
		'HTML_CACHE_ON'   => false,   // 默认关闭静态缓存
		'HTML_CACHE_RULES'  =>     array(  
		// 定义静态缓存规则     
		// 定义格式1 数组方式   
				'article:index'=>array('portal/article/{id}','0'),
				'index:index'=>array('portal/index','600'),
				'list:index'=>array('portal/list/{id}_{p}','60'),
		)
);

return  array_merge($configs,$runtime_home_config);
