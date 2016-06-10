<?php

/* 
 * add by allen 
 */
namespace Home\Model;
class LocalModel extends \Think\Model {
    static $adinstance = NULL;
    static $proinstance = NULL;
    static $tokeninstance = NULL;
    /**
     * 架构函数
     * @param array  广告缓存
     * @access public
     */
    public static  function getAdInstance() {        
        if (empty(self::$adinstance)) {
            $redis = new \Redis();
            $arr = C("AD_REDIS");            
            echo var_dump(C("AD_REDIS"));
            $redis->connect($arr[0], $arr[1], $arr[2]);
            var_dump($redis);
            $auth =$arr[3];
            if (!empty($auth)) {
                $redis->auth($auth);
            }
            self::$adinstance = $redis;
        }
        return self::$adinstance;
    }
    
     /**
     * 架构函数
     * @param array  产品缓存
     * @access public
     */
    public static  function getProInstance() {        
        if (empty(self::$proinstance)) {
            $redis = new \Redis();
            $arr = C("PRO_REDIS");            
            $redis->connect($arr[0], $arr[1], $arr[2]);
            var_dump($redis);
            $auth =$arr[3];
            if (!empty($auth)) {
                $redis->auth($auth);
            }
            self::$proinstance = $redis;
        }
        return self::$proinstance;
    }
    
        /**
     * 架构函数
     * @param array  token缓存 微信相关
     * @access public
     */
    public static  function getTokenInstance() {        
        if (empty(self::$tokeninstance)) {
            $redis = new \Redis();
            $arr = C("TOKEN_REDIS");            
            $redis->connect($arr[0], $arr[1], $arr[2]);
            var_dump($redis);
            $auth =$arr[3];
            if (!empty($auth)) {
                $redis->auth($auth);
            }
            self::$tokeninstance = $redis;
        }
        return self::$tokeninstance;
    }
    
    
    
    
}