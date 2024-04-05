<?php

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

function pp($arr, $die = "true")
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    if ($die == 'true') {
        die();
    }
}
function sendMail($view, $subject, $email, $data=[])
{
    Mail::send($view, $data, function (Message $msg) use ($email, $subject) {
        $msg->subject($subject);
        $msg->to($email);
    });
}