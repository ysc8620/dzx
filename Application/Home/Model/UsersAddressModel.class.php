<?php
namespace Home\Model;
use Redis\MyRedis;


/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/6/6
 * Time: 16:15
 */
class UsersAddressModel extends BaseModel
{
    protected $tableName = 'users_address';

    /**
     * 添加用户信息
     * @param $data
     * @return mixed
     */
    public function add_user_address($data){
        $data['create_time'] = time();
        return $this->add($data);
    }

    /**
     * 通过条件获取用户地址
     * @param $where
     */
    public function find_user_address($where=array()){
        return $this->where($where)->find();
    }

    /**
     * 获取公众号用户
     * @param int $city_id
     * @return bool|mixed
     */
    public function get_user_address($id){
        if(empty($id)) return false;
        $key = 't_users_address_'.$id;
        $data = MyRedis::getProInstance()->new_get($key);
        if(!$data){
            $data = $this->find($id);
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
    public function update_user_address($id, $data){
        $key = 't_users_address_'.$id;
        if(empty($id)) return false;
        $data['update_time'] = time();
        $this->where(array('id'=>$id))->save($data);
        MyRedis::getProInstance()->delete($key);

        return true;
    }
}