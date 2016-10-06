<?php
include_once("GrabzItCookie.class.php");
include_once("GrabzItStatus.class.php");
include_once("GrabzItRequest.class.php");
include_once("GrabzItPDFOptions.class.php");
include_once("GrabzItImageOptions.class.php");
include_once("GrabzItAnimationOptions.class.php");
include_once("GrabzItTableOptions.class.php");
include_once("GrabzItWaterMark.class.php");
include_once("GrabzItException.class.php");

class GrabzItClient
{
    const WebServicesBaseURL_GET = "http://api.grabz.it/services/";
	const WebServicesBaseURL_POST = "http://grabz.it/services/";
	const TakePicture = "takepicture.ashx";
	const TakeTable = "taketable.ashx";
	const TakePDF = "takepdf.ashx";
	const TrueString = "True";

	private $applicationKey;
	private $applicationSecret;
	private $request;
	private $connectionTimeout = 600;

	public function __construct($applicationKey, $applicationSecret)
	{
		$this->applicationKey = $applicationKey;
		$this->applicationSecret = $applicationSecret;
	}

	public function SetTimeout($timeout)
	{
		$this->connectionTimeout = $timeout;
	}

	public function SetApplicationKey($applicationKey)
	{
		$this->applicationKey = $applicationKey;
	}

	public function GetApplicationKey()
	{
		return $this->applicationKey;
	}

	public function SetApplicationSecret($applicationSecret)
	{
		$this->applicationSecret = $applicationSecret;
	}

	public function GetApplicationSecret()
	{
		return $this->applicationSecret;
	}

	/*
	This method specifies the URL of the online video that should be converted into a animated GIF.

	url - The URL to convert into a animated GIF.
	options - A instance of the GrabzItAnimationOptions class that defines any special options to use when creating the animated GIF.
	*/
	public function URLToAnimation($url, $options = null)
	{
		if ($options == null)
		{
			$options = new GrabzItAnimationOptions();			
		}		

		$this->request = new GrabzItRequest(GrabzItClient::WebServicesBaseURL_GET . "takeanimation.ashx", false, $options, $url);
	}

	/*
	This method specifies the URL that should be converted into a image screenshot.

	url - The URL to capture as a screenshot.
	options - A instance of the GrabzItImageOptions class that defines any special options to use when creating the screenshot.
	*/
	public function URLToImage($url, $options = null)
	{
		if ($options == null)
		{
			$options = new GrabzItImageOptions();			
		}		

		$this->request = new GrabzItRequest(GrabzItClient::WebServicesBaseURL_GET . GrabzItClient::TakePicture, false, $options, $url);
	}

	/*
	This method specifies the HTML that should be converted into a image.

	html - The HTML to convert into a image.
	options - A instance of the GrabzItPDFOptions class that defines any special options to use when creating the image.
	*/	
	public function HTMLToImage($html, $options = null)
	{
		if ($options == null)
		{
			$options = new GrabzItImageOptions();			
		}		

		$this->request = new GrabzItRequest(GrabzItClient::WebServicesBaseURL_POST . GrabzItClient::TakePicture, true, $options, $html);
	}

	/*
	This method specifies a HTML file that should be converted into a image.

	path - The file path of a HTML file to convert into a image.
	options - A instance of the GrabzItPDFOptions class that defines any special options to use when creating the image.
	*/		
	public function FileToImage($path, $options = null)
	{
		if (!file_exists($path))
		{
			throw new GrabzItException("File: " . $path . " does not exist", GrabzItException::FILE_NON_EXISTANT_PATH);
		}
		
		$this->HTMLToImage(file_get_contents($path), $options);
	}	

	/*
	This method specifies the URL that the HTML tables should be extracted from.

	url - The URL to extract HTML tables from.
	options - A instance of the GrabzItTableOptions class that defines any special options to use when converting the HTML table.	
	*/
	public function URLToTable($url, $options = null)
	{
		if ($options == null)
		{
			$options = new GrabzItTableOptions();			
		}		

		$this->request = new GrabzItRequest(GrabzItClient::WebServicesBaseURL_GET . GrabzItClient::TakeTable, false, $options, $url);
	}
	
