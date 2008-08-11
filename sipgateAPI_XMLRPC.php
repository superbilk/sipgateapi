<?php
/**
 * A PHP wrapper for sipgateAPI aka SAMURAI
 * 
 * This is a private project. 
 * It uses the API provided by sipgate, but sipgate can not and will not support any problems with this software. 
 * You can find the API (including documentation) here: http://www.sipgate.de/api 
 *   
 * V0.5 click2dial<br />
 * V0.4 sending fax<br />
 * V0.3 supporting all "server." methods<br />
 * V0.2 sending SMS<br />
 * V0.1 Proof of Concept<br />
 * 
 * @author Christian Schmidt
 * @license 
 * @copyright Copyright 2007, Christian Schmidt
 * 
 * @package sipgateAPI
 */

/**
 * Include Exception handling
 */
require_once 'sipgateAPI_Exception.php';

/**
 * Implements the samurai functionality for PHP programers. So you don't have to mess around with XML-RPC<br />
 * Requires "XML-RPC for PHP" (http://phpxmlrpc.sourceforge.net)
 * 
 * This is a private project. 
 * It uses the API provided by sipgate, but sipgate can not and will not support any problems with this software.
 * You can find the API (including documentation) here: http://www.sipgate.de/api
 * 
 * @package sipgateAPI
 * @subpackage sipgateAPI_XMLRPC
 * 
 * @todo decode all dateTime responses from Server
 * @todo implemet all samurai methods
 * @todo better error handling
 * @todo better documentation
 * @todo dynamic TOS array
 * 
 * @version 0.5
 * @author Christian Schmidt
 */
class sipgateAPI_XMLRPC {

	const ClientVersion	= 0.5;
	const ClientName	= 'sipgateAPI with PHP';
	const ClientVendor	= 'Christian Schmidt';
	
	const debug		= FALSE;
	
	const prot 		= 'https';
	const host 		= 'samurai.sipgate.net';
	const port 		= '443';
	const RPC_path 	= '/RPC2'; 

	protected $supportedTOS = NULL;
	protected $supportedMethods = NULL;
	protected $client;	

	private $url;
	
	protected $prefix = "system.";

	
	/**#@+
     *@ignore
     */
	const SIP_URI_prefix 	= 'sip:';
	const SIP_URI_host 		= '@sipgate.net';
	/**#@-*/



	/**
	 * Checks if XML-RPC for PHP is included
	 * 
	 * @throws sipgateAPI_Exception when XML-RPC for PHP is not available
	 */
	public function __construct($username = NULL, $password = NULL, $debug = NULL) 
	{
    	// Check if xmlrpc is included
    	if (!class_exists("xmlrpc_client")) {
    		throw new sipgateAPI_Exception ('You need "xmlrpc for PHP" - Please download at <a href="http://phpxmlrpc.sourceforge.net">http://phpxmlrpc.sourceforge.net</a>');
    	};
    	
    	if ( isset($username) AND isset($password) ) {
    		$this->setClient($username, $password, $debug);
    	};
	}



	/**
	 * configures a URI to connect to XML-RPC server
	 * 
	 * @param string $username Your sipgate username - the one you use on the website, NOT your SIP-ID
	 * @param string $password
	 * @param bool $debug enable debug information
	 * 
	 * @return bool always true
	 */
	 public function setClient($username, $password, $debug = this::debug) 
	 {
	   	// Build URL
    	$this->url = self::prot . "://" . $username . ":" . $password . "@" . self::host . ":" . self::port .self::RPC_path;
    	
    	// create client
    	$this->client = new xmlrpc_client($this->url);
    	if ($debug) {
    		$this->client->setDebug(2);	
    	}
    	$this->client->setSSLVerifyPeer(FALSE);
    	return true; 
	 	
	 } // function setClient








} // class sipgateAPI


?>