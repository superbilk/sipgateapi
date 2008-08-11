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
 * Include XMLRPC base methods for sipgateAPI
 */
require_once 'sipgateAPI_XMLRPC.php';

/**
 * Implements the samurai functionality for PHP programers. So you don't have to mess around with XML-RPC<br />
 * Requires "XML-RPC for PHP" (http://phpxmlrpc.sourceforge.net)
 * 
 * This is a private project. 
 * It uses the API provided by sipgate, but sipgate can not and will not support any problems with this software.
 * You can find the API (including documentation) here: http://www.sipgate.de/api
 * 
 * @package sipgateAPI
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
class sipgateAPI Extends sipgateAPI_XMLRPC 
{
	
	
	public function __construct($username = NULL, $password = NULL, $debug = NULL) 
	{
		parent::__construct($username = NULL, $password = NULL, $debug = NULL);
	}
	
	

	
	/**
	 * implements <i>samurai.AccountStatementGet</i>
	 * 
	 *@param unix_timestamp $PeriodStart
	 *@param unix_timestamp $PeriodEnd
	 *
	 *@return array
	 * 
	 *@throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_AccountStatementGet($PeriodStart, $PeriodEnd)
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		}
		
		$v = array( new xmlrpcval( 	array(
				"PeriodStart" => new xmlrpcval(iso8601_encode($PeriodStart), "dateTime.iso8601"),
				"PeriodEnd" => new xmlrpcval(iso8601_encode($PeriodEnd), "dateTime.iso8601")
				), 
			"struct"));
	
		// create message
		$m = new xmlrpcmsg('samurai.AccountStatementGet', $v);
  
		// send message		
		$r = $this->client->send($m);


  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			unset($php_r["StatusCode"]);
  			unset($php_r["StatusString"]);
  			return $php_r;
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}		

	/**
	 * implements <i>samurai.BalanceGet</i>
	 *
	 * @param void
	 *
	 * @return array
	 * 
	 * @throws sipgateAPI_Server_Exception on Server responses != 200 OK  
	 *
	 */
	public function samurai_BalanceGet()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		}
		
		// create message
		$m = new xmlrpcmsg('samurai.BalanceGet');
  
		// send message		
		$r = $this->client->send($m);

  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			unset($php_r["StatusCode"]);
  			unset($php_r["StatusString"]);
  			return $php_r;
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}		

	/**
	 * implements <i>samurai.ClientIdentify</i>
	 * 
	 * Usefull for support requests and debug 
	 * 
	 * @param mixed $ClientVersion Clientinformation
	 * @param mixed $ClientName Clientinformation
	 * @param mixed $ClientVendor Clientinformation
	 * 
	 * @throws sipgateAPI_Server_Exception on Server responses != 200 OK
	 */
	public function samurai_ClientIdentify($ClientVersion 	= self::ClientVersion, 
										   $ClientName 		= self::ClientName, 
										   $ClientVendor	= self::ClientVendor) 
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		}

		// create values		
		$v = array( new xmlrpcval( array(
				"ClientVersion" => new xmlrpcval($ClientVersion),
				"ClientName" => new xmlrpcval($ClientName),
				"ClientVendor" => new xmlrpcval($ClientVendor)
				), 
			"struct"));
		
		// create message
		$m = new xmlrpcmsg('samurai.ClientIdentify', $v);
		
		
		// send message
		$r = $this->client->send($m);
		
		if (!$r->faultCode()) {
			return true;
			// returns an php-array
			//echo "<pre>";print_r(php_xmlrpc_decode($r->value()));echo "</pre>";
		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	 } // public function ClientIdentify


	/**
	 *implements <i>samurai.HistoryGetByDate</i>
	 *
	 *@param array $LocalUriList
	 *@param array $StatsuList
	 *@param unix_timestamp $PeriodStart
	 *@param unix_timestamp @PeriodEnd
	 *
	 *@return array
	 * 
	 *@throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_HistoryGetByDate($LocalUriList = NULL, $StatusList = NULL, $PeriodStart = NULL, $PeriodEnd = NULL)
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};

		if ( isset($LocalUriList) ) {
			if ( is_array($LocalUriList) ) {
			$val_a["LocalUriList"] = new xmlrpcval();
			$val_a["LocalUriList"]->addArray($this->xmlrpcArray($LocalUriList));
			}
			else {
				throw new sipgateAPI_Exception("LocalUriList is not an array");
			};
		};
	
		if ( isset($StatusList) ) {
			if ( is_array($StatusList) ) {
			$val_a["StatusList"] = new xmlrpcval();
			$val_a["StatusList"]->addArray($this->xmlrpcArray($StatusList));
			}
			else {
				throw new sipgateAPI_Exception("StatusList is not an array");
			};
		};

		if ( isset($PeriodStart) ) {
			$val_a["PeriodStart"] = new xmlrpcval();
			$val_a["PeriodStart"]->addScalar(iso8601_encode($PeriodStart), "dateTime.iso8601");	
		};
		
		if ( isset($PeriodStart) ) {
			$val_a["PeriodEnd"] = new xmlrpcval();
			$val_a["PeriodEnd"]->addScalar(iso8601_encode($PeriodStart), "dateTime.iso8601");
		};	

		if ( isset($val_a) ) {
			$val_s = new xmlrpcval();
			$val_s->addStruct($val_a);						
			$v = array();
			$v[] = $val_s;
		}
		else {
			$v = array();
		};


		// create message
		$m = new xmlrpcmsg('samurai.HistoryGetByDate', $v);
  
		// send message		
		$r = $this->client->send($m);

  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			unset($php_r["StatusCode"]);
  			unset($php_r["StatusString"]);
  			return $php_r["History"];
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}		




	/**
	 *implements <i>samurai.ItemizedEntriesGet</i>
	 * 
	 * @param array,|void $LocalUriList can be empty or an array of URI
	 * @param unix_timestamp $PeriodStart
	 * @param unix_timestamp $PeriodEnd
	 *
	 * @throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_ItemizedEntriesGet($LocalUriList, $PeriodStart, $PeriodEnd)
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		if ( isset($LocalUriList) ) {
			if ( is_array($LocalUriList) ) {
				$val_a["LocalUriList"] = new xmlrpcval();
				$val_a["LocalUriList"]->addArray($this->xmlrpcArray($LocalUriList));
			}
			else {
				throw new sipgateAPI_Exception("LocalUriList is not an array");
			};
		};
	
		if ( isset($PeriodStart) ) {
			$val_a["PeriodStart"] = new xmlrpcval();
			$val_a["PeriodStart"]->addScalar(iso8601_encode($PeriodStart), "dateTime.iso8601");	
		}
		else {
			throw new sipgateAPI_Exception("PeriodStart is empty");
		};
		
		if ( isset($PeriodStart) ) {
			$val_a["PeriodEnd"] = new xmlrpcval();
			$val_a["PeriodEnd"]->addScalar(iso8601_encode($PeriodStart), "dateTime.iso8601");
		}
		else {
			throw new sipgateAPI_Exception("PeriodEnd is empty");
		};

		$val_s = new xmlrpcval();
		$val_s->addStruct($val_a);						
		$v = array();
		$v[] = $val_s;


		// create message
		$m = new xmlrpcmsg('samurai.ItemizedEntriesGet', $v);
  
		// send message		
		$r = $this->client->send($m);

  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			unset($php_r["StatusCode"]);
  			unset($php_r["StatusString"]);
  			return $php_r;
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}
		


	/**
	 *implements <i>samurai.OwnUriListGet</i>
	 * 
	 * @param void
	 * 
	 * @return array
	 *
	 * @throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_OwnUriListGet()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// create message
		$m = new xmlrpcmsg('samurai.OwnUriListGet');
  
		// send message		
		$r = $this->client->send($m);


  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			unset($php_r["StatusCode"]);
  			unset($php_r["StatusString"]);
  			return $php_r["OwnUriList"];
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}



	/**
	 *implements <i>samurai.PhonebookEntryGet</i>
	 * 
	 * Not supported in this Version
	 *
	 *@throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_PhonebookEntryGet()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// method not supported
		throw new sipgateAPI_Exception(__METHOD__ . " not supported");
	}


	/**
	 *implements <i>samurai.PhonebookListGet</i>
	 * 
	 * Not supported in this Version
	 *
	 *@throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_PhonebookListGet()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// create message
		$m = new xmlrpcmsg('samurai.PhonebookListGet');
  
		// send message		
		$r = $this->client->send($m);


  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			unset($php_r["StatusCode"]);
  			unset($php_r["StatusString"]);
  			return $php_r["PhonebookList"];
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}



	/**
	 *implements <i>samurai.RecommendedIntervalGet</i>
	 * 
	 * Not supported in this Version
	 *
	 *@throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_RecommendedIntervalGet()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// method not supported
		throw new sipgateAPI_Exception(__METHOD__ . " not supported");
	}



	/**
	 *implements <i>samurai.ServerdataGet</i>
	 * 
	 * @param void
	 * 
	 * @return array
	 *
	 *@throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_ServerdataGet()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// create message
		$m = new xmlrpcmsg('samurai.ServerdataGet');
  
		// send message		
		$r = $this->client->send($m);


  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			unset($php_r["StatusCode"]);
  			unset($php_r["StatusString"]);
  			return $php_r;
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}




	/**
	 *implements <i>samurai.SessionClose</i>
	 * 
	 * Not supported in this Version
	 *
	 *@throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_SessionClose()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// method not supported
		throw new sipgateAPI_Exception(__METHOD__ . " not supported");
	}




	/**
	 * implements <i>samurai.SessionInitiate</i>
	 * 
	 *@param string $LocalUri as SIP-URI
	 *@param string $RemoteUri as SIP-URI
	 *@param string $TOS Type of service as defined in $availableTOS
	 *@param string $Content depends on TOS
	 *@param dateTime $schedule as unix timestamp
	 *
	 * @return string SessionID, if available
	 * 
	 * @throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_SessionInitiate($LocalUri, $RemoteUri, $TOS, $Content, $Schedule = NULL)
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		}
		
		if ( isset($LocalUri) ) {
			$val_a["LocalUri"] = new xmlrpcval($LocalUri);	
		};
		
		if ( isset($RemoteUri) ) {
			$val_a["RemoteUri"] = new xmlrpcval($RemoteUri);
		}
		else {
			throw new sipgateAPI_Exception("No RemoteUri"); 
		};
		
		if ( isset($TOS) AND $this->tosSupported($TOS) ) {
			$val_a["TOS"] = new xmlrpcval($TOS);
		}
		else {
			throw new sipgateAPI_Exception("No valid TOS");
		};
		
		if ( isset($Content) ) {
			$val_a["Content"] = new xmlrpcval($Content);
		};
		
		if ( isset($Schedule) ) {
			$val_a["Schedule"] = new xmlrpcval(iso8601_encode($Schedule), "dateTime.iso8601");
		};

		$val_s = new xmlrpcval();
		$val_s->addStruct($val_a);						
		$v = array();
		$v[] = $val_s;
		
		// create message
		$m = new xmlrpcmsg('samurai.SessionInitiate', $v);
  
		// send SMS		
		$r = $this->client->send($m);


  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			return $php_r["SessionID"];
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}		





	/**
	 * implements <i>samurai.SessionInitiateMulti</i>
	 * 
	 * Not supported in this Version
	 *
	 * @throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_SessionInitiateMulti()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// method not supported
		throw new sipgateAPI_Exception(__METHOD__ . " not supported");
	}


	/**
	 * implements <i>samurai.SessionStatusGet</i>
	 * 
	 * Not supported in this Version
	 *
	 * @throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_SessionStatusGet()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// method not supported
		throw new sipgateAPI_Exception(__METHOD__ . " not supported");
	}


		/**
	 * implements <i>samurai.TosListGet</i>
	 * 
	 * @param void
	 *
	 * @throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_TosListGet()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// create message
		$m = new xmlrpcmsg('samurai.TosListGet');
  
		// send message		
		$r = $this->client->send($m);


  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			unset($php_r["StatusCode"]);
  			unset($php_r["StatusString"]);
  			return $php_r["TosList"];
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}
	



	/**
	 * implements <i>samurai.UmSummaryGet</i>
	 * 
	 * Not supported in this Version
	 *
	 * @throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function samurai_UmSummaryGet()
	{
		// checks if method is supported
		if ( ! $this->methodSupported(__FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// method not supported
		throw new sipgateAPI_Exception(__METHOD__ . " not supported");
	}

	/**
	 * implements <i>samurai.UserdataGreetingGet</i>
	 * 
	 * Not supported in this Version
	 *
	 * @throws sipgateAPI_Server_Exception on Server responses != 200 OK   
	 */
	public function UserdataGreetingGet()
	{
		echo "method called\n";
		echo $this->prefix . __FUNCTION__; exit;
		// checks if method is supported
		if ( ! $this->methodSupported($this->prefix . __FUNCTION__) ) {
			throw new sipgateAPI_Exception("Method not supported", 400);
		};
		
		// method not supported
		throw new sipgateAPI_Exception(__METHOD__ . " not supported");
	}





	


	/**
	 * Click2Dial
	 * 
	 * Call this method to initiate a phone call! First your phone rings, when you answere, the callees phone rings.
	 * You can use it for a callback service at your homepage
	 * 
	 * @param string $caller your phone number, like 492111234567
	 * @param string $callee other persons phone number, like 492111234567
	 * 
	 * @return string SessionID, if available
	 * 
	 */
	public function click2dial($caller, $callee) 
	{
		//if (!$this->checkNumber($to))
		//	return "$to is no phone number, example: 491701234567";
			
		$caller = self::SIP_URI_prefix . $caller . self::SIP_URI_host;
		$callee = self::SIP_URI_prefix . $callee . self::SIP_URI_host;
		
		$this->samurai_SessionInitiate($caller, $callee, "voice", "");
			
	}



	/**
	 * sending SMS
	 * 
	 * Sending a text message to a (mobile) phone. Message will be cut off after 160 characters
	 * 
	 * @param string $to mobile number, example: 491701234567
	 * @param string $text cut off after 160 chars
	 * @param string $time unix timestamp in UTC  
	 * 
	 * @return 
	 */
	public function sendSMS($to, $text, $time = NULL) 
	{
		$number = self::SIP_URI_prefix . $to . self::SIP_URI_host;
		
		$text = substr($text, 0, 160);

		$this->samurai_SessionInitiate(NULL, $number, "text", $text, $time);
	}




	/**
	 * sending a PDF file as fax
	 * 
	 * @param string $to fax number, example: 492111234567
	 * @param string $file 
	 * @param string $time unix timestamp in UTC  
	 * 
	 * @return string Returns SessionID
	 */
	public function sendFAX($to, $file, $time = NULL) 
	{
		$number = self::SIP_URI_prefix . $to . self::SIP_URI_host;
		
		$file = realpath($file);
		
		if ( !file_exists($file) ) {
			throw new Exception("PDF file does not exist");
		}
		elseif ( strtolower(pathinfo($file, PATHINFO_EXTENSION)) != 'pdf' ) {
			throw new Exception("No PDF file");
		};
		
		
		$pdf_base64 = base64_encode(file_get_contents($file));
		$r = $this->samurai_SessionInitiate(NULL, $number, "fax", $pdf_base64, $time);
		
		return $r;		
	}





	/**
	 * Checks if method is supported
	 * 
	 * @param string $MethodName CAUTION: uses internal method name. Example: system_ServerInfo NOT: system.serverInfo
	 * 
	 * @return bool
	 */
	public function methodSupported($MethodName)
	{
		if ( !$this->supportedMethods) {
			$this->prefix = "system.";
			$this->supportedMethods = $this->listMethods();
		};
		
		if ( !(array_search($MethodName, $this->supportedMethods) === FALSE)) {
			return TRUE;
		};
		return FALSE;
	}


	/**
	 * Checks if TOS is supported
	 * 
	 * @param string $TOS
	 * 
	 * @return bool
	 */
	public function tosSupported($TOS)
	{
		$MethodName = str_replace("_", ".", $MethodName);
		if ( !$this->supportedTOS) {
			$this->supportedTOS = $this->samurai_TosListGet();
		};
		
		if ( !(array_search($TOS, $this->supportedTOS) === FALSE)) {
			return TRUE;
		};
		return FALSE;
	}


	/**
	 * transform an array to an xmlrpc-array
	 * 
	 * all values become a xmlrpcval-object
	 * 
	 * @param array
	 * 
	 * @return array with values as xmlrpc objects 
	 */
	protected function xmlrpcArray(&$array) {
		$tmp = array();
		foreach ($array as $value) {
			$tmp[] = new xmlrpcval($value);
		};
		return $tmp;
	}


	/**
	 * unfortunately you can not use a . (dot) in method calls, so we define a prefix here
	 * 
	 * Example: $myAPI->serverInfo() would call method: system.serverInfo()
	 */
	public function setPrefix($pre = self::prefix)
	{
		$this->prefix = $pre;
	}

	/**
	 * implements ALL server methods with __call
	 * 
	 * @param mixed $params please refer to documentation, params must be in same order, set optional parameter = NULL
	 * 
	 * @return array
	 */
	public function __call($method, $arguments)
	{
		$v = array();
		
		
		if ($this->prefix == "system." ) {
			switch ($method) {
				
				
				case "listMethods" 	: break;
				
				case "methodHelp"	:
						$v["MethodName"] = new xmlrpcval($arguments[0], "string");
						
				case "methodSignature"	:
						$v["MethodName"] = new xmlrpcval($arguments[0], "string");
						
				case "serverInfo"	: break;
						
			} // switch
		}
		elseif ($this->prefix =="samurai.") {
			throw new sipgateAPI_Exception("Not yet supported, use old method name with underscore");
			
			switch ($method) {
				
			} // switch
				
		};
		
		$val = new xmlrpcval();
		$val->addStruct( $v );
		$values[] = $val;

		// create message
		$m = new xmlrpcmsg($this->prefix . $method , $values);
  
		// send message		
		$r = $this->client->send($m);

  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			//echo "<pre>";print_r($php_r);echo "</pre>";
  			return $php_r;
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}








	
} // class sipgateAPI

