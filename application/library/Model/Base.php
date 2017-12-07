<?php

/**
 * @name Model
 * @desc 实例化数据库类
 * @author miclefeng
 */
class Model_Base
{
    protected $_db;

    protected static $tableName;

    protected static $columns = [];

    protected static $_mode = 1;

    protected static $_db_conf = [];

    public function __construct()
    {
        if(isset(static::$_mode) && !empty(static::$_mode)){
            self::$_mode = static::$_mode;
        }

        if(isset(static::$_db_conf) && !empty(static::$_db_conf)){
            self::$_db_conf = static::$_db_conf;
        }

        $this->_db = Database_DB::getInstance(self::$_mode, self::$_db_conf);
        $this->_db->tableName = static::$tableName;
        $this->_db->columns = static::$columns;
    }

    /**
     * 设置表中的字段的值
     * @param $name
     * @param $value
     * @return bool
     */
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->_db->createFields($name, $value);
        return true;
    }

    /**
     * 获取表中的字段得值
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->_db->getFields($name);
    }

    /**
     * ORM的create,update,destory操作
     * @param $name
     * @param $params
     * @return bool
     */
    public function __call($name, $params)
    {
        // TODO: Implement __call() method.
        if(in_array($name,array('create','save'))){
            foreach($this->_db->fields as $k => $item){
                if(!isset(static::$columns[$k])){
                    throw new Exception('The column '.$k.' not exists in table '.static::$tableName);
                }
            }
        }

        if(!isset($params) || empty($params)){
            return $this->_db->$name();
        }else{
            return $this->_db->$name($params);
        }
    }
}
