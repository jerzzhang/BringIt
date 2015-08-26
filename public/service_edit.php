<?php

require_once __DIR__.'/includes/all.php';

?>
<!DOCTYPE HTML>
<html>
<head>
    <title> </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.scrolly.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/skel-layers.min.js"></script>
    <script src="js/featherlight.js"></script>
    <script src="js/init.js"></script>
    <script src="js/cam.js"></script>
    <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/admin.css" />
        <link rel="stylesheet" href="css/style-xlarge.css" />
    </noscript>
    <link rel="stylesheet" href="css/flightbox.css">
    <!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
</head>
<body>

<?php

$cookies = new Cookies();
$user    = $cookies->user_from_cookie();
$id = $_GET["id"];

if ($user === 0) {
    header("Location: /index.php");
    exit;
}
if ($user->data["permission"] != 4){
    if ($user->data["service_id"] != $id && $user->data["permission"] == 3){
        header("Location: /index.php"); // not allowed to do this
//        echo "Invalid permissions";
        exit;
    }
}

$id = intval($id);

$cat_items_d = array();
$menu_cats_d = array();
$menu_sides_d = array();
$cat_item_hours = array();
if ($id !== -1){
    $categories = DB::query("SELECT * FROM categories ORDER BY displayorder");
    $cat_items_d = DB::queryOneRow("SELECT * FROM category_items WHERE id=%d", $id);
    $menu_cats_d = DB::query("SELECT * FROM menu_categories WHERE category_id=%d ORDER BY displayorder", $id);
    $cat_cnt = DB::count();
    $menu_sides_d = DB::query("SELECT * FROM menu_sides WHERE service_id=%d", $id);

}
$srv_raw_name = $id==-1 ? "New Service" : $cat_items_d["name"];
$srv_name = $id==-1 ? "Name" : "Name: " . $cat_items_d["name"];
$srv_type = $id==-1 ? "Type" : "Food Type: " . $cat_items_d["type"];
$srv_email = $id== -1 ? "Order Email" : "Order Email: " . $cat_items_d["email"];
$srv_desc = $id == -1 ? "Description" : "Description: " . $cat_items_d["description"];
$srv_min = $id == -1 ? "Minimum Order Price" : "Minimum Price: $" . $cat_items_d["minimum_price"];
$srv_fee = $id == -1 ? "Delivery Fee" : "Delivery Fee: $" . $cat_items_d["delivery_fee"];
$srv_category = $id == -1 ? 0 : $cat_items_d['category_id'];

?>
<div>
    <br>
    <center><h1><?php echo $srv_raw_name; ?></h1></center>
<!--    <h2 id="subcat-cover-label">Cover photo</h2>-->
<!--    <form action="demo_form.asp" id="subcat-cover-form">-->
<!--        <input id="subcat-cover" type="file" name="pic" accept="image/*">-->
<!--    </form>-->
    <div id="subcat-con">
        <?php
            if ($id > 0){
                echo '
                    <div class="general-info" style="text-align: left;">Images</div>
                    <form enctype="multipart/form-data" action="/includes/admin/upload_service_image.php" method="POST">
                        <input type="hidden" name="type" value="logo">
                        <input type="hidden" name="sid" value="' . $id . '">
            <!--            <label for="logo_image">Logo</label>-->
                        Logo: <input id="logo_image" type="file" name="imgfile">
                    </form>
                    <form enctype="multipart/form-data" action="/includes/admin/upload_service_image.php" method="POST">
                        <input type="hidden" name="type" value="cover">
                        <input type="hidden" name="sid" value="' . $id . '">
            <!--            <label for="cover_image">Logo</label>-->
                        Cover: <input id="cover_image" type="file" name="imgfile">
                    </form>
                    ';
            }

        ?>

        <div class="general-info" style="text-align: left;">General Info</div>
        <input id="subcat-name" type="text" placeholder="<?php echo $srv_name; ?>">
        <input id="subcat-type" type="text" placeholder="<?php echo $srv_type; ?>">
        <input id="subcat-email" type="text" placeholder="<?php echo $srv_email; ?>">
        <input id="subcat-desc" type="text" placeholder="<?php echo $srv_desc; ?>">
        <input id="subcat-min" type="text" placeholder="<?php echo $srv_min; ?>">
        <input id="subcat-fee" type="text" placeholder="<?php echo $srv_fee; ?>">
        <select id="subcat-category">
