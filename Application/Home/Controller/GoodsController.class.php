<?php
namespace Home\Controller;
use Think\Page;

class GoodsController extends BaseController {

    /**
     *
     */
    public function index(){
        $city = M('goods'); // 实例化User对象
        $count = $city->count();// 查询满足要求的总记录数
        $Page = new Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $city->order('create_time DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach($list as $i=>$item){
            $session_id = md5($item['id'].microtime(true));
            session('sess_gid_'.$item['id'], $session_id);
            $list[$i]['sess_id'] = $session_id;
        }
        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display();
    }
}