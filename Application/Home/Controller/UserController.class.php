<?php
namespace Home\Controller;
use Weixin\MyWechat;
use Home\Model\UsersModel;
use Redis\MyRedis;

class UserController extends BaseController {

    /**
     *
     */
    public function index(){
        $id = I('id',0,'strval');
        $goods = M('goods')->order("weight DESC")->find();
        $this->assign('id', $id);
        $user = D('users')->get_user($id?$id:$this->openid);

        $this->assign('goods', $goods);
        $this->assign('users', $user);
        $this->display();
    }

}