<?php

namespace Admin\Controller;

use Think\Controller;
use Think\Page;

class UsersController extends BaseController
{
    /**
     * 微信openid信息
     */
    public function index()
    {
        $city = M('users'); // 实例化User对象
        $count = $city->count();// 查询满足要求的总记录数
        $Page = new Page($count, 20);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $city->order('create_time DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display();
    }

    /**
     * 用户积分
     */
    public function edit(){
        $id = I('id',0,'intval');
        if(IS_POST){
            if($id){
                $credit = I('credit',0,'intval');
                $res = M('users')->where(array('id'=>$id))->save(array('credit'=>$credit));
                if($res){
                    return $this->success('编辑成功',U('users/index'));
                }
            }
            return $this->error('编辑失败',U('users/edit',array('id'=>$id)));
        }

        $users = M('users')->where(array('id'=>$id))->find();
        $this->assign('users', $users);
        $this->display();
    }



}