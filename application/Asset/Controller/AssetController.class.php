<?php

/**
 * 附件上传
 */
namespace Asset\Controller;
use Common\Controller\AdminbaseController;
class AssetController extends AdminbaseController {


    function _initialize() {
    	$adminid=sp_get_current_admin_id();
    	$userid=sp_get_current_userid();
    	if(empty($adminid) && empty($userid)){
    		//exit("非法上传！");
    	}
    }
    public function preview(){
        \Think\Log::write(json_encode($_POST));
    }
    /**
     * swfupload 上传 
     */
    public function swfupload() {
        header('Access-Control-Allow-Origin: *');
//        if (IS_POST) {
			
            //上传处理类
            $config=array(
            		'rootPath' => './'.C("UPLOADPATH"),
            		'savePath' => '',
            		'maxSize' => 18048576,
            		'saveName'   =>    array('uniqid',''),
            		'exts'       =>    array('jpg', 'gif', 'png', 'jpeg',"txt",'zip','apk','docx','doc' ),
            		'autoSub'    =>    false,
            );
			$upload = new \Think\Upload($config);// 
			$info=$upload->upload();
            //开始上传
            if ($info) {
                //上传成功
                //写入附件数据库信息
                $first=array_shift($info);
                if(!empty($first['url'])){
                	$url=$first['url'];
                }else{
                	$url=C("TMPL_PARSE_STRING.__UPLOAD__").$first['savename'];
                }
                
				//echo "1," . $url.",".'1,'.$first['name'];
                echo json_encode(array("status"=>1,"url"=>$url));
				exit;
            } else {
                //上传失败，返回错误
               // exit("0," . $upload->getError());
                echo json_encode(array("status"=>0,"url"=> $upload->getError()));
                exit;
            }
//        } else {
//            $this->display(':swfupload');
//        }
    }

}
