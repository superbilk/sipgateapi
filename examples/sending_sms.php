<?php


/*
 * please adjust path to class and pdf file
 */
include ('../xmlrpc/lib/xmlrpc.inc');
include ('../sipgateAPI.php');


/*
 * set your username and passwort
 * it is your web-username/-passwort, NOT your SIP-ID/-Password
 */
$username = "username";
$password = "password";


/*
 * set recipient information
 * phone number in E.164 format, like 496912345678
 */ 
$sms_recipient = "49";


/*
 * set your message
 */
$message = "Testmessage";

/*
 * Sending SMS
 */

$myAPI = new sipgateAPI($username, $password);

try 
{
	$myAPI->sendSMS($sms_recipient, $message);
}
catch (sipgateAPI_Exception $e) 
{
	echo "<pre>Error: " . $e->getCode() . " : " . $e->getMessage() . "</pre>";	
}
