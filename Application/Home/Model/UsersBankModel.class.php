<?php
namespace Home\Model;
use Redis\MyRedis;


/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/6/6
 * Time: 16:15
 */
class UsersBankModel extends BaseModel
{
    protected $tableName = 'users_bank';

    /**
     * 获取用户银行账户
     * @param int $city_id
     * @return bool|mixed
     */
    public function get_user_bank($data=array()){
        if(empty($data)) return false;

        $where = array();
        if(isset($data['uid'])){
            $where['uid'] = $data['uid'];
        }elseif(isset($data['union_id'])){
            $where['union_id'] = $data['union_id'];
        }else{
            return false;
        }

        return $this->where($where)->find();
    }

    /**
     * 用户消费M币
     * @param array $where = [
     *   'uid' => 用户唯一id
     *   'union_id' => 用户union_id
     * ]
     *
     * @param array $data = [
     *  openid
     *  user_openid_id
     *  user_union_id
     *  title
     *  uid
     *  city_id
     *  record_num
     * ]
     */
    public function consume_user_integral($where=array(), $data=array()){
        $where = array();
        if(isset($data['uid'])){
            $where['uid'] = $data['uid'];
        }elseif(isset($data['union_id'])){
            $where['union_id'] = $data['union_id'];
        }else{
            return false;
        }

        if($data['record_num'] > 0){
            $this->where($where)->setInc('total_integral', $data['record_num']);
        }elseif($data['record_num'] <= 0){
            $this->where($where)->setDec('total_integral', $data['record_num']);
        }else{
            return false;
        }

        // 增加日志
        if($data['user_union_id']){
            $table = get_hash_table('users_integral_record',$data['user_union_id']);

            M($table)->add($data);
        }elseif($data['uid']){
            $table = get_hash_table('users_integral_record',$data['uid']);

            M($table)->add($data);
        }
        return true;

    }

    /**
     * 用户消费金额
     * @param array $where = [
     *   'uid' => 用户唯一id
     *   'union_id' => 用户union_id
     * ]
     *
     * @param array $data = [
     *  openid
     *  user_openid_id
     *  user_union_id
     *  title
     *  uid
     *  city_id
     *  money
     * ]
     */
    public function consume_user_amount($data = array()){
        $where = array();
        if(isset($data['uid'])){
            $where['uid'] = $data['uid'];
        }elseif(isset($data['union_id'])){
            $where['union_id'] = $data['union_id'];
        }else{
            return false;
        }

        if($data['money'] > 0){
            $this->where($where)->setInc('total_amount', $data['money']);
        }elseif($data['money'] <= 0){
            $this->where($where)->setDec('total_amount', $data['money']);
        }else{
            return false;
        }

        // 增加日志
        if($data['user_union_id']){
            $table = get_hash_table('users_integral_record',$data['user_union_id']);
            M($table)->add($data);
        }elseif($data['uid']){
            $table = get_hash_table('users_integral_record',$data['uid']);

            M($table)->add($data);
        }
        return true;
    }

    /**
     * 重新初始化bank
     * 业务逻辑分析：
     * 用户第一次绑定手机只需要更新bank上面的 uid 字段
     * 用户第二次绑定手机需要把自己对应的unionid上的账户M币和钱转到第一次绑定的账户上，并且把自己对应的union账户停用
     * @param array $data = [
     *   'uid' => 用户唯一id
     *   'union_id' => 对应用户union_id
     *   'bind_union_id' => 绑定的uinon_id
     * ]
     */
    public function init_bank($data=array()){

    }
}