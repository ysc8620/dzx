<?php

namespace Admin\Controller;

use Think\Controller;
use Think\Page;

class SignController extends BaseController
{
    /**
     * 微信openid信息
     */
    public function index()
    {
        $sign = M('user_sign'); // 实例化User对象
        $count = $sign->count();// 查询满足要求的总记录数
        $Page = new Page($count, 20);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $sign->order('addtime DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach($list as $i=>$item){
            $from_user = M('users')->where(array('openid'=>$item['openid']))->find();
            $to_user = M('users')->where(array('id'=>$item['to_user_id']))->find();
            $list[$i]['from_user_name'] = $from_user['wx_name'];
            $list[$i]['to_user_name'] = $to_user['wx_name'];

        }
        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display();
    }

    /**
     *
     */
    public function edit()
    {
        $id = I('id',0,'intval');
        $model = M('user_sign')->find($id);
        $this->assign('userSign', $model);
        $this->display();
    }
}