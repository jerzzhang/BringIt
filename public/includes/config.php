<?php

$mysql_host = $_ENV['DB_HOST'];
$mysql_port = $_ENV['DB_PORT'];
$mysql_user = $_ENV['DB_USERNAME'];
$mysql_pass = $_ENV['DB_PASSWORD'];
$mysql_db   = $_ENV['DB_DATABASE'];

$services_hard_display_limit = 4; // display 4 services on home page

$messages = array(
    null, // 0 = no message
    // account registration 1-3
    null, //"Account successfully registered!", // removed because of redirect to profile
    "Account has already been registered with that information",
    "Insufficient information received to register account",
    // login 4-6
    "Insufficient credentials passed, please check and try again",
    "Your combination of email/password credentials is incorrect",
    "Logged in!",
    // log out 7-8
    "Successfully logged out", // 7
    "Unable to log out",
    "You do not have permission to view this page",
    "Please add an address before continuing",
    "Email sent! Please check your inbox.", // 11
    "Your password has been reset! Please try it out now.",
    "Please enter valid details", // 13
);
