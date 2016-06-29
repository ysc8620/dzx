<?php
namespace Home\Model;


/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/6/6
 * Time: 16:15
 */
class UsersModel extends BaseModel
{
    protected $tableName = 'users';

    public function add_user($data){
        $openid = $data['openid'];

        if(empty($openid)) return false;

        $data['create_time'] = time();
        return $this->add($data);
    }
    /**
     * 获取公众号用户
     * @param int $city_id
     * @return bool|mixed
     */
    public function get_user($openid){
        if(empty($openid)) return false;
        $data = $this->where(array('openid'=>$openid))->find();
        return $data;
    }

    /**
     * 更新用户信息
     * @param $openid
     * @param $data
     */
    public function update_user($openid, $data)
    {
        if (empty($openid)) return false;

        $this->where(array('openid' => $openid))->save($data);
        return true;
    }

    /**
     * @param $from_openid
     * @param $to_user
     */
    public function get_sign($from_openid, $to_user){
        return M('users_sign')->where(array('openid'=>$from_openid, 'to_user_id'=>$to_user))->find();
    }

    /**
     * 签到
     */
    public function sign($data){
        $where = array('openid'=>$data['openid'], 'to_user_id'=>$data['to_user_id']);
        $is_have = M('users_sign')->where($where)->find();
        if($is_have){
            return false;
        }

        $res = M('users_sign')->add($data);
        if($res){
            $this->execute("UPDATE ".C('DB_PREFIX')."users SET credit=credit+1 WHERE id='{$data['to_user_id']}'");
        }
        return true;
    }


}