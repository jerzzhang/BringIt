<?php

require_once __DIR__.'/includes/all.php';

if (!isset($_GET["itemid"])) {
	echo "ERROR";
	return;
}
$itemid   = $_GET["itemid"];
$item_obj = DB::queryOneRow("SELECT * FROM menu_items WHERE id=%s", $itemid);
$desc     = $item_obj["desc"];

//$has_sides = ($item_obj["has_side"] === '1');

$category_item_id = $item_obj["service_id"];
//$menu_sides = DB::query("SELECT * FROM menu_sides WHERE category_item_id=%s", $category_item_id);
$menu_sides_extras = DB::query("SELECT * FROM menu_sides WHERE id in (SELECT sides_id FROM menu_sides_item_link WHERE item_id=%s) AND required=0", $itemid);
$menu_sides_sides = DB::query("SELECT * FROM menu_sides WHERE id in (SELECT sides_id FROM menu_sides_item_link WHERE item_id=%s) AND required=1", $itemid);
?>

<!--<script src="js/jquery.min.js"></script>-->
<!--<script src="js/cam.js"></script>-->

<div id="output"></div>
<div>
    <center><h1>Extras &amp; Sides</h1></center>
    <center><?php echo $item_obj["name"].": ".$desc;?></center>
    <br>
    <form id="side_form" method="post" action="#">
        <div class="special-side">Sides (required)</div>
<?php
    $required_sides_ids = array();
    $all_side_ids = array();


echo sprintf('<input type="hidden" name="itemid" value="%s">', $itemid);

function displayExtras($menu_sides, $useradio){
    $input_type = $useradio ? "radio" : "checkbox";
    $ids = array();

    $strt = '<div class="section group">';
    $end  = '</div>';
    if ($useradio){
        $fmt  = '<div class="col span_1_of_2">
                        <div class="6u$ 12u$(small)">
                            <input type="radio" id="side-%(id)s" name="side" value="%(id)s">
                            <label for="side-%(id)s">%(name)s<span id="xprice">+%(price)s</span></label>
                        </div>
                    </div>';
    }
    else{
        $fmt  = '<div class="col span_1_of_2">
                        <div class="6u$ 12u$(small)">
                            <input type="checkbox" id="side-%(id)s" name="%(id)s">
                            <label for="side-%(id)s">%(name)s<span id="xprice">+%(price)s</span></label>
                        </div>
                    </div>';
    }

    $cnt = count($menu_sides);

    if (count($menu_sides) > 0) {
        if (($cnt%2) != 0) {$dec = 1;}// odd number!
        else { $dec = 0;}

        for ($i = 0; $i < $cnt-$dec; $i += 2) {
            $arr_slice = array_slice($menu_sides, $i, 2);
            echo htmlLoopNamed($arr_slice, $strt, $fmt, $end);

            $ids[] = $arr_slice[0]["id"];
            $ids[] = $arr_slice[1]["id"];

//            if ($arr_slice[0]["required"] === "1") {
//                $required_sides_ids[] = $arr_slice[0]["id"];
//            }
//            if ($arr_slice[1]["required"] === "1") {
//                $required_sides_ids[] = $arr_slice[1]["id"];
//            }

        }
        if ($dec === 1) {
            $arr_slice = array_slice($menu_sides, $cnt-1, $cnt);
            echo htmlLoopNamed($arr_slice, $strt, $fmt, $end);
            $ids[] = $arr_slice[0]["id"];
            // deal with the +1 scenario
        }
    } else {
        echo '<div class="section group"><label>No sides available for this item</label></div>';
    }


    if ($useradio){
        global $required_sides_ids;
        $required_sides_ids = $ids;
    }
    global $all_side_ids;
    $all_side_ids = array_merge($all_side_ids, $ids);


}

displayExtras($menu_sides_sides, true);
?>
        <div class="special-side">Extras</div>
        <?php
        displayExtras($menu_sides_extras, false)
        ?>
    </form>
    <div class="12u$">
        <div id="special-q">Special Instructions</div>
            <textarea name="instructions" id="instructions" placeholder="e.g. dressing on the side" rows="4"></textarea>
        </div>
        <center><div id="required" class="required-red"><br></div></center>
        <ul class="actions">
            <center><li><input id="item_add" type="submit" value="Add to Cart" class="special" /></li></center>
        </ul>
    </div>
</div>
<script>
<?php
echo 'var side_ids = '.json_encode($all_side_ids).";\n\t";
echo 'var side_r_ids = '.json_encode($required_sides_ids).";\n";
?>
    function clog(a){
        console.log("TESTING")
    }
    $("span.featherlight-close").on("click", clog)


    $("#item_add").on("click", function(e){
        e.preventDefault();
        var formdata = $("#side_form").serialize();
        formdata += "&" + $("#instructions").serialize()
        var req_prof_s = $("#side_form").serializeArray();
        var satisfied = false;

        for (var i = 0; i < req_prof_s.length; i++){
            var entry = req_prof_s[i];
            if (entry.name != "itemid"){
                if (side_r_ids.indexOf(entry.value) != -1){
                    satisfied = true;
                }
            }
        }
        if (side_r_ids.length == 0){
            satisfied = true;
        }
        if (!satisfied){
            $("#required").text("This item requires the selection of a side")
            for (var j=0; j < side_r_ids.length; j++){
                $("#side-{0}".format(side_r_ids[j])).addClass("check-red");
            }
        }
        else{
            $.post("/includes/accounts/exec-add-item-cart.php", formdata, add_cart_callback, "json");
            $.featherlight.close();
        }

//        $.post("/includes/accounts/exec-add-item-cart.php", formdata, add_cart_callback, "json");
//        $.featherlight.close();
    })


</script>
