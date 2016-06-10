<?php
namespace Home\Model;
use Redis\MyRedis;


/**
 * 注册用户管理
 *
 * Created by PhpStorm.
 * User: @shengyue
 * Date: 2016/6/6
 * Time: 16:15
 */
class UsersMemberModel extends BaseModel
{
    protected $tableName = 'users_member';

    /**
     * 添加手机用户
     *
     * @param $data
     * @return bool|mixed
     */
    public function add_user_member($data){
        $mobile = $data['mobile'];

        if(empty($mobile)) return false;

        $data['create_time'] = time();
        return $this->add($data);
    }

    /**
     * 获取注册用户
     * @param $id
     * @return bool|mixed
     */
    public function get_user_member($id){
        if(empty($id)) return false;
        $key = 't_users_member_'.$id;
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
     * 通过手机获取注册用户
     *
     * @param int $city_id
     * @return bool|mixed
     */
    public function get_user_member_by_mobile($mobile){
        if(empty($mobile)) return false;
        $key = 't_users_member_m_'.$mobile;
        $data = MyRedis::getProInstance()->new_get($key);
        if(!$data){
            $data = $this->where(array('mobile'=>$mobile))->find();
            if($data){
                MyRedis::getProInstance()->new_set($key, $data);
            }
        }

        return $data;
    }

    /**
     * 更新注册用户信息
     * @param $openid
     * @param $data
     */
    public function update_user_member($id, $data){
        if(empty($id)) return false;
        $key = 't_users_member_'.$id;
        $data['update_time'] = time();
        $this->where(array('id'=>$id))->save($data);
        MyRedis::getProInstance()->delete($key);
        return true;
    }

}