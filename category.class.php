<?php // entities/category.class.php

require_once("db.class.php");

class Category
{
    public static function list_category()
    {
        $db = new db();
        $sql = "SELECT * FROM category";
        $result = $db->select_to_array($sql);
        return $result;
    }
}
?>
