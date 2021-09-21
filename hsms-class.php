<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * $Id$
 *
 * client sms gateway class - lies in /usr/local/lib/php
 *
 */
class SMS {

  /**
   * Server that works as Gateway (usually konsoleH Server)
   *
   * @var string
   */
  var $kH_Server;

  /**
   * Constructor
   *
   * @param string $server Server that works as Gateway (usually konsoleH Server)
   */
  public function __construct($server) {
    $server          = substr($server, -1, 1) == "/" ? $server : $server . "/";
    $this->kH_Server = $server;
  }

  public function SMS() {
    $this->__construct();
  }

  /**
   * Send the request to konsoleH Server
   *
   * @param string $domain_name
   * @param string $password
   * @param string $recipient_number
   * @param string $text
   * @return array Result of the Request
   */
  public function send($domain_name, $password, $country_prefix, $recipient_number, $text, $sender = "") {

    $recipient_number = preg_replace("%[^0-9]%", "", $recipient_number);
    $country_prefix   = "+" . preg_replace("%[^0-9]%", "", $country_prefix);
//    $hostname         = `hostname`;
    $hostname         = "www510.your-server.de";
    $ch               = curl_init();

    curl_setopt($ch, CURLOPT_URL, $this->kH_Server . "sms_gateway.php");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "konsoleH-SMS-Gateway Script");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "action=gateway&SERVER=" . urlencode(trim($hostname)) . "&DOMAIN_NAME=" . urlencode(trim($domain_name)) . "&PASSWORD=" . urlencode(trim($password)) . "&PREFIX_MOBILE_NUMBER=" . urlencode(trim($country_prefix)) . "&MOBILE_NUMBER=" . urlencode(trim($recipient_number)) . "&SMS_TEXT=" . urlencode(trim($text)) . "&SMS_SENDER=" . urlencode(trim($sender)));
    echo $this->kH_Server."sms_gateway.php"."?action=gateway&SERVER=".trim($hostname)."&DOMAIN_NAME=$domain_name&PASSWORD=$password&PREFIX_MOBILE_NUMBER=$country_prefix&MOBILE_NUMBER=$recipient_number&SMS_TEXT=$text";
    $return = explode("|", curl_exec($ch));
    return $return;
    if (is_array($return) && count($return) == 2) {
      return $return;
    } else {
      return array(0, "Unknown Error");
    }
    curl_close($ch);
  }
}
