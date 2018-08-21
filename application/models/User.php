<?php

class UserModel extends Model_Base
{
    protected static $_tableName = 'user';

    protected static $_columns = [
        'id' => 1,
        'username' => 1,
        'password' => 1,
        'mobile' => 0,
        'email' => 0,
        'last_login_time' => 1
    ];

    protected static $_mode;

    protected static $_db_conf;

    public function count()
    {
        return $this->_db->count();
    }

    public function get_list($pagesize, $offset)
    {
        return $this->_db->query("SELECT * FROM `" . $this->table_name() . "` LIMIT {$offset},{$pagesize}")->row_all();
    }

    // 根据用户名和密码获取用户信息
    public function get_info($username, $passwd)
    {
        return $this->_db->query("SELECT * FROM  `" . $this->table_name() . "` WHERE `username`='{$username}' AND `password`='{$passwd}'")->row_one();
    }

    public function table_name()
    {
        return self::$_tableName;
    }
}
