<?php

class Menu {
    public $id;
    public $catid;
    public $name;
    public $categories;
    public $type;
    public $description;
    public $deliveryfee;
    public $serviceid;
    public $hours = null;

    public function __construct($category_id, $id){
        $service = DB::queryOneRow("SELECT * FROM category_items WHERE id=%d AND category_id=%d", $id, $category_id);
        $results = DB::query("SELECT * FROM menu_categories WHERE category_id=%d AND service_id=%d", $category_id, $id);
        $menu_cats = array();
        foreach ($results as $result) {
            $menu_cat_id = $result['id'];
            $menu_cats[$menu_cat_id] = $result;
        }

        $this->id = $id;
        $this->catid = $category_id;
        $this->deliveryfee = $service["delivery_fee"];
        $this->type = $service["type"];
        $this->name = $service["name"];
        $this->serviceid = $service["category_id"];
        $this->description = $service["description"];
        foreach ($menu_cats as $menu_cat_id => $menu_cat) {
            $this->categories[$menu_cat["name"]] = DB::query("SELECT * FROM menu_items WHERE category_id=%d AND service_id=%d", $menu_cat_id, $id);
        }
    }
    public function getHours(){
        if (!empty($this->hours)) {
            return $this->hours;
        }
        $hours = DB::queryOneRow("SELECT open_hours FROM item_hours WHERE restaurant_id=%d", $this->id);
        $this->hours = [];
        if (!empty($hours['open_hours'])) {
            $this->hours = explode(',', $hours['open_hours']);
        }
        return $this->hours;
    }
    public function isOpen(){
        $start = $this->hours[0];
        $end = $this->hours[2];

        if ($this->hours[1] == 0){ // start am = false
            $start = $start + 12;
        }
        if ($this->hours[3] == 0){ // end am = false
            $end = $end + 12;
        }
        return true;
    }

    public function get_categories(){
        if (count($this->categories) == 0){
            return array();
        }
        return array_keys($this->categories);
    }

    public function get_items($category_name){
        $items = $this->categories[$category_name];
        $f = array();
        foreach ($items as $d){
            //            $itemid = sprintf("%s,%s,%s", $d["category_id"], $d["service_id"], $d["id"]);
            $f[] = arraY($d["id"], $d["desc"], $d["name"], $d["price"]);
        }
        return $f;

    }
}
