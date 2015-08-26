<?php

function displayMainPageAccountDetails() {
    $html_out   = '<li><a href="#sign-up">Sign up</a></li><li><a href="#login">Login</a></li>';
    $html_in    = '%s<li><a href="./profile.php">' . displayCurrentUserName() . '</a></li><li><a href="./profile.php">My Account</a></li><li><a href="./includes/accounts/exec-logout.php">Logout</a>';
    $html_admin = '<li><a href="./admin.php">Admin</a></li>';

    $cookies = new Cookies();
    $user    = $cookies->user_from_cookie();
    if ($user) {
        if ($user->data["permission"] > 1) {
            $fmter = $html_admin;
        } else {
            $fmter = "";
        }
    }
    return ($user === 0)?$html_out:sprintf($html_in, $fmter);
}

function displayFavoriteOrders(){
    $html_favorite = '<a href="#" id="my-favorites-button" class="skel-layers-include" data-action="toggleLayer" data-args="menuPanel">Favorite Orders</a>';
    $cookies = new Cookies();
    $user = $cookies->user_from_cookie();
    if ($user){
        return $html_favorite;
    }
    return "";
}

function displayMainPageCategories($data) {
    $categories = DBHelper::verticalSlice($data, "name");
    $numbers    = range(1, count($categories));
    $width = (100 / count($categories)) . '%%';

    $arr = zip($numbers, $categories);

    $start = '<div class="section group">';
    $fmt   = '<div data-tab="%d" class="tab-items col main-tabs" style="width: ' . $width . '"><div id="tabLabel">%s</div></div>';
    $end   = '</div>';

    return htmlLoop($arr, $start, $fmt, $end);
}

function displayAllMainPageCategoryItems() {
    $category_ids = DBHelper::verticalSlice(Category::getCategories(), "id");
    $html         = "";
    for ($i = 0; $i < count($category_ids); $i++) {
        $html .= sprintf('<div data-tab="%d" class="category-items hidden">', $i + 1);
        $html .= displayMainPageCategoryItems($category_ids[$i]);
        $html .= '</div>';
    }
    return $html;
}

function displayMainPageCategoryItems($category_id) {
    $category = new Category($category_id);
    $items    = $category->getItems(true);// 1d array

    $html   = "";
    $istart = '<div class="section group">';
    $ifmt   = '<a href="order.php?type=%s&id=%s"><div class="col span_1_of_2"><div id="homeLabel">%s</div><img src="./images/%s"></div></a>';
    $iend   = '</div>';

    if (0 === count($items)) {
        $html .= '<div>Coming Soon</div>';
    }

    // display in groups of 2
    $chunks = array_chunk($items, 2);
    foreach ($chunks as $chunk) {
        $html .= htmlLoop($chunk, $istart, $ifmt, $iend);
    }

    return $html;
}

function displayMenuCategories($menu) {
    $cats = $menu->get_categories();
    $html = "";
    for ($i = 0; $i < count($cats); $i++) {
        $html .= sprintf('<li id="cat-%s">%s</li>', $i, $cats[$i]);
    }
    return $html;
}

function displayAllMenuCategoryItems($menu) {
    $cats   = $menu->get_categories();
    $istart = "";
    $ifmt   = '<li class="menuItem" id="menu-item%s"><span class="left menuItemName" title="%s" >%s</span><span class="right" style="text-align: right;"><b class="menuItemPrice">%0.2f</b></span></li>';
    $iend   = "";
    $html   = "";

    for ($i = 0; $i < count($cats); $i++) {
        $items = $menu->get_items($cats[$i]);
        $html .= sprintf('<span id="menucat-%s">', $i);
        $html .= htmlLoop($items, $istart, $ifmt, $iend);
        $html .= '</span>';
    }
    return $html;
}

