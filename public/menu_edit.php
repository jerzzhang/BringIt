<?php

require_once __DIR__.'/includes/all.php';

$cookies = new Cookies();
$user    = $cookies->user_from_cookie();
$id = $_GET["id"];
$sid = $_GET["sid"];


if ($user === 0) {
    header("Location: /index.php");
    exit;
}
if ($user->data["permission"] != 4){
    if ($user->data["service_id"] != $sid && $user->data["permission"] == 3){
        echo "Invalid permissions";
//        return;
    }
}
$id = intval($id);

if ($id !== -1){
    $item = DB::queryOneRow("SELECT * FROM menu_items WHERE id=%d", $id);


    $side_link = DB::query("SELECT * FROM menu_sides_item_link WHERE item_id=%d", $id);
    $used = DBHelper::verticalSlice($side_link, "sides_id");
    if (count($used) == 0){
        $used=array(-1);
    }
    $osides = DB::query('SELECT * FROM menu_sides WHERE id NOT IN (' . implode(',', array_map('intval', $used)) . ') AND service_id=%d', $sid);
}
else{
    $side_link = array();
    $osides = DB::query("SELECT * FROM menu_sides WHERE service_id=%d", $sid);

}


$iname = $id==-1 ? "Name" : "Name: " . $item["name"];
$iprice = $id==-1 ? "Price" : "Price: " . $item["price"];
$idesc = $id==-1 ? "Description" : "Description: " . $item["desc"];
$checked = $id==-1 ? "" : ($item["has_side"] === "1" ? "checked" : "");

if ($id === -1){
    $id = intval(DB::queryOneRow("SELECT * FROM settings WHERE name='lastitem'")["value"]) + 1;
    DB::update("settings", array("value"=>$id), "name=%s", "lastitem");
}

?>


<div id="item-subcat-con" style="text-align: center;">
    <div class="general-info">Details</div>
    <input type="text" name="name" placeholder="<?php echo $iname; ?>">
    <input type="text" name="price" placeholder="<?php echo $iprice; ?>">
    <input type="text" name="desc" placeholder="<?php echo $idesc; ?>">
    <select id="category_selection">
        <?php
        $cats = DB::query("SELECT * FROM menu_categories WHERE service_id=%d", $sid);
        foreach ($cats as $cat){
            if (isset($item)){
                if ($cat["id"] == $item["category_id"]){
                    $chk = "selected";
                }
                else{
                    $chk = "";
                }
            }
            else{
                $chk = "";
            }

            echo sprintf('<option value="%s" %s>%s</option>', $cat["id"], $chk, $cat["name"]);
        }
        ?>
    </select>
    <input type="checkbox" id="item_has_sides" name="has_sides" value="1" <?php echo $checked; ?>>
    <label for="item_has_sides">Has Sides</label><br>

    <div id="used_sides" class="specific-info">Sides (used)</div>
    <div id="used_sides_sp">
        <?php
            foreach ($side_link as $side){
                $side_d = DB::queryOneRow("SELECT * FROM menu_sides WHERE id=%d", $side["sides_id"]);
//                echo sprintf("<div>
//                                <div style=\"display: inline; float: left\">
//                                    <span id=\"del-side-link-%s-%s\" class=\"del-side-link link_span\">- </span>
//                                    %s
//                                </div>
//                                <div style=\"display: inline; float: right\">
//                                    $%s
//                                </div>
//                              </div><br>\n\n", $id, $side_d["id"], $side_d["name"], $side_d["price"]);
                if (!empty($side_d['name'])) {
                    echo sprintf("<div><div><span id=\"del-side-link-%s-%s\" class=\"del-side-link link_span\">- </span> %s</div></div>", $id, $side_d["id"], $side_d["name"]);
                }
            }

        ?>
    </div>
    <div id="unused_sides" class="specific-info">Sides (unused)</div>
    <div id="unused_sides_sp">
        <?php
        foreach ($osides as $side){
//            echo sprintf("<div>
//                            <div style=\"display: inline; float: left\">
//                                <span id=\"add-side-link-%s-%s\" class=\"add-side-link link_span\">+ </span>
//                                %s
//                            </div>
//                            <div style=\"display: inline; float: right\">
//                                $%s
//                            </div></div><br>\n\n", $id, $side["id"], $side["name"], $side["price"]);
            if (!empty($side['name'])) {
                echo sprintf("<div><div><span id=\"add-side-link-%s-%s\" class=\"add-side-link link_span\">+ </span> %s</div></div>", $id, $side["id"], $side["name"]);
            }
        }

        ?>
    </div><br>
    <input type="button" id="save_item_details-<?php echo $id; ?>" class="save_item_details" value="Save">
</div>

