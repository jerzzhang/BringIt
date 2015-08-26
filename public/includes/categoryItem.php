<?php

class categoryItem {
    public function __construct($category_id, $item_id) {
        $data = DB::queryOneRow("SELECT * FROM category_items WHERE category_id=%d AND id=%d", $category_id, $item_id);
        foreach($data as $k=>$v){
            $this->{$k}=$v;
        }
    }
}