<?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>"<?php echo ($category['id'] == $srv_category ? ' selected': ''); ?>><?php echo $category['name']; ?></option>
<?php endforeach; ?>
        </select>

<?php

$timezone = '';
$open_hours = '';
if ($id !== -1) {
    $item_hours = DB::queryOneRow("SELECT * FROM item_hours WHERE restaurant_id=%d", $id);

    $timezone = $item_hours['timezone'];
    $open_hours = $item_hours['open_hours'];
}

?>
        <div class="general-info" style="text-align: left;">Open Hours</div>
        <select id="subcat-timezone" name="timezone" class="hidden">
            <option value="">Timezone:</option>
            <option value="PT"<?php echo ('PT' === $timezone ? ' selected': ''); ?>>Pacific Time</option>
            <option value="MT"<?php echo ('MT' === $timezone ? ' selected': ''); ?>>Mountain Time</option>
            <option value="CT"<?php echo ('CT' === $timezone ? ' selected': ''); ?>>Central Time</option>
            <option value="ET"<?php echo ('ET' === $timezone ? ' selected': ''); ?>>Eastern Time</option>
        </select>
        <input id="subcat-hours" type="text" placeholder="Hours: <?php echo $open_hours; ?>">
        <div style="text-align: center;">
            Use a comma-separated list of:<br>
            DAY_OF_WEEK START_TIME-END_TIME<br>
            (Example: <code>Sat 8 am-10 pm,Sun 11 am-7 pm</code>)
        </div>

        <div style="text-align: center;"><input id="subcat-details-save" type="button" value="Save Details"></div>
<!--        <div class="general-info" style="text-align: left;">Payment Type</div>-->
<!--        <div class="section group">-->
<!--            <br>-->
<!--            <div class="col span_1_of_2">-->
<!--                <input type="checkbox" id="points" name="points">-->
<!--                <label for="points">Food Points</label>-->
<!--            </div>-->
<!--            <div class="col span_1_of_2">-->
<!--                <input type="checkbox" id="invoice" name="invoice">-->
<!--                <label for="invoice">Invoicing</label>-->
<!--            </div>-->
<!--        </div>-->
        <div class="general-info" style="text-align: left;">Sides</div>
            <div id="items-con" style="text-align: center;">
                <?php
                foreach ($menu_sides_d as $side){
                    echo sprintf("<div><span id='del-side-%s' class='del_side link_span'>x</span> %s $%s | Required: %s</div>", $side["id"], $side["name"], $side["price"], $side["required"] == "1" ? "yes" : "no");
                }
                ?>
                <span id="add_side_input_span"></span>
                <div><input type="submit" id="add_side_button" value="Add Side"></div>
            </div>
        <div class="general-info" style="text-align: left;">Menu</div>
        <div id="apps-con" style="text-align: left;">
            <?php
            function createMenuCategorySelect($category_id, $display_order, $max){
                $disabled = ($display_order <= 1) ? ' disabled': '';
                $html  = sprintf('<button class="menu_category_order up" data-display-order="%d" data-category-id="%d"%s>&uarr;</button>', $display_order - 1, $category_id, $disabled);
                $disabled = ($display_order >= $max) ? ' disabled': '';
                $html .= sprintf('<button class="menu_category_order down" data-display-order="%d" data-category-id="%d"%s>&darr;</button>', $display_order + 1, $category_id, $disabled);

                return $html;
            }

            foreach ($menu_cats_d as $mcat){
                $cat_select = createMenuCategorySelect($mcat['id'], $mcat['displayorder'], $cat_cnt);
                echo sprintf('<div class="specific-info" style="text-align: center;"><span class="del-category link_span" id="del-cat-%s">x</span> %s %s</div>', $mcat["id"], $mcat["name"], $cat_select);
                $menu_items_d = DB::query("SELECT * FROM menu_items WHERE service_id=%d AND category_id=%d", $id, $mcat["id"]);
                foreach ($menu_items_d as $item){
                    echo sprintf('<div><div style="float:left; display:inline;"><span id="del-item-%s" class="del_menu_item link_span">x </span>%s</div><div style="float:right; display:inline;">$%s <div id="edit-item-%s" class="edit-item" style="display:inline; background-color: #00D4BB; padding:2px;">Edit</div></div></div><br>', $item["id"], $item["name"], $item["price"], $item["id"]);
                }
            }

            ?>
            <span id="add_menu_category_input_span"></span>
            <div style="text-align:center;"><input type="submit" id="add_menu_cat_button" value="Add Menu Category"></div>
            <div style="text-align:center;"><input type="submit" id="add_menu_item_button" value="Add Menu Item"></div>

            <?php
            if ($user->data["permission"] == 4){
                echo '<hr><div style="text-align:center"><input style="background-color:red" type="button" id="delete_service_item" value="Delete Permanently"></div>';
            }
            ?>
        </div>
    </div>
