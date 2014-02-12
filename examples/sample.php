<?php

set_include_path(get_include_path() . PATH_SEPARATOR . '../phpxmlrpc/lib/');
require_once( 'xmlrpc.inc' );
require_once( 'xmlrpcs.inc' );
require_once( 'xmlrpc_wrappers.inc' );
require_once ('../sipgateAPI.php');

/*
 * set your username and passwort
 * it is your web-username/-passwort, NOT your SIP-ID/-Password
 *
 * mobilenumber format like 491719999999
 */

$username = "";
$password = "";

$myAPI = new sipgateAPI($username, $password);
$r = $myAPI->getBalance();
print_r($r);

//$mobilenumber = "";
//$message = "";

//$faxnumber = "";
//$file = "./test.pdf";

//$myAPI->sendSMS($mobilenumber, $message);

//$r = $myAPI->sendFax($faxnumber, $file);
//print_r($r);
