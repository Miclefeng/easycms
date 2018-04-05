<?php

class CommentModel extends Model_Base
{
    protected static $_tableName = 'comment';

    protected static $_columns = [
        'id' => 1,
        'username' => 1,
        'content' => 1,
        'state' => 0
    ];

    protected static $_mode;

    protected static $_db_conf;

    public function count()
    {
        return $this->_db->count();
    }

    public function get_list($size,$offset = 0)
    {
        return $this->_db->query("SELECT * FROM `".$this->table_name()."` LIMIT {$offset},{$size}")->row_all();
    }

    public function publish($data)
    {
        return $this->_db->insert("INSERT INTO `comment` (`username`,`content`) VALUES (?,?)",$data);
    }

    public function table_name()
    {
        return self::$_tableName;
    }

    public function get_last_insert_id()
    {
        return $this->_db->last_inser_id();
    }
}