/**
 * this class is NOT WORKING at the moment
 * 
 * 
 */
class XMLRPC_system Extends sipgateAPI_XMLRPC
{
	public function __construct($username = NULL, $password = NULL, $debug = NULL) 
	{
		parent::__construct($username = NULL, $password = NULL, $debug = NULL);	
	}
	
	/**
	 * implements ALL server methods
	 * 
	 * @param mixed $params please refer to documentation, params must be in same order, set optional parameter = NULL
	 * 
	 * @return array
	 */
	function __call($method, $arguments)
	{
		echo "<pre>";
		print_r($method);echo "<br />";
		print_r($arguments);
		echo "</pre>";
		
		$v = array();
		
		switch ($method) {
			
			
			case "listMethods" 	: break;
			
			case "methodHelp"	:
					$v["MethodName"] = new xmlrpcval($arguments[0], "string");
					
			case "methodSignature"	:
					$v["MethodName"] = new xmlrpcval($arguments[0], "string");
					
			case "serverInfo"	: break;
					
		};
		
		$val = new xmlrpcval();
		$val->addStruct( $v );
		$values[] = $val;

		// create message
		$m = new xmlrpcmsg("system." . $method , $values);
  
		// send message		
		$r = $this->client->send($m);

  		if (!$r->faultCode()) {
  			$php_r = php_xmlrpc_decode($r->value());
  			//echo "<pre>";print_r($php_r);echo "</pre>";
  			return $php_r;
  		}
  		else {
  			throw new sipgateAPI_Server_Exception($r->faultString(), $r->faultCode());
  		}
	}
}

?>