function displayAdminOrderFeedFilters() {
    $time_html         = "";
    $service_html      = "";
    $service_item_html = "";

    $time_arr = array(
        array(0, "Today"),
        array(1, "Yesterday"),
        array(2, "Two days ago"),
        array(7, "One week ago"),
        array(14, "Two weeks ago"),
        array(30, "One month ago"),
        array(60, "Two months ago"),
        array(180, "6 months ago"),
        array(360, "1 year ago"),
        array(720, "2 years ago")
    );

    // get current user
    $cookies = new Cookies();
    $user    = $cookies->user_from_cookie();

    $service_arr = array();
    $service_item_arr = array();
    if ($user->data['permission'] === '4') {
        $service_arr      = DB::query("SELECT id,name FROM categories");
        $service_arr      = refineArray($service_arr, array("id", "name"));
        $service_item_arr = DB::query("SELECT * FROM category_items WHERE category_id=%d", 1);
        $service_item_arr = refineArray($service_item_arr, array("id", "name"));
    }
    else if ($user->data['service_id'] > 0) {
        $service_item_arr = DB::query("SELECT * FROM category_items WHERE id=%d", $user->data['service_id']);
        $service_arr      = DB::query("SELECT id,name FROM categories WHERE id=%d", $service_item_arr[0]['category_id']);

        $service_item_arr = refineArray($service_item_arr, array("id", "name"));
        $service_arr      = refineArray($service_arr, array("id", "name"));
    }

    if (empty($service_arr)) {
        array_unshift($service_arr, array(-1, "Select Category"));
    }
    if (1 !== count($service_item_arr)) {
        array_unshift($service_item_arr, array(-1, "Select Company"));
    }

    $time_html .= '<div id="date-select"><select autocomplete="off">';
    $time_html .= htmlLoop($time_arr, "", '<option value="%s">%s</option>', "");
    $time_html .= "</select></div>";

    $service_html .= '<div id="service-select"><select autocomplete="off">';
    $service_html .= htmlLoop($service_arr, "", '<option value="%s">%s</option>', "");
    $service_html .= "</select></div>";

    $filter_by_html = '<div id="filter-select"><select autocomplete="off">';
    if (1 < count($service_item_arr)) {
        $filter_by_html .= '<option value="1">Filter by restaurant</option>';
    }
    $filter_by_html .= '<option value="2">Filter by time</option><option value="3">Filter by campus</option></select></div>';

    $service_item_html .= '<div id="choose-select"><select autocomplete="off">';
    $service_item_html .= htmlLoop($service_item_arr, "", '<option value="%s">%s</option>', "");
    $service_item_html .= "</select></div>";
    return $time_html.$service_html."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=>".$filter_by_html.$service_item_html;
}

function getAdminAccountsPermissionsHTML($uid, $perm) {
    $permissions = array(
        1=> "Customer",
        2=> "Employee",
        3=> "Owner",
        4=> "Campus Enterprise",
    );
    $value = $permissions[$perm];
    unset($permissions[$perm]);
    $permissions_1d = array(array($perm, $value));
    foreach ($permissions as $k => $permission) {
        array_push($permissions_1d, array($k, $permission));
    }
    $permissions_1d = addToEachArray($permissions_1d, $uid, true);

    // get current user
    $cookies = new Cookies();
    $user    = $cookies->user_from_cookie();

    $start = ($uid === $user->data['uid']) 
        ? '<td><select class="adminAccountsPermissionsSelect" autocomplete="off" disabled>'
        : '<td><select class="adminAccountsPermissionsSelect" autocomplete="off">';
    $fmt   = '<option value="%s-%s">%s</option>';
    $end   = "</select></td>";

    return htmlLoop($permissions_1d, $start, $fmt, $end);
}

function getAdminAccountsServicesHTML($uid, $service) {
    $services = DB::query("SELECT * FROM category_items");
    $services = refineArray($services, array("id", "name"));
    $services = addToEachArray($services, $uid, true);

    // get current user
    $cookies = new Cookies();
    $user    = $cookies->user_from_cookie();

    $start = ($uid === $user->data['uid']) 
        ? '<td><select class="adminAccountsServicesSelect" autocomplete="off" disabled>'
        : '<td><select class="adminAccountsServicesSelect" autocomplete="off"><option value=""><option>';
    $fmt   = '<option value="%s-%s">%s</option>';
    $end   = "</select></td>";

    return htmlLoop($services, $start, $fmt, $end);
    return "<td>$service</td>";
}

function displayAdminAccountsPage() {
    $html  = "";
    $users = UserManager::get_users();

    // get current user
    $cookies = new Cookies();
    $current = $cookies->user_from_cookie();

    foreach ($users as $user) {
        $innerHtml = "<tr>";
        $innerHtml .= ($user['uid'] === $current->data['uid']) ? '<tr class="disabled">' : '<tr>';
        $innerHtml .= sprintf("<td>%s</td><td>%s</td><td>%s</td>", $user["name"], $user["phone"], $user["email"]);
        $innerHtml .= getAdminAccountsPermissionsHTML($user["uid"], intval($user["permission"]));
        $innerHtml .= getAdminAccountsServicesHTML($user["uid"], intval($user["service_id"]));
        $innerHtml .= "</tr>";
        $html .= $innerHtml;
    }
    return $html;
}

function displayCurrentUserName() {
    $cookies = new Cookies();
    if ($cookies) {
        if ($user = $cookies->user_from_cookie()) {
            return $user->data["name"];
        }
    }
    return '';
}

