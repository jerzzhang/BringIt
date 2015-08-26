<?php

class Category {
    private $category_id;
    private $items = array();
    private $items_1d = array();
    public function __construct($category_id) {
        $this->category_id = $category_id;
        $data = DB::queryOneRow("SELECT * FROM categories WHERE id=%d", $category_id);
    }
    public static function getCategories(){
        global $services_hard_display_limit; // read from config.php
        return DB::query("SELECT * FROM categories WHERE active = 1 ORDER BY displayorder ASC LIMIT %d", $services_hard_display_limit);
    }
    public function getItems($use_1d){
        if (count($this->items) != 0){
            if ($use_1d){
                return $this->items_1d;
            }
            return $this->items;
        }
        $data = DB::query("SELECT * FROM category_items WHERE category_id=%d", $this->category_id);
        $ids = DBHelper::verticalSlice($data, "id");
        foreach ($ids as $id){
            $item = new categoryItem($this->category_id, $id);
            $values = array($this->category_id, $id, $item->name, $item->image);
            array_push($this->items_1d, $values);
            array_push($this->items, $item);
        }
        if ($use_1d){return $this->items_1d;}
            return $this->items;
    }

}
