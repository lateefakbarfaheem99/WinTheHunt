<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class xmlparser
{

	function GetChildren($vals, &$i)
	{
		$children = array();


		if (isset($vals[$i]['value']))
		$children['VALUE'] = $vals[$i]['value'];


		while (++$i < count($vals))
		{
			switch ($vals[$i]['type'])
			{
				case 'cdata':
					if (isset($children['VALUE']))
					$children['VALUE'] .= $vals[$i]['value'];
					else
					$children['VALUE'] = $vals[$i]['value'];
					break;

				case 'complete':
					if (isset($vals[$i]['attributes'])) {
						$children[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes'];
						$index = count($children[$vals[$i]['tag']])-1;

						if (isset($vals[$i]['value']))
						$children[$vals[$i]['tag']][$index]['VALUE'] = $vals[$i]['value'];
						else
						$children[$vals[$i]['tag']][$index]['VALUE'] = '';
					} else {
						if (isset($vals[$i]['value']))
						$children[$vals[$i]['tag']][]['VALUE'] = $vals[$i]['value'];
						else
						$children[$vals[$i]['tag']][]['VALUE'] = '';
					}
					break;

				case 'open':
					if (isset($vals[$i]['attributes'])) {
						$children[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes'];
						$index = count($children[$vals[$i]['tag']])-1;
						$children[$vals[$i]['tag']][$index] = array_merge($children[$vals[$i]['tag']][$index],$this->GetChildren($vals, $i));
					} else {
						$children[$vals[$i]['tag']][] = $this->GetChildren($vals, $i);
					}
					break;

				case 'close':
					return $children;
			}
		}
	}

	function GetXMLTree($xml)
	{
		$data = $xml;

		$parser = xml_parser_create();
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, $data, $vals, $index);
		xml_parser_free($parser);

		//print_r($index);

		$tree = array();
		$i = 0;

		if (isset($vals[$i]['attributes'])) {
			$tree[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes'];
			$index = count($tree[$vals[$i]['tag']])-1;
			$tree[$vals[$i]['tag']][$index] =    array_merge($tree[$vals[$i]['tag']][$index], $this->GetChildren($vals, $i));
		}
		else
		$tree[$vals[$i]['tag']][] = $this->GetChildren($vals, $i);

		return $tree;
	}

	function printa($obj) {
		global $__level_deep;
		if (!isset($__level_deep)) $__level_deep = array();

		if (is_object($obj))
		print '[obj]';
		elseif (is_array($obj)) {
			foreach(array_keys($obj) as $keys) {
				array_push($__level_deep, "[".$keys."]");
				$this->printa($obj[$keys]);
				array_pop($__level_deep);
			}
		}
		else print implode(" ",$__level_deep)." = $obj\n";
	}
}

class USPS {

	var $server = "";
	var $user = "";
	var $pass = "";
	var $service = "";
	var $dest_zip;
	var $orig_zip;
	var $pounds;
	var $ounces;
	var $container = "None";
	var $size = "REGULAR";
	var $machinable;
	var $country = "US";

	function setServer($server) {
		$this->server = $server;
	}

	function setUserName($user) {
		$this->user = $user;
	}

	function setPass($pass) {
		$this->pass = $pass;
	}

	function setService($service) {
		/* Must be: Express, Priority, or Parcel */
		$this->service = $service;
	}

	function setDestZip($sending_zip) {
		/* Must be 5 digit zip (No extension) */
		$this->dest_zip = $sending_zip;
	}

	function setOrigZip($orig_zip) {
		$this->orig_zip = $orig_zip;
	}

	function setWeight($pounds, $ounces=0) {
		/* Must weight less than 70 lbs. */
		$this->pounds = $pounds;
		$this->ounces = $ounces;
	}

	function setContainer($cont) {
		$this->container = $cont;
	}

	function setSize($size) {
		$this->size = $size;
	}

	function setMachinable($mach) {
		/* Required for Parcel Post only, set to True or False */
		$this->machinable = $mach;
	}

	function setCountry($country) {
		$this->country = $country;
	}

	function getPrice() {
		if($this->country=="US"){
			// may need to urlencode xml portion
			$str = $this->server. "?API=RateV2&XML=<RateV2Request%20USERID=\"";
			$str .= $this->user . "\"%20PASSWORD=\"" . $this->pass . "\"><Package%20ID=\"0\"><Service>";
			$str .= $this->service . "</Service><ZipOrigination>" . $this->orig_zip . "</ZipOrigination>";
			$str .= "<ZipDestination>" . $this->dest_zip . "</ZipDestination>";
			$str .= "<Pounds>" . $this->pounds . "</Pounds><Ounces>" . $this->ounces . "</Ounces>";
			$str .= "<Container>" . urlencode($this->container) . "</Container><Size>" . $this->size . "</Size>";
			$str .= "<Machinable>" . $this->machinable . "</Machinable></Package></RateV2Request>";
		}
		else {
			$str = $this->server. "?API=IntlRate&XML=<IntlRateRequest%20USERID=\"";
			$str .= $this->user . "\"%20PASSWORD=\"" . $this->pass . "\"><Package%20ID=\"0\">";
			$str .= "<Pounds>" . $this->pounds . "</Pounds><Ounces>" . $this->ounces . "</Ounces>";
			$str .= "<MailType>Package</MailType><Country>".urlencode($this->country)."</Country></Package></IntlRateRequest>";
		}
		
		$ch = curl_init();
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $str);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// grab URL and pass it to the browser
		$ats = curl_exec($ch);

		// close curl resource, and free up system resources
		curl_close($ch);
		$xmlParser = new xmlparser();
		$array = $xmlParser->GetXMLTree($ats);
		//$xmlParser->printa($array);
		if(count($array['ERROR'])) { // If it is error
			$error = new error();
			$error->number = $array['ERROR'][0]['NUMBER'][0]['VALUE'];
			$error->source = $array['ERROR'][0]['SOURCE'][0]['VALUE'];
			$error->description = $array['ERROR'][0]['DESCRIPTION'][0]['VALUE'];
			$error->helpcontext = $array['ERROR'][0]['HELPCONTEXT'][0]['VALUE'];
			$error->helpfile = $array['ERROR'][0]['HELPFILE'][0]['VALUE'];
			$this->error = $error;
		} else if(count($array['RATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'])) {
			$error = new error();
			$error->number = $array['RATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['NUMBER'][0]['VALUE'];
			$error->source = $array['RATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['SOURCE'][0]['VALUE'];
			$error->description = $array['RATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['DESCRIPTION'][0]['VALUE'];
			$error->helpcontext = $array['RATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['HELPCONTEXT'][0]['VALUE'];
			$error->helpfile = $array['RATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['HELPFILE'][0]['VALUE'];
			$this->error = $error;
		} else if(count($array['INTLRATERESPONSE'][0]['PACKAGE'][0]['ERROR'])){ //if it is international shipping error
			$error = new error($array['INTLRATERESPONSE'][0]['PACKAGE'][0]['ERROR']);
			$error->number = $array['INTLRATERESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['NUMBER'][0]['VALUE'];
			$error->source = $array['INTLRATERESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['SOURCE'][0]['VALUE'];
			$error->description = $array['INTLRATERESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['DESCRIPTION'][0]['VALUE'];
			$error->helpcontext = $array['INTLRATERESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['HELPCONTEXT'][0]['VALUE'];
			$error->helpfile = $array['INTLRATERESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['HELPFILE'][0]['VALUE'];
			$this->error = $error;
		} else if(count($array['RATEV2RESPONSE'])){ // if everything OK
			//print_r($array['RATEV2RESPONSE']);
			$this->zone = $array['RATEV2RESPONSE'][0]['PACKAGE'][0]['ZONE'][0]['VALUE'];
			foreach ($array['RATEV2RESPONSE'][0]['PACKAGE'][0]['POSTAGE'] as $value){
				$price = new price();
				$price->mailservice = $value['MAILSERVICE'][0]['VALUE'];
				$price->rate = $value['RATE'][0]['VALUE'];
				$this->list[] = $price;
			}
		} else if (count($array['INTLRATERESPONSE'][0]['PACKAGE'][0]['SERVICE'])) { // if it is international shipping and it is OK
			foreach($array['INTLRATERESPONSE'][0]['PACKAGE'][0]['SERVICE'] as $value) {
				$price = new intPrice();
				$price->id = $value['ATTRIBUTES']['ID'];
				$price->pounds = $value['POUNDS'][0]['VALUE'];
				$price->ounces = $value['OUNCES'][0]['VALUE'];
				$price->mailtype = $value['MAILTYPE'][0]['VALUE'];
				$price->country = $value['COUNTRY'][0]['VALUE'];
				$price->rate = $value['POSTAGE'][0]['VALUE'];
				$price->svccommitments = $value['SVCCOMMITMENTS'][0]['VALUE'];
				$price->svcdescription = $value['SVCDESCRIPTION'][0]['VALUE'];
				$price->maxdimensions = $value['MAXDIMENSIONS'][0]['VALUE'];
				$price->maxweight = $value['MAXWEIGHT'][0]['VALUE'];
				$this->list[] = $price;
			}

		}

		return $this;
	}
}

class error
{
	var $number;
	var $source;
	var $description;
	var $helpcontext;
	var $helpfile;
}

class price
{
	var $mailservice;
	var $rate;
}

class intPrice
{
	var $id;
	var $rate;
}

class Fedex 
{

	// Variables
	var $server = "https://gatewaybeta.fedex.com/GatewayDC";
	var $accountNumber;
	var $meterNumber;
	var $carrierCode = "FDXG";
	var $dropoffType = "REGULARPICKUP";
	var $service;
	var $serviceName;
	var $packaging = "YOURPACKAGING";
	var $weightUnits = "LBS";
	var $weight;
	// Origin Address
	var $originStateOrProvinceCode;
	var $originPostalCode;
	var $originCountryCode;
	// Destination Address
	var $destStateOrProvinceCode;
	var $destPostalCode;
	var $destCountryCode;
	var $payorType = "SENDER";


	// Functions
	function setServer($server) {
		$this->server = $server;
	}

	function setAccountNumber($accountNumber) {
		$this->accountNumber = $accountNumber;
	}

	function setMeterNumber($meterNumber) {
		$this->meterNumber = $meterNumber;
	}

	function setCarrierCode($carrierCode) {
		$this->carrierCode = $carrierCode;
	}

	function setDropoffType($dropoffType) {
		$this->dropoffType = $dropoffType;
	}

	function setService($service, $name) {
		$this->service = $service;
		$this->serviceName = $name;
	}

	function setPackaging($packaging) {
		$this->packaging = $packaging;
	}

	function setWeightUnits($units) {
		$this->weightUnits = $units;
	}

	function setWeight($weight) {
		$this->weight = $weight;
	}

	function setOriginStateOrProvinceCode($code) {
		$this->originStateOrProvinceCode = $code;
	}

	function setOriginPostalCode($code) {
		$this->originPostalCode = $code;
	}

	function setOriginCountryCode($code) {
		$this->originCountryCode = $code;
	}

	function setDestStateOrProvinceCode($code) {
		$this->destStateOrProvinceCode = $code;
	}

	function setDestPostalCode($code) {
		$this->destPostalCode = $code;
	}

	function setDestCountryCode($code) {
		$this->destCountryCode = $code;
	}

	function setPayorType($type) {
		$this->payorType = $type;
	}

	function getPrice() {

		$str = '<?xml version="1.0" encoding="UTF-8" ?>';
		$str .= '    <FDXRateRequest xmlns:api="http://www.fedex.com/fsmapi" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="FDXRateRequest.xsd">';
		$str .= '        <RequestHeader>';
		$str .= '            <CustomerTransactionIdentifier>Express Rate</CustomerTransactionIdentifier>';
		$str .= '            <AccountNumber>'.$this->accountNumber.'</AccountNumber>';
		$str .= '            <MeterNumber>'.$this->meterNumber.'</MeterNumber>';
		$str .= '            <CarrierCode>'.$this->carrierCode.'</CarrierCode>';
		$str .= '        </RequestHeader>';
		$str .= '        <DropoffType>'.$this->dropoffType.'</DropoffType>';
		$str .= '        <Service>'.$this->service.'</Service>';
		$str .= '        <Packaging>'.$this->packaging.'</Packaging>';
		$str .= '        <WeightUnits>'.$this->weightUnits.'</WeightUnits>';
		$str .= '        <Weight>'.number_format($this->weight, 1, '.', '').'</Weight>';
		$str .= '        <OriginAddress>';
		$str .= '            <StateOrProvinceCode>'.$this->originStateOrProvinceCode.'</StateOrProvinceCode>';
		$str .= '            <PostalCode>'.$this->originPostalCode.'</PostalCode>';
		$str .= '            <CountryCode>'.$this->originCountryCode.'</CountryCode>';
		$str .= '        </OriginAddress>';
		$str .= '        <DestinationAddress>';
		$str .= '            <StateOrProvinceCode>'.$this->destStateOrProvinceCode.'</StateOrProvinceCode>';
		$str .= '            <PostalCode>'.$this->destPostalCode.'</PostalCode>';
		$str .= '            <CountryCode>'.$this->destCountryCode.'</CountryCode>';
		$str .= '        </DestinationAddress>';
		$str .= '        <Payment>';
		$str .= '            <PayorType>'.$this->payorType.'</PayorType>';
		$str .= '        </Payment>';
		//$str .= '        <PackageCount>'.ceil(bcdiv(number_format($this->weight, 1, '.', ''), '150', 3)).'</PackageCount>';
		$str .= '        <PackageCount>1</PackageCount>';
		$str .= '    </FDXRateRequest>';
		//print($str);
		$header[] = "Host: " . $_SERVER['HTTP_HOST'];
		$header[] = "MIME-Version: 1.0";
		$header[] = "Content-type: multipart/mixed; boundary=----doc";
		$header[] = "Accept: text/xml";
		$header[] = "Content-length: ".strlen($str);
		$header[] = "Cache-Control: no-cache";
		$header[] = "Connection: close \r\n";
		$header[] = $str;

		$ch = curl_init();
		//Disable certificate check.
		// uncomment the next line if you get curl error 60: error setting certificate verify locations
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// uncommenting the next line is most likely not necessary in case of error 60
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		//-------------------------
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		//curl_setopt($ch, CURLOPT_CAINFO, "c:/ca-bundle.crt");
		//-------------------------
		curl_setopt($ch, CURLOPT_URL,$this->server);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 4);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		$data = curl_exec($ch);
		if (curl_errno($ch)) {
			$this->getPrice();
		} else {
			// close curl resource, and free up system resources
			curl_close($ch);
			$xmlParser = new xmlparser();
			$array = $xmlParser->GetXMLTree($data);
			//$xmlParser->printa($array);
			if(count($array['FDXRATEREPLY'][0]['ERROR'])) { // If it is error
				$error = new fedexError();
				$error->number = $array['FDXRATEREPLY'][0]['ERROR'][0]['CODE'][0]['VALUE'];
				$error->description = $array['FDXRATEREPLY'][0]['ERROR'][0]['MESSAGE'][0]['VALUE'];
				$error->response = $array;
				$this->error = $error;
			} else if (count($array['FDXRATEREPLY'][0]['ESTIMATEDCHARGES'][0]['DISCOUNTEDCHARGES'][0]['NETCHARGE'])) {
				$price = new fedexPrice();
				$price->rate = $array['FDXRATEREPLY'][0]['ESTIMATEDCHARGES'][0]['DISCOUNTEDCHARGES'][0]['NETCHARGE'][0]['VALUE'];
				$price->service = $this->serviceName;
				$price->response = $array;
				$this->price = $price;
			}
			//print_r($this);
			return $this;
		}
	}
}

class fedexError
{
	var $number;
	var $description;
	var $response;
}

class fedexPrice
{
	var $service;
	var $rate;
	var $response;
}

class UPS
{
	var $method;
	var $source_zip;
	var $source_country;
	var $dest_zip;
	var $dest_country;
	var $ups_rate = 'Regular+Daily+Pickup';
	var $container_code = '00'; // customer packaging
	var $weight;
	var $address_type = 'RES'; // enter COM for commercial

	function getPrice()
	{
		$url = join('&',
			array(
				'http://www.ups.com/using/services/rave/qcostcgi.cgi?accept_UPS_license_agreement=yes',
				'10_action=3',
				'13_product=' . $this->method,
				'14_origCountry=' . strtoupper($this->source_country),
				'15_origPostal=' . $this->source_zip,
				'19_destPostal=' . $this->dest_zip,
				'22_destCountry=' . strtoupper($this->dest_country),
				'23_weight=' . $this->weight,
				'47_rateChart=' . $this->ups_rate,
				'48_container=' . $this->container_code,
				'49_residential=' . $this->address_type
			)
		);
		
		$fp = fopen($url, 'r');
		while(!feof($fp))
		{
			$result = fgets($fp, 500);
			$result = explode("%", $result);
			$errcode = substr($result[0], -1);
			switch($errcode){
				case 3:
					$returnval = $result[8];
					break;
				case 4:
					$returnval = $result[8];
					break;
				case 5:
					$returnval = $result[1];
					break;
				case 6:
					$returnval = $result[1];
					break;
			}
		}
		fclose($fp);
		if(! $returnval) { $returnval = "error"; }
		return $returnval;
	}
}

class shipping_methods extends database 
{
	var $fedex;
	var $usps;
	var $ups;
	var $fedexService;
	var $uspsService;
	var $upsService;
	var $setts;
	
	function fedex_methods($international = false)
	{
		if ($international)
		{
			$this->fedexService['INTERNATIONALPRIORITY'] = 'FedEx International Priority';
			$this->fedexService['INTERNATIONALECONOMY']  = 'FedEx International Economy';
		}
		else 
		{
			$this->fedexService['FIRSTOVERNIGHT']        = 'FedEx First Overnight';
			$this->fedexService['PRIORITYOVERNIGHT']     = 'FedEx Priority Overnight';
			$this->fedexService['STANDARDOVERNIGHT']     = 'FedEx Standard Overnight';
			$this->fedexService['FEDEX2DAY']             = 'FedEx 2 Day';
			$this->fedexService['FEDEXEXPRESSSAVER']     = 'FedEx Express Saver';
			$this->fedexService['FEDEXGROUND']           = 'FedEx Ground';
			$this->fedexService['GROUNDHOMEDELIVERY']    = 'FedEx Home Delivery';
		}
	}
	
	function usps_methods($international = false)
	{
		if ($international)	
		{
			$this->uspsService[] = 'Global Express Guaranteed';
			//$this->usps_service[] = 'Global Express Guaranteed Non-Document Rectangular';
			//$this->usps_service[] = 'Global Express Guaranteed Non-Document Non-Rectangular';
			$this->uspsService[] = 'Express Mail International (EMS)';
			//$this->usps_service[] = 'Express Mail International (EMS) Flat Rate Envelope';
			$this->uspsService[] = 'Priority Mail International';
			//$this->usps_service[] = 'Priority Mail International Flat Rate Box';
			//$this->usps_service[] = 'Priority Mail International Flat Rate Envelope';
			$this->uspsService[] = 'First-Class Mail International';
		}
		else 
		{
			$this->uspsService[] = 'Express Mail';
			$this->uspsService[] = 'First-Class Mail';
			$this->uspsService[] = 'Priority Mail';
			$this->uspsService[] = 'Parcel Post';
			//$this->usps_service[] = 'Bound Printed Material';
			//$this->usps_service[] = 'Media Mail';
			//$this->usps_service[] = 'Library Mail';
		}		
	}

	function ups_methods($international = false)
	{
		/*
		1DM - Next Day Air Early AM
		1DA - Next Day Air
		1DP - Next Day Air Saver
		2DM - 2nd Day Air Early AM
		2DA - 2nd Day Air
		3DS - 3 Day Select
		GND - Ground
		STD - Canada Standard
		XPR - Worldwide Express
		XDM - Worldwide Express Plus
		XPD - Worldwide Expedited
		WXS - Worldwide Saver
		*/
		
		if ($international)	
		{
			$this->upsService['XPR'] = 'Worldwide Express';
			//$this->upsService['XDM'] = 'Worldwide Express Plus';
			$this->upsService['XPD'] = 'Worldwide Expedited';
			$this->upsService['WXS'] = 'Worldwide Saver';
		}
		else 
		{
			$this->upsService['1DM'] = 'Next Day Air Early AM';
			$this->upsService['1DA'] = 'Next Day Air';
			$this->upsService['1DP'] = 'Next Day Air Saver';
			$this->upsService['2DM'] = '2nd Day Air Early AM';
			$this->upsService['2DA'] = '2nd Day Air';
			$this->upsService['3DS'] = '3 Day Select';
			$this->upsService['GND'] = 'Ground';
			$this->upsService['STD'] = 'Canada Standard';
		}		
	}
	
	function get_method_code($service_name, $carrier = 'FedEx')
	{
		$output = null;
		
		if ($carrier == 'FedEx')
		{
			$service_array = $this->fedexService;
		}
		else if ($carrier == 'UPS')
		{
			$service_array = $this->upsService;
		}
		
		foreach ($service_array as $key => $value)
		{
			if ($value == $service_name)
			{
				$output = $key;
			}
		}
		
		return $output;
	}
	
	function fedex_service($item_weight, $source_zip, $source_country, $dest_zip, $dest_country, $selected_service = null)
	{
		$carrier_setts = unserialize($this->setts['carrier_setts']);

		$international = ($source_country == $dest_country) ? false : true;
		
		$this->fedex_methods($international);
		
		$item_weight = ($item_weight > 1) ? intval($item_weight) : 1;
		
		$output = array();
		$error_output = array();
		
		if ($selected_service)
		{
			$service_key = $this->get_method_code($selected_service, 'FedEx');
			
			if ($service_key)
			{
				$this->fedexService = null;
				$this->fedexService[$service_key] = $selected_service;
			}
		}
		
		foreach($this->fedexService as $service=>$serviceName)
		{
			$this->fedex = new Fedex();
			
			$this->fedex->setServer("https://gatewaybeta.fedex.com/GatewayDC");
			
			$this->fedex->setAccountNumber($carrier_setts['fedex_account_number']);
			$this->fedex->setMeterNumber($carrier_setts['fedex_meter_number']);
			
			$this->fedex->setCarrierCode("FDXE");
			$this->fedex->setDropoffType("REGULARPICKUP");
			$this->fedex->setService($service, $serviceName);
			$this->fedex->setPackaging("YOURPACKAGING");
			
			$this->fedex->setWeightUnits("LBS");
			$this->fedex->setWeight($item_weight);
			
			$this->fedex->setOriginPostalCode($source_zip);
			$this->fedex->setOriginCountryCode($source_country);
			$this->fedex->setDestPostalCode($dest_zip);
			$this->fedex->setDestCountryCode($dest_country);
			$this->fedex->setPayorType("SENDER");

			$price = $this->fedex->getPrice();
			$shipping_rate = $price->price->rate;

			if ($shipping_rate)
			{
				$output[] = array('carrier' => 'FedEx', 'service_name' => $price->serviceName, 'price' => $shipping_rate, 'currency' => 'USD');
			}
			else 
			{
				$error_output[] = $price->error->description;
			}
		}
		
		return $output;
	}
	
	function usps_country($country_iso_code)
	{
		$country_iso_code = strtoupper($country_iso_code);
		
		switch ($country_iso_code)
		{
			case 'US':
				$output = 'US';
				break;
			case 'GB':
				$output = 'Great Britain';
				break;
			default:
				$output = $this->get_sql_field("SELECT name FROM " . DB_PREFIX . "countries WHERE UPPER(country_iso_code)='" . $country_iso_code . "'", 'name');				
		}
		
		return $output;
	}
	
	function usps_service($item_weight, $source_zip, $dest_zip, $dest_country, $selected_service = null)
	{
		$this->usps = new USPS();
		
		$carrier_setts = unserialize($this->setts['carrier_setts']);
		
		$country = $this->usps_country($dest_country);
		
		$international = ($country == 'US') ? false : true;
		
		$this->usps_methods($international);
		
		$item_weight = ($item_weight > 1) ? intval($item_weight) : 1;
		
		$this->usps->setServer("http://production.shippingapis.com/ShippingAPI.dll");
		$this->usps->setUserName($carrier_setts['usps_username']);
		$this->usps->setService("All");
		$this->usps->setDestZip($dest_zip);
		$this->usps->setOrigZip($source_zip);
		$this->usps->setWeight($item_weight, 0);
		$this->usps->setCountry($country);
		$this->usps->setMachinable("true");
		$price = $this->usps->getPrice();
		
		if (empty($price->error->description) && !empty($price->list))
		{
			foreach ($price->list as $value)
			{
				$service_name = ($country == 'US') ? $value->mailservice : $value->svcdescription;

				if ((!$selected_service || $selected_service == $service_name) && in_array($service_name, $this->uspsService))
				{
					$output[] = array('carrier' => 'USPS', 'service_name' => $service_name, 'price' => $value->rate, 'currency' => 'USD');
				}
			}
		}		
		else 
		{
			$error_output[] = $price->error->description;
		}
		
		return $output;
	}
	
	function ups_service($item_weight, $source_zip, $source_country, $dest_zip, $dest_country, $selected_service = null)
	{
		$carrier_setts = unserialize($this->setts['carrier_setts']);

		$international = ($source_country == $dest_country) ? false : true;
		
		$this->ups_methods($international);
		
		$item_weight = ($item_weight > 1) ? intval($item_weight) : 1;
		
		$output = array();
		$error_output = array();
		
		if ($selected_service)
		{
			$service_key = $this->get_method_code($selected_service, 'UPS');
			
			if ($service_key)
			{
				$this->upsService = null;
				$this->upsService[$service_key] = $selected_service;
			}
		}
		
		foreach($this->upsService as $service=>$serviceName)
		{			
			$this->ups = new UPS();
			$this->ups->method = $service;
			$this->ups->source_zip = $source_zip;
			$this->ups->source_country = $source_country;
			$this->ups->dest_zip = $dest_zip;
			$this->ups->dest_country = $dest_country;
			$this->ups->weight = $item_weight;
			
			$shipping_rate = $this->ups->getPrice();
			$shipping_rate = doubleval($shipping_rate);

			if ($shipping_rate > 0)
			{
				$output[] = array('carrier' => 'UPS', 'service_name' => $serviceName, 'price' => $shipping_rate, 'currency' => 'USD');
			}
			else 
			{
				$error_output[] = 'UPS rate calculator error';
			}
		}
		
		return $output;		
	}
}
?>