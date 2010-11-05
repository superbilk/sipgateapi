<?php

require_once ('../xmlrpc/lib/xmlrpc.inc');
require_once ('../sipgateAPI.php');


/*
 * set your username and passwort
 * it is your web-username/-passwort, NOT your SIP-ID/-Password
 */
$username = "";
$password = "";

$myAPI = new sipgateAPI($username, $password);
$r = $myAPI->getBalance();

print_r($r);
