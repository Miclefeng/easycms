<?php

/**
 * Created by PhpStorm.
 * User: micle
 * Date: 2017/8/21
 * Time: 10:28
 */
class Common_Redis
{
    private static $_instance;

    private static $_redisHandle = [];

    private static $_defaultconf = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'db' => 0,
        'persistent' => 1,
        'timeout' => 2
    ];

    private $_conConf;

    protected function __construct()
    {
        if (!extension_loaded('redis')) {
            throw new Exception("redis is not exist!");
        }
    }

    /**
     * 获取redis链接
     * @return mixed
     * @throws Exception
     */
    public static function connect()
    {
        // instance
        (!(self::$_instance instanceof self)) && self::$_instance = new self();

        // basic parameter chk
        if (($args_num = func_num_args()) === 1 && is_array($param = func_get_arg(0))) {
            self::$_instance->_conConf = $param;
        } else {
            if (func_num_args() === 0 || is_null(func_get_arg(0))) {
                self::$_instance->_conConf = self::$_defaultconf;
            } else {
                throw new Exception("incorrect parameter(s)!");
            }
        }

        return self::$_instance->_link();
    }

    /**
     * 创建redis链接
     * @return mixed
     */
    private function _link()
    {
        if (!isset($this->_conConf['host']) || empty($this->_conConf['host'])) {
            $this->_conConf['host'] = self::$_defaultconf['host'];
        }

        if (!isset($this->_conConf['port']) || empty($this->_conConf['port'])) {
            $this->_conConf['port'] = self::$_defaultconf['port'];
        }

        if (!isset($this->_conConf['db']) || !is_numeric($this->_conConf['db'])) {
            $this->_conConf['db'] = self::$_defaultconf['db'];
        }

        if (!isset($this->_conConf['persistent']) || !is_numeric($this->_conConf['persistent'])) {
            $this->_conConf['persistent'] = self::$_defaultconf['persistent'];
        }

        if (!isset($this->_conConf['timeout']) || empty($this->_conConf['timeout'])) {
            $this->_conConf['timeout'] = self::$_defaultconf['timeout'];
        }

        $k = $this->_make_redis_key([$this->_conConf['host'], $this->_conConf['port']]);

        if (!isset(self::$_redisHandle[$k]) || get_resource_type(self::$_redisHandle[$k]) !== 'redis') {
            $redis = new \Redis();

            if (1 == $this->_conConf['persistent']) {
                $redis->pconnect($this->_conConf['host'], $this->_conConf['port'], $this->_conConf['timeout']);
            } else {
                $redis->connect($this->_conConf['host'], $this->_conConf['port'], $this->_conConf['timeout']);
            }

            $redis->select($this->_conConf['db']);
            self::$_redisHandle[$k] = $redis;
        }

        return self::$_redisHandle[$k];
    }

    /**
     * 生成 redis instance key
     * @param array $data
     * @return string
     */
    private function _make_redis_key($data = [])
    {
        return ucwords(implode("_", $data));
    }
}