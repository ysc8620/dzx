<?php
namespace Weixin;
use Redis\MyRedis;

class MyWechat extends Wechat{

    /**
	 * 设置缓存，按需重载
	 * @param string $cachename
	 * @param mixed $value
	 * @param int $expired
	 * @return boolean
	 */
	protected function setCache($cachename,$value,$expired){
		// return true;
		$data = array(
			'data' => $value,
			'expired' => time() + $expired
		);
		$file = './'.$cachename.'.log';
		$fp = fopen($file, "w");
		fwrite($fp, json_encode($data));
		fclose($fp);
	}

	/**
	 * 获取缓存，按需重载
	 * @param string $cachename
	 * @return mixed
	 */
	protected function getCache($cachename){
		$file = './'.$cachename.'.log';
		$info = file_get_contents($file);
		if($info){
			$data = json_decode($info, true);
		}else{
			$data = array();
		}

		return (int)$data['expired'] > time() ?$data['data']:false;
	}

	/**
	 * 清除缓存，按需重载
	 * @param string $cachename
	 * @return boolean
	 */
	protected function removeCache($cachename){
		// return true;
		$data = array();
		$file = './'.$cachename.'.log';
		$fp = fopen($file, "w");
		fwrite($fp, json_encode($data));
		fclose($fp);
		return true;
	}
}