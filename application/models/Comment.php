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
        $sql = "SELECT * FROM (SELECT `id` FROM `".$this->table_name()."` LIMIT {$offset},{$size}) a LEFT JOIN `".$this->table_name()."` b ON a.id=b.id";
        var_dump($sql);
        return $this->_db->query($sql)->row_all();
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
        return $this->_db->last_insert_id();
    }
}
