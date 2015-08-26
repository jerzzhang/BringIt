<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
    echo $app->welcome();
});

$verify = function($email, $expiry) {
    $data = $email . '|' . $expiry;
    $token = hash_hmac('ripemd160', $data, getenv('APP_KEY'));
    return $token;
};

// Generate a request to verify an email address
$app->post('/accounts/forgot-password', function() use ($app, $verify) {
    $email = $app->request->input('reset-email');
    if (!empty($email)) {
        // validate email exists in database
        $matches = app('db')->table('accounts')
            ->where('email', 'like', $email)
            ->first();

        if (!empty($matches)) {
            $expiry = strtotime('+1 day');
            $token = $verify($email, $expiry);
            $query = http_build_query(
                [
                    'email' => $email,
                    'expiry' => $expiry,
                    'token' => $token,
                ]
            );
            $link = $app->request->root() . '/accounts/confirm-account?' . $query;

            // send email
            $text = 'Visit the following link to confirm your email address and reset your password: ' . $link;
            app('mailer')->raw($text, function($message) use ($email, $app) {
                $message->from('info@gobring.it');
                $message->to($email);
                $message->subject('Reset Password Link for ' . $app->request->root());
            });

            return redirect('/index.php?m=11');
        }
    }
    return redirect('/index.php?m=4');
});

// Confirm an email account and ask to reset password
$app->get('/accounts/confirm-account', function() use ($app, $verify) {
    $email = $app->request->input('email');
    $expiry = $app->request->input('expiry');
    $token = $app->request->input('token');
    $hash = $verify($email, $expiry);

    if ($hash === $token) {
        $query = http_build_query(
            [
                'email' => $email,
                'expiry' => $expiry,
                'token' => $token,
            ]
        );
        return redirect('/index.php?' . $query . '#reset-password');
    }
    return redirect('/index.php?m=4');
});

// Reset password
$app->post('/accounts/reset-password', function() use ($app, $verify) {
    $email = $app->request->input('email');
    $expiry = $app->request->input('expiry');
    $token = $app->request->input('token');
    $hash = $verify($email, $expiry);

    $password = $app->request->input('password');

    if ($hash === $token && !empty($password)) {
        $salt = uniqid(mt_rand(), true);
        $hash = hash('sha512', $password . $salt);

        // reset password
        app('db')->table('accounts')
            ->where('email', 'like', $email)
            ->update([
                'password_hash' => $hash,
                'password_salt' => $salt,
            ]);

        return redirect('/index.php?m=12');
    }
    return redirect('/index.php?m=4');
});

// Save credit card token
$app->post('/credit-card/save', function() use ($app) {
    $token = $app->request->input('stripeToken');

    \Stripe\Stripe::setApiKey(env('STRIPE_API_SECRET'));

    // retrieve user information
    require_once __DIR__.'/../../public/includes/all.php';
    $cookies = new Cookies();
    $user = $cookies->user_from_cookie();

    $customer = null;
    if (!empty($user->data['stripe_cust_id'])) {
        $customer = \Stripe\Customer::retrieve($user->data['stripe_cust_id']);
        $customer->sources->create([
            'source' => $token,
        ]);
    } else {
        $customer = \Stripe\Customer::create([
            'source' => $token,
            'description' => $user->data['name'],
            'email' => $user->data['email'],
        ]);

        // save customer ID
        $customer->id;

        app('db')->table('accounts')
            ->where('id', $user->data['id'])
            ->update([
                'stripe_cust_id' => $customer->id,
            ]);
    }

    return redirect('/profile.php');
});

// Delete credit card token
$app->post('/credit-card/delete', function() use ($app) {
    $cardId = $app->request->input('credit-card-id');

    \Stripe\Stripe::setApiKey(env('STRIPE_API_SECRET'));

    // retrieve user information
    require_once __DIR__.'/../../public/includes/all.php';
    $cookies = new Cookies();
    $user = $cookies->user_from_cookie();

    if (!empty($user->data['stripe_cust_id'])) {
        $customer = \Stripe\Customer::retrieve($user->data['stripe_cust_id']);
        $customer->sources->retrieve($cardId)->delete();
    }

    return redirect('/profile.php');
});

// Social Authentication (Facebook) redirect
$app->get('/accounts/facebook', function() use ($app) {
    return $app['Laravel\Socialite\Contracts\Factory']
        ->with('facebook')
        ->scopes(['public_profile', 'email'])
        ->redirect();
});

