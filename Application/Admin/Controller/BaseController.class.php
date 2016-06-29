<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
    public function _initialize(){
        /**
         * 验证登陆
         */
        if(! session('is_login')){
            return redirect(U('login/index'));
        }

        $this->admin = M('admin')->find(session('login_user_id'));
        if(!$this->admin){
            return redirect(U('login/index'));
        }

        $this->assign('admin', $this->admin);
    }

    public function getJson(){
        return [
            'msg_code' => 1000,
            'msg_content' => '',
            'msg_data' => ''
        ];
    }

}