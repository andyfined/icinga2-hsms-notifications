#!/usr/bin/env php
<?php

$country = getenv('hsms_country');
$login = getenv('hsms_login');
$password = getenv('hsms_password');
$sender = getenv('hsms_sender');

$hostdisplayname = getenv('notification_hostdisplayname');
$notificationtype = getenv('notification_type');
$pagernumber = getenv('notification_userpager');
$servicedisplayname = getenv('notification_servicedisplayname');
$serviceoutput = getenv('notification_serviceoutput');
$servicestate = getenv('notification_servicestate');

require_once "hsms-class.php";

if (strpos($servicedisplayname, ".") !== false) {
    $servicedisplayname = substr($servicedisplayname, 0, strpos($servicedisplayname, ".")) . "...";
}

$message = "[$notificationtype]\n \nHost: $hostdisplayname\nService: $servicedisplayname\nStatus: $servicestate\n \nInfo: $serviceoutput";

if (strlen($message) > 158) {
    $message = substr($message, 0, 154) . "...";
}

$sms = new SMS("https://konsoleh.your-server.de/");
$result = $sms->send($login, $password, $country, $pagernumber, $message, $sender);

// Uncomment the following code for debugging purposes
/*
file_put_contents('/tmp/service_output.log', "\n" . $message . "\n", FILE_APPEND | LOCK_EX);
file_put_contents('/tmp/host_output.log', "Date / Time: " . date("Y-m-d H:i:s")
                                          . "\n-            "
                                          . "\nSender:      " . $sender
                                          . "\nLogin:       " . $login
                                          . "\nPassword:    " . $password
                                          . "\nCountry:     " . $country
                                          . "\nPagernumber: " . $pagernumber
                                          . "\n-            "
                                          . "\nHost:        " . $hostdisplayname
                                          . "\nType:        " . $notificationtype
                                          . "\nService      " . $servicedisplayname
                                          . "\nState:       " . $servicestate
                                          . "\nOutput:      " . $serviceoutput
                                          . "\n-            "
                                          . "\n\nMessage: \n" . $message
                                          . "\n\n---\n---\n\n", FILE_APPEND | LOCK_EX);
file_put_contents('/tmp/service_output_result.log', "\n" . nl2br($result[1]) . "\n", FILE_APPEND | LOCK_EX);
*/