	/*
	This method specifies the HTML that the HTML tables should be extracted from.

	html - The HTML to extract HTML tables from.
	options - A instance of the GrabzItTableOptions class that defines any special options to use when converting the HTML table.	
	*/
	public function HTMLToTable($html, $options = null)
	{
		if ($options == null)
		{
			$options = new GrabzItTableOptions();			
		}		

		$this->request = new GrabzItRequest(GrabzItClient::WebServicesBaseURL_POST . GrabzItClient::TakeTable, true, $options, $html);
	}	
	
	/*
	This method specifies a HTML file that the HTML tables should be extracted from.

	path - The file path of a HTML file to extract HTML tables from.
	options - A instance of the GrabzItTableOptions class that defines any special options to use when converting the HTML table.
	*/	
	public function FileToTable($path, $options = null)
	{
		if (!file_exists($path))
		{
			throw new GrabzItException("File: " . $path . " does not exist", GrabzItException::FILE_NON_EXISTANT_PATH);
		}
		
		$this->HTMLToTable(file_get_contents($path), $options);
	}	

	/*
	This method specifies the URL that should be converted into a PDF.

	url - The URL to capture as a PDF.
	options - A instance of the GrabzItPDFOptions class that defines any special options to use when creating the PDF.
	*/
	public function URLToPDF($url, $options = null)
	{
		if ($options == null)
		{
			$options = new GrabzItPDFOptions();			
		}		

		$this->request = new GrabzItRequest(GrabzItClient::WebServicesBaseURL_GET . GrabzItClient::TakePDF, false, $options, $url);
	}

	/*
	This method specifies the HTML that should be converted into a PDF.

	html - The HTML to convert into a PDF.
	options - A instance of the GrabzItPDFOptions class that defines any special options to use when creating the PDF.
	*/	
	public function HTMLToPDF($html, $options = null)
	{
		if ($options == null)
		{
			$options = new GrabzItPDFOptions();			
		}

		$this->request = new GrabzItRequest(GrabzItClient::WebServicesBaseURL_POST . GrabzItClient::TakePDF, true, $options, $html);
	}

	/*
	This method specifies a HTML file that should be converted into a PDF.

	path - The file path of a HTML file to convert into a PDF.
	options - A instance of the GrabzItPDFOptions class that defines any special options to use when creating the PDF.
	*/	
	public function FileToPDF($path, $options = null)
	{
		if (!file_exists($path))
		{
			throw new GrabzItException("File: " . $path . " does not exist", GrabzItException::FILE_NON_EXISTANT_PATH);
		}
		
		$this->HTMLToPDF(file_get_contents($path), $options);
	}	

	/*
	This function attempts to Save the result asynchronously and returns a unique identifier, which can be used to get the screenshot with the GetResult method.

	This is the recommended method of saving a file.
	*/
	public function Save($callBackURL = null)
	{
		if (empty($this->signaturePartOne) && empty($this->signaturePartTwo) && $this->request == null)
		{
			throw new GrabzItException("No screenshot parameters have been set.", GrabzItException::PARAMETER_MISSING_PARAMETERS);
		}

		$sig =  $this->encode($this->request->getOptions()->_getSignatureString($this->applicationSecret, $callBackURL, $this->request->getTargetUrl()));

		$obj = null;
		if (!$this->request->isPost())
		{
			$obj = $this->getResultObject($this->Get($this->request->getUrl().'?'.http_build_query($this->request->getOptions()->_getParameters($this->applicationKey, $sig, $callBackURL, 'url', $this->request->getData()))));
		}
		else
		{
			$obj = $this->getResultObject($this->Post($this->request->getUrl(), $this->request->getOptions()->_getParameters($this->applicationKey, $sig, $callBackURL, 'html', $this->request->getData())));
		}

		return $obj->ID;
	}

