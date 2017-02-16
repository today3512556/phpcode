<?php

/**
 * 会员
 */
namespace User\Controller;
use Common\Controller\AdminbaseController;
class IndexadminController extends AdminbaseController {
    function index(){
    	$users_model=M("Users");
		$where_ands=array(" user_type = 2 ");
		$fields=array(
			'start_time'=> array("field"=>"create_time","operator"=>">"),
			'end_time'  => array("field"=>"create_time","operator"=>"<"),
			'keyword'  => array("field"=>"user_login","operator"=>"like"),
		);
		if(IS_POST){

			foreach ($fields as $param =>$val){
				if (isset($_POST[$param]) && !empty($_POST[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_POST[$param];
					$_GET[$param]=$get;
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
		}else{
			foreach ($fields as $param =>$val){
				if (isset($_GET[$param]) && !empty($_GET[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_GET[$param];
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
		}

		$where= join(" and ", $where_ands);

    	$count=$users_model->where($where)->count();
    	$page = $this->page($count, 20);
    	$lists = $users_model
    	->where($where)
    	->order("create_time DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
		if($lists){
			$order_model=M("order");
			foreach($lists as $k=>&$v){
				if($v['user_login']){
					$where2['helpBookPhone|phone']=$v['user_login'];
					$where2['status']="5";
					$v['ordercount']=$order_model->where($where2)->count();
				}else{
					$v['ordercount']=0;
				}

			}
		}
		$this->assign("formget",$_GET);
    	$this->assign('lists', $lists);
    	$this->assign("page", $page->show('Admin'));
    	
    	$this->display(":index");
    }
	function setworker(){
		$id=intval(I("id"));
		$is_worker=intval(I("is_worker"));
		$users_model=M("Users");
		$rst=$users_model->where(array("id"=>$id,"user_type"=>2))->setField('is_worker',$is_worker);
		if ($rst) {
			$this->success("设置成功！");
		} else {
			$this->error('设置失败！');
		}
	}
    function ban(){
    	$id=intval($_GET['id']);
    	if ($id) {
    		$rst = M("Users")->where(array("id"=>$id,"user_type"=>2))->setField('user_status','0');
    		if ($rst) {
    			$this->success("会员拉黑成功！", U("indexadmin/index"));
    		} else {
    			$this->error('会员拉黑失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
    
    function cancelban(){
    	$id=intval($_GET['id']);
    	if ($id) {
    		$rst = M("Users")->where(array("id"=>$id,"user_type"=>2))->setField('user_status','1');
    		if ($rst) {
    			$this->success("会员启用成功！", U("indexadmin/index"));
    		} else {
    			$this->error('会员启用失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
}