// Social Authentication (Facebook) callback
$app->get('/accounts/facebook/handler', function() use ($app) {
    try {
        require_once __DIR__.'/../../public/includes/all.php';
        $cookies = new Cookies();

        $fbuser = $app['Laravel\Socialite\Contracts\Factory']
            ->with('facebook')
            ->scopes(['public_profile', 'email'])
            ->user();

        // retrieve user information
        $user = app('db')->table('accounts')
            ->where('facebook_id', $fbuser->id)
            ->first();

        // log this user in!
        if (!empty($user)) {
            $cookies->set_cookie($user->uid);
            return redirect('/profile.php?p=2&m=6');
        }

        // check if this email already exists and ask for password
        $user = app('db')->table('accounts')
            ->where('email', 'like', $fbuser->email)
            ->first();

        if (!empty($user)) {
            // TODO: for now, do nothing; ask user to reset password
            $query = http_build_query([
                'email' => $fbuser->email,
                'facebook_id' => $fbuser->id,
            ]);
            return redirect('/index.php?' . $query . '#facebook-connect');
        }

        // attempt to sign this user up
        $uid = GUID(50);
        $salt = uniqid(mt_rand(), true);
        $user_id = app('db')->table('accounts')
            ->insertGetId([
                'name' => $fbuser->name,
                'uid' => $uid,
                'email' => $fbuser->email,
                'phone' => '',
                'logintime' => '0',
                'password_hash' => hash('sha512', $salt),
                'password_salt' => $salt,
                'session' => '0',
                'facebook_id' => $fbuser->id,
            ]);
        if ($user_id > 0) {
            // manually set session; DB::update doesn't work for some reason
            $cookie_id = $cookies->set_cookie($uid);
            app('db')->table('accounts')
                ->where('id', $user_id)
                ->update([
                    'session' => $cookie_id,
                    'logintime' => strval(time()),
                ]);
            return redirect('/profile.php?p=2&m=6');
        }
    } catch (Exception $e) {
        return 'An error occurred';
    }

    return redirect('/index.php?m=2');
});

// Social Authentication (Facebook) connect
$app->post('/accounts/facebook/connect', function() use ($app) {
    $facebook_id = $app->request->input('facebook_id');
    $email = $app->request->input('email');
    $password = $app->request->input('password');

    $user = app('db')->table('accounts')
        ->where('email', 'like', $email)
        ->first();

    // store ID
    if (!empty($user)) {
        require_once __DIR__.'/../../public/includes/all.php';

        $manager = new UserManager();
        $auth = $manager->auth_user($email, $password);

        // validate password
        if (!empty($auth[1])) {
            app('db')->table('accounts')
                ->where('id', $user->id)
                ->update([
                    'facebook_id' => $facebook_id,
                ]);

            $cookies = new Cookies();
            $cookies->set_cookie($user->uid);
            return redirect('/profile.php?p=2&m=6');
        }
    }
    return redirect('/index.php?m=2');
});

// Save main category settings
$app->post('/admin/category/{categoryId}', function($categoryId) use ($app) {
    $inputs = $app->request->input();
    if (empty($inputs['name'])) {
        unset($inputs['name']);
    }

    // grab existing service
    $category = app('db')->table('categories')
        ->where('id', $categoryId)
        ->first();

    if ($category->displayorder != $inputs['displayorder']) {
        // swap existing order
        app('db')->table('categories')
            ->where('displayorder', $inputs['displayorder'])
            ->update([
                'displayorder' => $category->displayorder,
            ]);
    }

    app('db')->table('categories')
        ->where('id', $categoryId)
        ->update($inputs);
});

// Create new main category
$app->post('/admin/category', function() use ($app) {
    $inputs = $app->request->input();
    if (empty($inputs['name'])) {
        return 0;
    }

    $max = app('db')->table('categories')->max('displayorder');
    $inputs['displayorder'] = $max + 1;

    $id = app('db')->table('categories')
        ->insertGetId($inputs);
    return $id;
});

// Delete main category
$app->post('/admin/category/{categoryId}/delete', function($categoryId) use ($app) {
    // grab existing service
    $category = app('db')->table('categories')
        ->where('id', $categoryId)
        ->delete();
});

