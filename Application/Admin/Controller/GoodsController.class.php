<?php

namespace Admin\Controller;


use Think\Page;

class GoodsController extends BaseController
{
    /**
     * 微信openid信息
     */
    public function index()
    {
        $city = M('goods'); // 实例化User对象
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
     * 商品编辑
     */
    public function edit(){
        $id = I('id',0,'intval');
        if(IS_POST){
            $id = I('id',0,'intval');
            $data = $_POST;
            if($id){

                $data['update_time'] = time();
                $res = M('goods')->where(array('id'=>$id))->save($data);
            }else{
                $data['create_time'] = time();
                $data['update_time'] = time();
                $res = M('goods')->add($data);
            }

            if($res){
                return $this->success('编辑成功',U('goods/index'));
            }else{
                return $this->error('编辑失败',U('goods/edit',array('id'=>$id)));
            }
        }

        $goods = [];
        if($id){
            $goods = M('goods')->where(array('id'=>$id))->find();
        }

        $this->assign('goods', $goods);

        $this->display();
    }

    /**
     * 兑换记录
     */
    public function exchange(){

        $city = M('goods_exchange_record'); // 实例化User对象
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
     * 兑换编辑
     */
    public function exedit(){

    }

}