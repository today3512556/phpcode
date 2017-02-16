<?php
namespace Portal\Controller;

use Think\Controller;

/** * ChinaCityController */
class ChinaCityTwoController extends Controller
{
    public function _list($map)
    {
        $order = 'id ASC';
        $data = $this->where($map)->order($order)->select();
        return $data;
    }

    public function getProvince()
    {
        if (IS_AJAX) {
            $pid = I('pid');
            if (!empty($pid)) {
                $map['id'] = $pid;
            }
            $map['level'] = 1;
            $map['upid'] = 0;
            $plugin_demo_model = D("Common/District");
            $list = $plugin_demo_model->_list($map);
            $data = "<option value =''>-省份-</option>";
            foreach ($list as $k => $vo) {
                $data .= "<option ";
                if ($pid == $vo['id']) {
                    $data .= " selected ";
                }
                $data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
            }
            $this->ajaxReturn($data);
        }
    }

    public function getCity()
    {
        if (IS_AJAX) {
            $cid = I('cid');
            $pid = I('pid');
            if (!empty($cid)) {
                $map['id'] = $cid;
            }
            $map['level'] = 2;
            $map['upid'] = $pid;
            import("Tree");
            $tree = new \Tree();
            $parentid = $pid;
            $result = D("Common/District")->select();
            $data = "<option value =''>-城市-</option>";
            foreach ($result as $r) {
                $r['parentid'] = $r['upid'];
                $r['selected'] = $r['id'] == $parentid ? 'selected' : '';
                $array[] = $r;
            }
            $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
            $tree->init($array);
            $select_categorys = $tree->get_tree(0, $str);
            $this->ajaxReturn($data . $select_categorys);
        }
    }

    public function getLandscape()
    {
        if (IS_AJAX) {
            $pid = I('id');
            $data = "<option value =''>-景区-</option>";
            $result = M("landscape")->select();
            if ($result) {
                $str = '';
                foreach ($result as $k => $v) {
                    if ($pid) {
                        if ($pid == $v['id']) {
                            $str .= "<option value='$v[id]' selected> $v[name]</option>";
                        } else {
                            $str .= "<option value='$v[id]' > $v[name]</option>";
                        }
                    } else {
                        $str .= "<option value='$v[id]' > $v[name]</option>";
                    }
                }
            }
            $this->ajaxReturn($data . $str);
        }
    }

    public function getDistrict()
    {
        if (IS_AJAX) {
            $did = I('did');
            $cid = I('cid');
            if (!empty($did)) {
                $map['id'] = $did;
            }
            $map['level'] = 3;
            $map['upid'] = $cid;
            $list = D("Common/District")->_list($map);
            $data = "<option value =''>-州县-</option>";
            foreach ($list as $k => $vo) {
                $data .= "<option ";
                if ($did == $vo['id']) {
                    $data .= " selected ";
                }
                $data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
            }
            $this->ajaxReturn($data);
        }
    }

    public function getDistrictByCityName()
    {
        if (IS_AJAX) {
            $name = I('name');
            session('name', $name);
            if (!empty($name)) {
                $map['name'] = array("like", "%" . $name . "%");
            }
            $cid = M("District")->where($map)->getField("id");
            if ($cid) {
                $map1['upid'] = $cid;
            }
            $map1['level'] = 3;
            $list = D("Common/District")->_list($map1);
            $data = "<option value ='0'>全部</option>";
            foreach ($list as $k => $vo) {
                $data .= "<option ";
                if ($did == $vo['id']) {
                    $data .= " selected ";
                }
                $data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
            }
            $this->ajaxReturn($data);
        }
    }

    public function getCommunity()
    {
        if (IS_AJAX) {
            $coid = I('coid');
            $did = I('did');
            $where['city_id'] = $cid;
            if (!empty($coid)) {
                $map['id'] = $coid;
            }
            $map['level'] = 4;
            $map['upid'] = $did;
            $list = D("Common/District")->_list($map);
            $data = "<option value =''>-乡镇-</option>";
            foreach ($list as $k => $vo) {
                $data .= "<option ";
                if ($did == $vo['id']) {
                    $data .= " selected ";
                }
                $data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
            }
            $this->ajaxReturn($data);
        }
    }
}