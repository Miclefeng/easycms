<?php

class CommentModel extends Model_Model
{
    protected static $tableName = 'comment';

    protected static $columns = [
        'id' => 1,
        'username' => 1,
        'content' => 1,
        'state' => 0
    ];

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
        return self::$tableName;
    }
}
