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
        $session_goods_id = md5($goods['id'].microtime(true));
        session('sess_gid_'.$goods['id'],$session_goods_id);
        $this->assign('session_goods_id', $session_goods_id);

        $session_sign_id = md5($this->users['id'].microtime(true));
        session('sess_id_'.$this->users['id'], $session_sign_id);
        $this->assign('session_sign_id', $session_sign_id);
        $this->assign('goods', $goods);
        $this->assign('users', $user);
        $this->display();
    }

    public function exchange(){
        $goods_id = I('goods_id',0,'intval');
        $sess_id = I('sess_id','','strval');
        $json = $this->getJson();
        do{
            if(empty($sess_id) || session('sess_gid_'.$goods_id) != $sess_id){
                $json['msg_code'] = 1001;
                $json['msg_content'] = '验证失败, 请刷新后再操作~';
                break;
            }

            if(empty($goods_id)){
                $json['msg_code'] = 1002;
                $json['msg_content'] = '请输入兑换商品';
                break;
            }
            $goods = M('goods')->where(array('id'=>$goods_id))->find();
            if(! $goods){
                $json['msg_code'] = 1003;
                $json['msg_content'] = '没有找到兑换商品';
                break;
            }

            if($goods['credit'] > $this->users['credit']){
                $json['msg_code'] = 1003;
                $json['msg_content'] = '没有足够的积分兑换该商品~';
                break;
            }
            unset($_SESSION['sess_gid_'.$goods_id]);
            // `user_id`, `goods_id`, `credit`, `user_name`, `user_phone`, `user_qq`, `user_wechat`, `user_address`, `create_time`, `address_id`, `status`
            $data = [
                'user_id' => $this->users['id'],
                'goods_id' => $goods_id,
                'credit' => $goods['credit'],
                'create_time' => time()
            ];
            $res = M('goods_exchange_record')->add($data);
            if($res){

                $json['msg_content'] = '操作成功';
                break;
            }else{
                $json['msg_code'] = 1004;
                $json['msg_content'] = '兑换失败~ 请刷新后再试~';
                break;
            }
        }while(false);
        $this->ajaxReturn($json);
    }

    /**
     * 用户积分
     */
    public function credit(){
        $user_id = I('user_id',0,'intval');
        $sess_id = I('sess_id','','strval');
        $json = $this->getJson();
        do{
            if(empty($sess_id) || session('sess_id_'.$user_id) != $sess_id){
                $json['msg_code'] = 1001;
                $json['msg_content'] = '验证失败';
                break;
            }

            if($user_id == $this->users['id']){
                $json['msg_code'] = 1002;
                $json['msg_content'] = '不能给自己点赞';
                break;
            }
            $user = M('user_sign')->where(array('from_user_id'=>$this->users['id'], 'to_user_id'=>$user_id))->find();
            if($user){
                $json['msg_code'] = 1003;
                $json['msg_content'] = '已经点过赞';
                break;
            }
            unset($_SESSION['sess_id_'.$user_id]);
            $data = [
                'from_user_id' => $this->users['id'],
                'openid' => $this->openid,
                'to_user_id' => $user_id,
                'addtime' => time()
            ];
            $res = M('user_sign')->add($data);
            if($res){

                $json['msg_content'] = '操作成功';
                break;
            }else{
                $json['msg_code'] = 1004;
                $json['msg_content'] = '点赞失败~ 请刷新后再试~';
                break;
            }

        }while(false);
        $this->ajaxReturn($json);
    }

}