</div>

<script>
    $('.menu_category_order').on('click', function(e) {
        var category_id = $(this).data('category-id');
        var display_order = $(this).data('display-order');
        params = {'service_id':<?php echo $id; ?>, 'category_id': category_id, 'display_order': display_order};
        $.post("/includes/admin/exec-change-category-order.php", params, function(d){
            window.location.replace("admin.php?p=3&sv=<?php echo $id; ?>");
        })
    })

    $("#add_side_button").on('click', function(e){
        e.preventDefault();
        if ($(this).val() == "Add Side"){
            $("#add_side_input_span").append($("<input>", {type:"text", name:"name", placeholder:"Side Name"}))
            $("#add_side_input_span").append($("<input>", {type:"text", name:"price", placeholder:"Side Price"}))
            $("#add_side_input_span").append($("<input>", {type:"checkbox", id:"side_required", name:"req"}))
            $("#add_side_input_span").append($("<label>", {"for":"side_required"}).text("Required"))
            $(this).prop("value","Save")
        }
        else {
            if ($(this).val() == "Save"){
                var name = $("#add_side_input_span input[name='name']").val()
                var price = $("#add_side_input_span input[name='price']").val()
                var req = $("#add_side_input_span input[name='req']").prop("checked")
                if (req){var vreq = 1;}
                else{var vreq = 0;}
                if (parseFloat(price) !== Number(price) || name === ""){
                    $(this).addClass("check-red")
                }
                else{
                    params = {"service_id":<?php echo $id; ?>, "name":name, "price":price, "req":vreq}
                    $.post("/includes/admin/exec-add-side.php", params, function(d){
                        if (d != "-1"){
                            $("#add_side_button").removeClass("check-red");
                            $("#add_side_button").prop("value","Add Side")
                            $("#add_side_input_span").empty()

                            var ndiv = $("<div>").text("{0} ${1} | Required: {2}".format(name, price, vreq == 1 ? "yes" : "no"))
                            $(ndiv).prepend($("<a>", {id:"del-side-{0}".format(d), class:"del_side"}).text("x ")) // side_id, service_id

                            $("#add_side_button").before(ndiv)
                        }
                        else {
                        }
                    })
                }
            }
        }
    })

    $("#add_menu_cat_button").on('click', function(e){
        if ($(this).val() == "Add Menu Category"){
            $("#add_menu_category_input_span").append($("<input>", {type:"text", name:"catname", placeholder:"Category Name"}))
            $(this).prop("value","Save")
        }
        else{
            if ($(this).val() == "Save"){
                var name=$("#add_menu_category_input_span input[name='catname']").val()
                var pthis = this;
                params = {"service_id": <?php echo $id; ?>, "name":name}
                $.post("/includes/admin/exec-add-category.php", params, function(d){
                    if (d != "-1"){
                        /// win
                        var ndiv = $("<div>", {class:"specific-info", style:"text-align: center;"}).text(name)
                        ndiv.prepend($("<span>", {class:"del-category link_span", id:"del-cat-{0}".format(d)}).text("x "))
                        $("#add_menu_category_input_span").before(ndiv)
                        $(pthis).prop("value","Add Menu Category")

                        $("#add_menu_category_input_span").empty()
                    }
                    else{
                        alert("An internal error occurred, please contact your website administrator for assistance")
                    }
                })
            }
        }
    })

    $("#subcat-details-save").on('click', function(e){
        e.preventDefault();
        params = {
            id:<?php echo $id; ?>,
            name:$("#subcat-name").val(),
            type:$("#subcat-type").val(),
            timezone:$("#subcat-timezone").val(),
            hours:$("#subcat-hours").val(),
            email:$("#subcat-email").val(),
            description:$("#subcat-desc").val(),
            minimum_price:$("#subcat-min").val(),
            delivery_fee:$("#subcat-fee").val(),
            category_id:$("#subcat-category").val()
        }
        $.post("/includes/admin/exec-service-settings.php", params, function(d){
            if (d == parseInt(d, 10)) {
                window.location = "admin.php?p=3&sv="+d;
            }
        })
    })

    $(document.body).off().on('click', '.edit-item', function(e){
        var item_id = $(this).prop("id").split("-")[2]
        $.featherlight("menu_edit.php?id={0}&sid={1}".format(item_id, <?php echo $id; ?>))
    })

    $(document.body).on('click', '#add_menu_item_button', function(e){
        $.featherlight("menu_edit.php?id=-1&sid={0}".format(<?php echo $id; ?>))
    })

    $(document.body).on('click', ".del-category", function(e){
        params = {"service_id": <?php echo $id; ?>, "id":$(this).prop("id").split("-")[2]}
        var entry = $(this).parent();
        $.post("/includes/admin/exec-del-cat.php", params, function(d){
            if (d != "-1"){
                $(entry).hide()
            }
            else{
                alert("An internal error occurred, please contact your website administrator for assistance")
            }
        })
    })

    $(document.body).on('click', ".del_menu_item", function(e){
        params = {"service_id": <?php echo $id; ?>, "id":$(this).prop("id").split("-")[2]}
        var entry = $(this).parent().parent();
        $.post("/includes/admin/exec-del-menu-item.php", params, function(d){
            if (d != "-1"){
                $(entry).hide()
            }
            else{
                alert("An internal error occurred, please contact your website administrator for assistance")
            }
        })
    })

    $(document.body).on('click', ".del_side", function(e){
        e.preventDefault()
        params = {"service_id":<?php echo $id; ?>, "id":$(this).prop("id").split("-")[2]}
        var entry = $(this).parent();
        $.post("/includes/admin/exec-del-side.php", params, function(d){
            if (d != "-1"){
                $(entry).hide()
            }
            else{
                alert("An internal error occurred, please contact your website administrator for assistance")
            }
        })
    })

    $(document.body).on('click', '.add-side-link', function(e){
        var side_id = $(this).prop("id").split("-")[4]
        var item_id = $(this).prop("id").split("-")[3]
        params = {"item_id":item_id, "side_id":side_id, "service_id":<?php echo $id; ?>}
        var entry = $(this).parent().parent();
        var pthis = this
        $.post("/includes/admin/exec-add-side-link.php", params, function(d){
            if (d != "-1"){
                $(pthis).text("- ")
                $(pthis).addClass("del-side-link")
                $(pthis).removeClass("add-side-link")
                var new_entry = $(entry).clone();
                $(entry).hide()
                $("#used_sides_sp").append(new_entry)
            }
        })
    })

    $(document.body).on('click', '.del-side-link', function(e){
        var side_id = $(this).prop("id").split("-")[4]
        var item_id = $(this).prop("id").split("-")[3]
        params = {"item_id":item_id, "side_id":side_id, "service_id":<?php echo $id; ?>}
        var entry = $(this).parent().parent();
        var pthis = this
        $.post("/includes/admin/exec-del-side-link.php", params, function(d){
            if (d != "-1"){
                $(pthis).text("+ ")
                $(pthis).addClass("add-side-link")
                $(pthis).removeClass("del-side-link")
                var new_entry = $(entry).clone();
                $(entry).hide()
                $("#unused_sides_sp").append(new_entry)
            }
        })
    })

    $(document.body).on('change', '#logo_image', function(e){
        e.preventDefault();
        $("#logo_image").parent().submit()
    })
    $(document.body).on('change', '#cover_image', function(e){
        e.preventDefault();
        $("#cover_image").parent().submit()
    })

    $(document.body).on('click', ".save_item_details", function(e){
//        e.preventDefault();
        var item_id = $(this).prop("id").split("-")[1]
        var has_sides = $('#item-subcat-con input[name="has_sides"]').prop('checked') ? 1 : 0;
        params = {
            id:item_id,
            service_id:<?php echo $id; ?>,
            category_id:$("#category_selection option:selected").val(),
            name:$("#item-subcat-con input[name='name']").val(),
            price:$("#item-subcat-con input[name='price']").val(),
            desc:$("#item-subcat-con input[name='desc']").val(),
            has_side:has_sides
        }
        $.post("/includes/admin/exec-item-settings.php", params, function(d){
            window.location.replace("admin.php?p=3&sv=<?php echo $id;?>");
        })
    })

    $(document.body).on('click',"#delete_service_item", function(e){
        params = {id: <?php echo $id; ?>}
        $.post("/includes/admin/exec-delete-service-item.php", params, function(d){window.location = "admin.php?p=3";})
    })


</script></body></html>
