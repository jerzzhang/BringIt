<?php

return [
    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'),
        'client_secret' => env('FACEBOOK_APP_SECRET'),
        'redirect' => env('FACEBOOK_APP_REDIRECT'),
    ],
    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],
];
