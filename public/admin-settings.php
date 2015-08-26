<?php

require_once __DIR__.'/includes/all.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/cam.js"></script>
    <script src="js/jquery.scrolly.min.js"></script>
    <script src="js/jquery.cookie.js"></script>

</head>
<body>
<br><br>
    <?php
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
                <input name="userfile" type="file" />
                <input type="submit" class="setting-save" value="Upload">
            </form>';
        $settings_1 = DB::query("SELECT name, display, value FROM settings WHERE type=1");
        $settings_1 = refineArray($settings_1, array("name","display","value"));
        echo htmlLoop($settings_1,"", $html_1, "");

        $settings_2 = DB::query("SELECT name, display, value FROM settings WHERE type=2");
        $settings_2 = refineArray($settings_2, array("name","display","value"));
        echo htmlLoop($settings_2,"", $html_2, "");
    ?>

<script>


    // change setting
    $(".ulform").each(function(i){
        var name = $(this).attr("id").split("-")[1]
        $(this).children('input[name=name]').val(name);
    })

    $(".setting-save-text").on('click', function(e){
        var parent = $(this).parent()
        var name = $(parent).attr("id").split("-")[1]
        var value = $(parent).children(".setting-value-input").val()
        changeSettingText(name, value)
    })
    function changeSettingText(name, value){
        params = {"name":name, "value":value, type:"1"};
        $.post("/includes/accounts/exec-admin-change-setting.php", params, changeSettingCallbackText, "json");
    }

    function changeSettingCallbackText(data){
        console.log(data)
        if (data.result == 1){
            var name = data.data.name;
            var value = data.data.value;
            $("#setting-{0}".format(name)).children(".setting-value").text(value);
            $("#setting-{0}".format(name)).children(".setting-value-input").val("")
        }
        if (data.result == 0){
            console.log("Message: " + data.message)
            console.log("Data: " + data.data)
        }
    }



</script>
</body>
</html>
