<?php

namespace App\Services;

/**
 * Redis操作类
 * @author:wangben
 * date:2018-04-20
 */
class RedisService
{
	private static $redis    = null;
	private static $instance = [];

    /**
     * 初始化操作
     */
	public function __construct($config = [])
	{
		//Redis配置信息
		if ($config == 'REDIS_DEFAULT' || !is_array($config)) {
			$host     = '127.0.0.1';
			$port     = '6379';
			$auth     = '';
			$database = 0;
		} else {
			$host     = isset($config['host']) ? $config['host'] : '127.0.0.1';
			$port     = isset($config['port']) ? $config['port'] : '6379';
			$auth     = isset($config['password']) ? $config['password'] : '';
			$database = isset($config['database']) ? $config['database'] : 0;
		}

		self::$redis  = new \Redis();

		try {

			self::$redis->connect($host, $port);

			if ($auth) {
				self::$redis->auth($auth);
			}

			if ($database && $database <= 15 && $database >= 0) {
				self::$redis->select($database);
			}

		} catch (\Exception $e) {
            
			$info = [
				'code' => $e->getCode(),
                'msg'  => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'host' => $host,
                'port' => $port,
                'auth' => $auth,
                'db'   => $database,
			];

			return false;
		}

		return self::$redis;
	}

    /**
     * 获得Redis对象
     */
	public static function getInstance($config = 'REDIS_DEFAULT')
	{
		//连接Redis唯一标示(根据Redis配置文件)
		$config_id = md5(var_export($config, true));

		if (!isset(self::$instance[$config_id]) || !(self::$instance[$config_id] instanceof self)) {
			self::$instance[$config_id] = new self($config);
		}

		return self::$instance[$config_id];
	}

    /**
     * 普通调用Redis操作
     */
	public function __call($method, $param)
	{
		return self::call($method, $param);
	}

    /**
     * 静态调用Redis操作
     */
	public static function __callStatic($method, $param)
	{
		return self::call($method, $param);
	}

    /**
     * 忽略过滤Redis操作方法
     */
	private static function ignoreMethod($method)
	{
		$list = [
			'flushall',
			'flushdb',
		];

		if (in_array(strtolower($method), $list)) {
			return true;
		}

		return false;
	}

    /**
     * Redis透明调用
     */
	private static function call($method, $param)
	{
		if (self::ignoreMethod($method)) {
			return false;
		}

		return call_user_func_array([self::$redis, $method], $param);
	}
}