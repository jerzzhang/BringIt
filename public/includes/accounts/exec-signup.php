<?php

require_once __DIR__.'/../all.php';

$user = new UserManager();
$cookies = new Cookies();

foreach (array('name', 'email', 'password', 'phone') as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
//        echo "Failed to create account because not enough information was passed";
        header("Location: /index.php?m=3");
        exit;
    }
}

// validate data
$errors = array();
$inputs = app('request')->input();

if (!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
    array_push($errors, 'Invalid email');
}
if (!isPhone($inputs['phone'])) {
    array_push($errors, 'Invalid phone');
}

if (!empty($errors)) {
    header("Location: /index.php?m=13");
    exit;
}

if ($user->is_account_available($_POST["email"])){
    $id = $user->add_user($_POST["name"], $_POST["email"], $_POST["password"], $_POST["phone"]);
    if ($id != 0){
        $user_obj = $user->get_user_from_insertid($id);
        $cookies->set_cookie($user_obj->data["uid"]); // log the user in
//        header("Location: /index.php?m=1");
        header("Location: /profile.php?p=2&m=6");
        exit;

//        successful!
//        send an email?
//        $new_user = $user->get_user_from_insertid($id);
//        echo "Created account " . $id  . ". Sending email.";
        }
//    else{
//        echo "fuck";
//    }
}
else{
//    echo "Failed to create account because of availability.";
    header("Location: /index.php?m=2");
    exit;
}
