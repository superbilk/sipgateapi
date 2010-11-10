<?php

require_once ('../xmlrpc/lib/xmlrpc.inc');
require_once ('../sipgateAPI.php');


/*
 * set your username and passwort
 * it is your web-username/-passwort, NOT your SIP-ID/-Password
 *
 * mobilenumber format like 491719999999
 */

$username = "";
$password = "";

$mobilenumber = "";
$message = "";

$faxnumber = "";
$file = "./test.pdf";

$myAPI = new sipgateAPI($username, $password);
$r = $myAPI->getBalance();
print_r($r);

$myAPI->sendSMS($mobilenumber, $message);

$r = $myAPI->sendFax($faxnumber, $file);
print_r($r);