	/*
	Calls the GrabzIt web service to take the screenshot and saves it to the target path provided. if no target path is provided
	it returns the screenshot byte data.

	WARNING this method is synchronous so will cause a application to pause while the result is processed.

	This function returns the true if it is successful saved to a file, or if it is not saving to a file byte data is returned,
	otherwise the method throws an exception.
	*/
	public function SaveTo($saveToFile = '')
	{
		$id = $this->Save();

		if (empty($id))
		{
			return false;
		}

		//Wait for screenshot to be possibly ready
		usleep((3000 + $this->request->getOptions()->_getStartDelay()) * 1000);

		//Wait for it to be ready.
		while(true)
		{
			$status = $this->GetStatus($id);

			if (!$status->Cached && !$status->Processing)
			{
				throw new GrabzItException("The screenshot did not complete with the error: " . $status->Message, GrabzItException::RENDERING_ERROR);
				break;
			}
			else if ($status->Cached)
			{
				$result = $this->GetResult($id);
				if (!$result)
				{
					throw new GrabzItException("The screenshot could not be found on GrabzIt.", GrabzItException::RENDERING_MISSING_SCREENSHOT);
					break;
				}

				if (empty($saveToFile))
				{
					return $result;
				}

				file_put_contents($saveToFile, $result);
				break;
			}

			sleep(3);
		}

		return true;
	}

	/*
	Get the current status of a GrabzIt screenshot

	id - The id of the screenshot

	This function returns a Status object representing the screenshot
	*/
	public function GetStatus($id)
	{
		if (empty($id))
		{
			return null;
		}

		$result = $this->Get(GrabzItClient::WebServicesBaseURL_GET . "getstatus.ashx?id=" . $id);

		$obj = simplexml_load_string($result);

		$status = new GrabzItStatus();
		$status->Processing = ((string)$obj->Processing == GrabzItClient::TrueString);
		$status->Cached = ((string)$obj->Cached == GrabzItClient::TrueString);
		$status->Expired = ((string)$obj->Expired == GrabzItClient::TrueString);
		$status->Message = (string)$obj->Message;

		return $status;
	}

	/*
	This method returns the screenshot itself. If nothing is returned then something has gone wrong or the screenshot is not ready yet.

	id - The unique identifier of the screenshot, returned by the callback handler or the Save method

	This function returns the screenshot
	*/
	public function GetResult($id)
	{
		if (empty($id))
		{
			return null;
		}

		$result = $this->Get(GrabzItClient::WebServicesBaseURL_GET . "getfile.ashx?id=" . $id);

		if (empty($result))
		{
			return null;
		}

		return $result;
	}

	/*
	Get all the cookies that GrabzIt is using for a particular domain. This may include your user set cookies as well.

	domain - The domain to return cookies for.

	This function returns an array of cookies
	*/
	public function GetCookies($domain)
	{
		$sig =  $this->encode($this->applicationSecret."|".$domain);

		$qs = "key=" .urlencode($this->applicationKey)."&domain=".urlencode($domain)."&sig=".$sig;

		$obj = $this->getResultObject($this->Get(GrabzItClient::WebServicesBaseURL_GET . "getcookies.ashx?" . $qs));

		$result = array();

		foreach ($obj->Cookies->Cookie as $cookie)
		{
			$grabzItCookie = new GrabzItCookie();
			$grabzItCookie->Name = (string)$cookie->Name;
			$grabzItCookie->Value = (string)$cookie->Value;
			$grabzItCookie->Domain = (string)$cookie->Domain;
			$grabzItCookie->Path = (string)$cookie->Path;
			$grabzItCookie->HttpOnly = ((string)$cookie->HttpOnly == GrabzItClient::TrueString);
			$grabzItCookie->Expires = (string)$cookie->Expires;
			$grabzItCookie->Type = (string)$cookie->Type;

			$result[] = $grabzItCookie;
		}

		return $result;
	}

	/*
	Sets a new custom cookie on GrabzIt, if the custom cookie has the same name and domain as a global cookie the global
	cookie is overridden.

	This can be useful if a websites functionality is controlled by cookies.

	name - The name of the cookie to set.
	domain - The domain of the website to set the cookie for.
	value - The value of the cookie.
	path - The website path the cookie relates to.
	httponly - Is the cookie only used on HTTP
	expires - When the cookie expires. Pass a null value if it does not expire.

	This function returns true if the cookie was successfully set.
	*/
	public function SetCookie($name, $domain, $value = "", $path = "/", $httponly = false, $expires = "")
	{
		$sig =  $this->encode($this->applicationSecret."|".$name."|".$domain."|".$value."|".$path."|".((int)$httponly)."|".$expires."|0");

		$qs = "key=" .urlencode($this->applicationKey)."&domain=".urlencode($domain)."&name=".urlencode($name)."&value=".urlencode($value)."&path=".urlencode($path)."&httponly=".intval($httponly)."&expires=".urlencode($expires)."&sig=".$sig;

		return $this->isSuccessful($this->Get(GrabzItClient::WebServicesBaseURL_GET . "setcookie.ashx?" . $qs));
	}

