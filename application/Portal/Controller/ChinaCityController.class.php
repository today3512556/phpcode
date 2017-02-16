<?php
namespace Portal\Controller;
use Think\Controller;
/**
 * ChinaCityController
 */
class ChinaCityController extends Controller {
	/**
 * 全国城市乡镇信息模型
 */
	public function _list($map){
		$order = 'id ASC';
		$data = $this->where($map)->order($order)->select();
		return $data;
	}
   //获取中国省份信息
	public function getProvince(){
		if (IS_AJAX){
			$pid = I('pid');  //默认的省份id

			if( !empty($pid) ){
				$map['id'] = $pid;
			}
			$map['level'] = 1;
			$map['upid'] = 0;
			$plugin_demo_model=D("Common/District");
			$list = $plugin_demo_model->_list($map);

			$data = "<option value =''>-省份-</option>";
			foreach ($list as $k => $vo) {
				$data .= "<option ";
				if( $pid == $vo['id'] ){
					$data .= " selected ";
				}
				$data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
			}
			$this->ajaxReturn($data);
		}
	}

	//获取城市信息
	public function getCity(){
		if (IS_AJAX){
			$cid = I('cid');  //默认的城市id
			$pid = I('pid');  //传过来的省份id

			if( !empty($cid) ){
				$map['id'] = $cid;
			}
			$map['level'] = 2;
			$map['upid'] = $pid;

			$list = D("Common/District")->_list($map);

			$data = "<option value =''>-城市-</option>";
			foreach ($list as $k => $vo) {
				$data .= "<option ";
				if( $cid == $vo['id'] ){
					$data .= " selected ";
				}
				$data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
			}
			$this->ajaxReturn($data);
		}
	}

	//获取区县市信息
	public function getDistrict(){
		if (IS_AJAX){
			$did = I('did');  //默认的城市id
			$cid = I('cid');  //传过来的城市id

			if( !empty($did) ){
				$map['id'] = $did;
			}
			$map['level'] = 3;
			$map['upid'] = $cid;

			$list = D("Common/District")->_list($map);

			$data = "<option value =''>-州县-</option>";
			foreach ($list as $k => $vo) {
				$data .= "<option ";
				if( $did == $vo['id'] ){
					$data .= " selected ";
				}
				$data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
			}
			$this->ajaxReturn($data);
		}
	}
	//获取区县市信息
	public function getDistrictByCityName(){
		if (IS_AJAX){
			$name = I('name');  //默认的城市id
			
			session('name',$name);
			if( !empty($name) ){
				$map['name'] = array("like","%".$name."%");
			}
			
			$cid=M("District")->where($map)->getField("id");
			
			if($cid){
				$map1['upid'] = $cid;
			}
			$map1['level'] = 3;
			$list = D("Common/District")->_list($map1);

			$data = "<option value ='0'>全部</option>";
			foreach ($list as $k => $vo) {
				$data .= "<option ";
				if( $did == $vo['id'] ){
					$data .= " selected ";
				}
				$data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
			}
			$this->ajaxReturn($data);
		}
	}
	//获取乡镇信息
	public function getCommunity(){
		if (IS_AJAX){
			$coid = I('coid');  //默认的乡镇id
			$did = I('did');  //传过来的区县市id

			$where['city_id'] = $cid;

			if( !empty($coid) ){
				$map['id'] = $coid;
			}
			$map['level'] = 4;
			$map['upid'] = $did;

			$list =D("Common/District")->_list($map);

			$data = "<option value =''>-乡镇-</option>";
			foreach ($list as $k => $vo) {
				$data .= "<option ";
				if( $did == $vo['id'] ){
					$data .= " selected ";
				}
				$data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
			}
			$this->ajaxReturn($data);
		}
	}
}