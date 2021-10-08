#!/usr/bin/env php
<?php

$sender = getenv('hsms_sender');
$login = getenv('hsms_login');
$country = getenv('hsms_country');
$password = getenv('hsms_password');

$hostdisplayname = getenv('notification_hostdisplayname');
$hostoutput = getenv('notification_hostoutput');
$hoststate = getenv('notification_hoststate');
$notificationtype = getenv('notification_type');
$pagernumber = getenv('notification_userpager');

require_once "hsms-class.php";

if (strpos($hostdisplayname, ".") !== false) {
    $hostdisplayname = substr($hostdisplayname, 0, strpos($hostdisplayname, ".")) . "...";
}

$message = "[$notificationtype]\n \nHost: $hostdisplayname\nStatus: $hoststate\n \nInfo: $hostoutput";

if (strlen($message) > 158) {
    $message = substr($message, 0, 154) . "...";
}

$sms = new SMS("https://konsoleh.your-server.de/");
$result = $sms->send($login, $password, $country, $pagernumber, $message, $sender);

// Uncomment the following code for debugging purposes
/*
file_put_contents('/tmp/host_output.log', "Date / Time: " . date("Y-m-d H:i:s")
                                          . "\n-            "
                                          . "\nSender:      " . $sender
                                          . "\nLogin:       " . $login
                                          . "\nPassword:    " . $password
                                          . "\nCountry:     " . $country
                                          . "\nPagernumber: " . $pagernumber
                                          . "\n-            "
                                          . "\nHost:        " . $hostdisplayname
                                          . "\nState:       " . $hoststate
                                          . "\nType:        " . $notificationtype
                                          . "\nOutput:      " . $hostoutput
                                          . "\n-            "
                                          . "\n\nMessage: \n" . $message
                                          . "\n\n---\n---\n\n", FILE_APPEND | LOCK_EX);
file_put_contents('/tmp/host_output_result.log', "\n" . nl2br($result[1]) . "\n", FILE_APPEND | LOCK_EX);
*/