	/*
	Delete a custom cookie or block a global cookie from being used.

	name - The name of the cookie to delete
	domain - The website the cookie belongs to

	This function returns true if the cookie was successfully set.
	*/
	public function DeleteCookie($name, $domain)
	{
		$sig =  $this->encode($this->applicationSecret."|".$name."|".$domain."|1");

		$qs = "key=" .urlencode($this->applicationKey)."&domain=".urlencode($domain)."&name=".urlencode($name)."&delete=1&sig=".$sig;

		return $this->isSuccessful($this->Get(GrabzItClient::WebServicesBaseURL_GET . "setcookie.ashx?" . $qs));
	}

	/*
	Add a new custom watermark.

	identifier - The identifier you want to give the custom watermark. It is important that this identifier is unique.
	path - The absolute path of the watermark on your server. For instance C:/watermark/1.png
	xpos - The horizontal position you want the screenshot to appear at: Left = 0, Center = 1, Right = 2
	ypos - The vertical position you want the screenshot to appear at: Top = 0, Middle = 1, Bottom = 2

	This function returns true if the watermark was successfully set.
	*/
	public function AddWaterMark($identifier, $path, $xpos, $ypos)
	{
		if (!file_exists($path))
		{
			throw new GrabzItException("File: " . $path . " does not exist", GrabzItException::FILE_NON_EXISTANT_PATH);
		}
		$sig =  $this->encode($this->applicationSecret."|".$identifier."|".((int)$xpos)."|".((int)$ypos));

		$boundary = '--------------------------'.microtime(true);

		$content =  "--".$boundary."\r\n".
				"Content-Disposition: form-data; name=\"watermark\"; filename=\"".basename($path)."\"\r\n".
				"Content-Type: image/jpeg\r\n\r\n".
				file_get_contents($path)."\r\n";

		$content .= "--".$boundary."\r\n".
				"Content-Disposition: form-data; name=\"key\"\r\n\r\n".
				urlencode($this->applicationKey) . "\r\n";

		$content .= "--".$boundary."\r\n".
				"Content-Disposition: form-data; name=\"identifier\"\r\n\r\n".
				urlencode($identifier) . "\r\n";

		$content .= "--".$boundary."\r\n".
				"Content-Disposition: form-data; name=\"xpos\"\r\n\r\n".
				intval($xpos) . "\r\n";

		$content .= "--".$boundary."\r\n".
				"Content-Disposition: form-data; name=\"ypos\"\r\n\r\n".
				intval($ypos) . "\r\n";

		$content .= "--".$boundary."\r\n".
				"Content-Disposition: form-data; name=\"sig\"\r\n\r\n".
				$sig. "\r\n";

		$content .= "--".$boundary."--\r\n";

		$opts = array('http' =>
			array(
			'method'  => 'POST',
			'header'  => 'Content-Type: multipart/form-data; boundary='.$boundary,
			'content' => $content
			)
		);

		$context  = stream_context_create($opts);

		$response = @file_get_contents('http://grabz.it/services/addwatermark.ashx', false, $context);

		if (isset($http_response_header))
		{
			$this->checkResponseHeader($http_response_header);
		}

		return $this->isSuccessful($response);
	}

	/*
	Delete a custom watermark.

	identifier - The identifier of the custom watermark you want to delete

	This function returns true if the watermark was successfully deleted.
	*/
	public function DeleteWaterMark($identifier)
	{
		$sig = $this->encode($this->applicationSecret."|".$identifier);

		$qs = "key=" .urlencode($this->applicationKey)."&identifier=".urlencode($identifier)."&sig=".$sig;

		return $this->isSuccessful($this->Get(GrabzItClient::WebServicesBaseURL_GET . "deletewatermark.ashx?" . $qs));
	}

	/*
	Get a particular custom watermark.

    identifier - The identifier of a particular custom watermark you want to view

    This function returns a GrabzItWaterMark
    */
	public function GetWaterMark($identifier)
	{
		$watermarks = $this->_getWaterMarks($identifier);

		if (!empty($watermarks) && count($watermarks) == 1)
		{
			return $watermarks[0];
		}

		return null;
	}