function displayAdminServicesPage() {
    $service_id = isset($_GET['sid']) ? $_GET['sid'] : null;
    $service_id = $service_id != "-1" ? $service_id : null;
    $all_services = DB::query("SELECT * FROM categories ORDER BY displayorder");
    if ($service_id){
        $service = DB::queryOneRow("SELECT * FROM categories WHERE id=%s", $service_id);
    }
    else{
        $service = $all_services[0];
        $service_id = $service["id"];
    }
    if (!$service){
        return "";
    }

    $sname = $service['name'];
    $checked = $service["active"] == "1" ? " checked" : "";
    global $sorder;
    $sorder  = $service['displayorder'];

    // get current user
    $cookies = new Cookies();
    $user    = $cookies->user_from_cookie();

    $html = "";

    $service_header_option_html = htmlLoopNamed($all_services, "", "<option value='%(id)s'>%(name)s</option>", "");
    $service_header_select_html = "
        <select id='select_service_id'>
            <option value='0' selected='selected'>Show Category</option>
            $service_header_option_html
        </select>
    ";

    $service_header_html = "
    <div id='admin-services'>
        <span id='service-title'>$sname</span>
        <div id='service-options'>
            <div id='service-select'>
                $service_header_select_html
            </div>";

    if ($user->data['permission'] === '4') {
        $service_header_html .= "
            <div id='addService'>+ Add Service</div>";
    }

    $service_header_html .= "
        </div>
    </div>";

    $scategories = ($user->data['permission'] === '3')
        ? DB::query("SELECT * FROM category_items WHERE id=%s", $user->data['service_id'])
        : DB::query("SELECT * FROM category_items WHERE category_id=%s", $service_id);

    $service_subcategories_html = "";
    $chunks = array_chunk($scategories, 3);
    foreach ($chunks as $chunk) {
        $strt = "<div class='section group'>";
        $end  = "</div>";
        $fmt  = "<div id='service-%(id)s' class='col gen_1_of_3'><span id='cat-name'>%(name)s</span><br><img src='images/%(image)s'></div>";
        $service_subcategories_html .= htmlLoopNamed($chunk, $strt, $fmt, $end) . "<br>";
    }

    $service_html = "
    <div id='service-container'>
        <div id='service-info'>
            <div id='general-actions'>";

    if ($user->data['permission'] === '4') {
        $service_html .= "
                <div class='general-info'>
                    General info
                    <input type='hidden' name='category_id' value='$service_id'>
                </div>
                <div id='general-select'>
                    <input type='text' name='sitename' placeholder='Category: $sname'>
                </div>
                <div id='active-check'>
                    <input type='checkbox' id='active' name='active' value='1' $checked>
                    <label for='active'>Active</label>
                </div>
                <div id='placement-select'>
                    <select name='displayorder'>";

        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        for ($i = 1; $i <= count($all_services); $i++) {
            $ordinal = (($i % 100) >= 11 && ($i % 100) <= 13) ? $i . 'th' : $i . $ends[$i % 10];

            $service_html .= '<option value="' . $i . '"';
            $service_html .= $sorder == $i ? ' selected' : '';
            $service_html .= '>Display as ' . $ordinal . ' service</option>';
        }

        $service_html .= "
                    </select>
                </div>
                <div id='category-save'>Save Category</div>
                <div id='category-new'>Create as New</div>";
        if (0 === count($scategories)) {
            $service_html .= "&nbsp;<div id='category-delete'>Delete</div>";
        }
        $service_html .= "<br>";
    }

    $service_html .= "
                <div class='general-info'>Services</div>
                $service_subcategories_html
                </div>
        </div>
    </div>
    ";

    $html .= $service_header_html . "<br><br>" . $service_html;

    return $html;
}

function displayAdminSettingsPage() {
    $html_1 = '
        <div id="setting-%s">
        <span class="setting-name">%s:</span>
        <span class="setting-value">%s</span>
        <input type="text" class="setting-value-input" placeholder="New Value">
        <input type="button" class="setting-save-text" value="Save">
        </div>';
    $html_2 = '
        <form class="ulform" enctype="multipart/form-data" id="setting-%s" action="/includes/accounts/exec-admin-change-setting.php" method="POST">
        <span class="setting-name">%s:</span>
        <img height="150px" width="200px" class="setting-value" src="images/%s">
        <input type="hidden" name="type" value="2">
        <input type="hidden" name="name" value="None">
        <input name="settingsfile" type="file" />
        <input type="submit" class="setting-save" value="Upload">
        </form>';
    $settings_1 = DB::query("SELECT name, display, value FROM settings WHERE type=1");
    $settings_1 = refineArray($settings_1, array("name","display","value"));
    echo htmlLoop($settings_1,"", $html_1, "");

    $settings_2 = DB::query("SELECT name, display, value FROM settings WHERE type=2");
    $settings_2 = refineArray($settings_2, array("name","display","value"));
    echo htmlLoop($settings_2,"", $html_2, "");
}
