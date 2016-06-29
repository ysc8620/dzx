<?php
namespace Home\Controller;
use Weixin\MyWechat;
use Home\Model\UsersModel;
use Redis\MyRedis;

class IndexController extends BaseController {

    /**
     *
     */
    public function index(){

        $this->display();
    }

    /**
     *
     */
    public function test(){
        $d = new MyWechat(['appid'=>'123123','appsecret'=>'234234234']);

    }
}