	/*
	Get your custom watermarks.

	This function returns an array of GrabzItWaterMark
	*/
	public function GetWaterMarks()
	{
		return $this->_getWaterMarks();
	}

	private function _getWaterMarks($identifier = null)
	{
		$sig =  $this->encode($this->applicationSecret."|".$identifier );

		$qs = "key=" .urlencode($this->applicationKey)."&identifier=".urlencode($identifier)."&sig=".$sig;

		$obj = $this->getResultObject($this->Get(GrabzItClient::WebServicesBaseURL_GET . "getwatermarks.ashx?" . $qs));

		$result = array();

		foreach ($obj->WaterMarks->WaterMark as $waterMark)
		{
			$grabzItWaterMark = new GrabzItWaterMark();
			$grabzItWaterMark->Identifier = (string)$waterMark->Identifier;
			$grabzItWaterMark->XPosition = (string)$waterMark->XPosition;
			$grabzItWaterMark->YPosition = (string)$waterMark->YPosition;
			$grabzItWaterMark->Format = (string)$waterMark->Format;

			$result[] = $grabzItWaterMark;
		}

		return $result;
	}

	private function isSuccessful($result)
	{
		$obj = $this->getResultObject($result);
		return ((string)$obj->Result == GrabzItClient::TrueString);
	}

	private function getResultObject($result)
	{
		$obj = simplexml_load_string($result);

		if (!empty($obj->Message))
		{
			throw new GrabzItException($obj->Message, $obj->Code);
		}

		return $obj;
	}

	private function encode($text)
	{
		return md5(mb_convert_encoding($text, "ASCII", mb_detect_encoding($text)));
	}

	private function Post($url, $parameters)
	{
		if (ini_get('allow_url_fopen'))
		{
			$options = array(
				'http' => array(
					'timeout' => $this->connectionTimeout,
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'method'  => 'POST',
					'content' => http_build_query($parameters)
				)
			);

			$context  = stream_context_create($options);
			$response = @file_get_contents($url, false, $context);

			if (isset($http_response_header))
			{
				$this->checkResponseHeader($http_response_header);
			}

			return $response;
		}
		
		if (function_exists('curl_version'))
		{
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($parameters));
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$this->connectionTimeout);
			curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($parameters));

			//execute post
			$data = curl_exec($ch);

			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			$this->checkHttpCode($httpCode);

			//close connection
			curl_close($ch);

			return $data;
		}
		
		throw new GrabzItException("Unable to contact GrabzIt's servers. Please install the CURL extension or set allow_url_fopen to 1 in the php.ini file.", GrabzItException::GENERIC_ERROR);
	}

	private function Get($url)
	{
		if (ini_get('allow_url_fopen'))
		{
			$timeout = array('http' => array('timeout' => $this->connectionTimeout));
			$context = stream_context_create($timeout);
			$response = @file_get_contents($url, false, $context);

			if (isset($http_response_header))
			{
				$this->checkResponseHeader($http_response_header);
			}

			return $response;
		}

		if (function_exists('curl_version'))
		{
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$this->connectionTimeout);
			$data = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			$this->checkHttpCode($httpCode);

			curl_close($ch);

			return $data;
		}

		throw new GrabzItException("Unable to contact GrabzIt's servers. Please install the CURL extension or set allow_url_fopen to 1 in the php.ini file.", GrabzItException::GENERIC_ERROR);
	}

	private function checkHttpCode($httpCode)
	{
	    if ($httpCode == 403)
	    {
			throw new GrabzItException('Potential DDOS Attack Detected. Please wait for your service to resume shortly. Also please slow the rate of requests you are sending to GrabzIt to ensure this does not happen in the future.', GrabzItException::NETWORK_DDOS_ATTACK);
	    }
	    else if ($httpCode >= 400)
	    {
			throw new GrabzItException("A network error occured when connecting to the GrabzIt servers.", GrabzItException::NETWORK_GENERAL_ERROR);
	    }
	}

	private function checkResponseHeader($header)
	{
	    list($version,$httpCode,$msg) = explode(' ',$header[0], 3);
		$this->checkHttpCode($httpCode);
	}
}
?>
