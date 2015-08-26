<?php

require_once __DIR__.'/../all.php';

$cookies = new Cookies();
$user    = $cookies->user_from_cookie();

$vars = array("uid","cid","pmt","amount");
if (set_vars($_POST, $vars) && $user !== 0){
    $order_id = $user->place_order($_POST["cid"], $_POST["pmt"], $_POST['amount']);

    // Retrieve recipients
    $recipients = DB::query('SELECT email FROM category_items WHERE id=%d', $_POST['cid']);
    $emails = array();
    foreach ($recipients as $recipient) {
        array_push($emails, $recipient['email']);
    }

    // Send email to owner
    $order = $user->getOrder($order_id);

    $parts = array();
    $parts[] = 'Order #' . $order_id;
    $parts[] = $order['recipient'];
    $parts[] = $order['phone'];
    $parts[] = $order['email'];
    $parts[] = '';
    $parts[] = $order['address'];
    $parts[] = '';
    $parts[] = $order['items'];
    $parts[] = '';
    $parts[] = '$' . $order['price'];
    $parts[] = $order['payment_type'];

    $text = implode("\n", $parts);
    $subject = $order['service'] . ', Order #' . $order_id . ' (' . $order['recipient'] . ')';
    $domain = parse_url($app->request->root(), PHP_URL_HOST);

    app('mailer')->raw($text, function($message) use ($emails, $subject, $app) {
        $message->from('info@gobring.it');
        $message->to($emails);
        $message->subject($subject);
    });
}
