#!/usr/bin/env php
<?php

$sender = getenv('HSMS_SENDER');
$login = getenv('HSMS_LOGIN');
$country = getenv('HSMS_COUNTRY');
$password = getenv('HSMS_PASSWORD');

$hostdisplayname = getenv('HOSTDISPLAYNAME');
$hostoutput = getenv('HOSTOUTPUT');
$hoststate = getenv('HOSTSTATE');
$notificationtype = getenv('NOTIFICATIONTYPE');
$pagernumber = getenv('PAGER_NUMBER');

require_once "hsms-class.php";

if (strpos($hostdisplayname, ".") !== false) {
    $hostdisplayname = substr($servicedisplayname, 0, strpos($servicedisplayname, ".")) . "...";
}

$message = "[$notificationtype]\n \nHost: $hostdisplayname\nStatus: $hoststate\n \nInfo: $hostoutput";

if (strlen($message) > 158) {
    $message = substr($message, 0, 154) . "...";
}

$sms = new SMS("https://konsoleh.your-server.de/");
$result = $sms->send($domain, $passwort, $land, $pagernumber, $message, $absender);

// Uncomment the following code for debugging purposes
/*
file_put_contents('/tmp/host_output.log', "\n" . $message . "\n", FILE_APPEND | LOCK_EX);
file_put_contents('/tmp/host_output_result.log', "\n" . nl2br($result[1]) . "\n", FILE_APPEND | LOCK_EX);
*/
