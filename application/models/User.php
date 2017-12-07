<?php

class UserModel extends Model_Base
{
    protected static $tableName = 'user';

    protected static $columns = [
        'id' => 1,
        'username' => 1,
        'password' => 1,
        'mobile' => 0,
        'email' => 0,
        'last_login_time' => 1
    ];

    public function count()
    {
        return $this->_db->count();
    }

    public function get_list($pagesize,$offset)
    {
        return $this->_db->query("SELECT * FROM `".$this->table_name()."` LIMIT {$offset},{$pagesize}")->getAll();
    }

    public function table_name()
    {
        return self::$tableName;
    }
}
