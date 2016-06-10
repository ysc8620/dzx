<?php
/**
 * Created by PhpStorm.
 * User: ShengYue
 * Date: 2016/6/6
 * Time: 11:20
 */

/**
 * 获取自动分表名
 *
 * @param $table
 * @param $userid
 * @param int $n
 * @return string
 */
function get_hash_table($table,$userid,$n=9) {
    $str = abs(crc32($userid));
    $hash = intval($str / $n);
    $hash = intval(fmod($hash, $n));

    return $table."_".($hash+1);
}

/**
 * 生成链接重写
 */
function tsurl($url='',$vars='',$suffix=true,$domain=false) {
    if($vars){
        if(is_array($vars)){
            if(!isset($vars['type'])){
                $vars['type'] = (int)$_GET['type'];
            }

            if(!isset($vars['from'])){
                $vars['from'] = (int)$_GET['from'];
            }
        }else{
            if(strstr($vars, 'type=') === false){
                $vars .= "&type=".intval($_GET['type']);
            }

            if(strstr($vars,'from=') === false){
                $vars .= "&from=".intval($_GET['from']);
            }
        }
    }
    return U($url,$vars,$suffix,$domain);
}