<?php
namespace Home\Model;
use Redis\MyRedis;


/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/6/6
 * Time: 16:15
 */
class UsersUnionModel extends BaseModel
{
    protected $tableName = 'users_union';

    public function add_user_union($data){
        $unionid = $data['unionid'];

        if(empty($unionid)) return false;

        $data['create_time'] = time();
        return $this->add($data);
    }

    /**
     * 获取公众号用户
     * @param int $city_id
     * @return bool|mixed
     */
    public function get_user_union($unionid){
        if(empty($unionid)) return false;
        $key = 't_users_union_'.$unionid;
        $data = MyRedis::getProInstance()->new_get($key);
        if(!$data){
            $data = $this->where(array('unionid'=>$unionid))->find();
            if($data){
                MyRedis::getProInstance()->new_set($key, $data);
            }
        }

        return $data;
    }

    /**
     * 更新用户信息
     * @param $openid
     * @param $data
     */
    public function update_user_union($unionid, $data){
        $key = 't_users_union_'.$unionid;
        if(empty($unionid)) return false;

        $data['update_time'] = time();
        $this->where(array('unionid'=>$unionid))->save($data);
        MyRedis::getProInstance()->delete($key);

        return true;
    }

    /**
     * 获取用户M币
     * @param array $where
     *  获取参数：unionid, uid
     */
    public function get_user_integral($where=array()){

    }

    /**
     * 用户消费M币 包括领取，消费
     * @param $data
     */
    public function consume_user_integral($where=array(), $data=array()){

    }

    /**
     * 获取用户金额
     * @param array $where
     */
    public function get_user_money($where=array()){

    }

    /**
     * 用户金额消费：包括获取，消费
     * @param array $where
     * @param array $data
     */
    public function consume_user_money($where=array(), $data=array()){

    }

    /**
     * 用户绑定手机生成唯一uid
     * @param $data
     */
    public function bind_user_mobile($data){

    }
}