#!/usr/bin/env php
<?php

$sender = getenv('HSMS_SENDER');
$login = getenv('HSMS_LOGIN');
$country = getenv('HSMS_COUNTRY');
$password = getenv('HSMS_PASSWORD');

$hostdisplayname = getenv('HOSTDISPLAYNAME');
$notificationtype = getenv('NOTIFICATIONTYPE');
$pagernumber = getenv('PAGER_NUMBER');
$servicedisplayname = getenv('SERVICEDISPLAYNAME');
$serviceoutput = getenv('SERVICEOUTPUT');
$servicestate = getenv('SERVICESTATE');

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
file_put_contents('/tmp/service_output_result.log', "\n" . nl2br($result[1]) . "\n", FILE_APPEND | LOCK_EX);
*/
