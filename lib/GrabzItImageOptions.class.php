<?php
include_once("GrabzItBaseOptions.class.php");

class GrabzItImageOptions extends GrabzItBaseOptions
{	
	private $requestAs = 0;
	private $customWaterMarkId = null;
	private $quality = -1;	
	private $browserWidth = null;
	private $browserHeight = null;
	private $width = null;
	private $height = null;
	private $format = null;
	private $targetElement = null;	

	/*
	Set the width of the browser in pixels.
	*/
	public function setBrowserWidth($value)
	{
		$this->browserWidth = $value;
	}

	/*
	Get the width of the browser in pixels.
	*/
	public function getBrowserWidth()
	{
		return $this->browserWidth;
	}	

	/*
	Set the height of the browser in pixels. Use -1 to sceenshot  the whole web page.
	*/
	public function setBrowserHeight($value)
	{
		$this->browserHeight = $value;
	}

	/*
	Get the height of the browser in pixels.
	*/
	public function getBrowserHeight()
	{
		return $this->browserHeight;
	}	

	/*
	Set the width of the resulting screenshot in pixels. Use -1 to not reduce the width of the screenshot.
	*/
	public function setWidth($value)
	{
		$this->width = $value;
	}

	/*
	Get the width of the resulting screenshot in pixels.
	*/
	public function getWidth()
	{
		return $this->width;
	}

	/*
	Set the height of the resulting screenshot in pixels. Use -1 to not reduce the height of the screenshot.
	*/
	public function setHeight($value)
	{
		$this->height = $value;
	}

	/*
	Get the height of the resulting screenshot in pixels.
	*/
	public function getHeight()
	{
		return $this->height;
	}	

	/*
	Set the format the screenshot should be in: bmp8, bmp16, bmp24, bmp, tiff, jpg, png.
	*/
	public function setFormat($value)
	{
		$this->format = $value;
	}

	/*
	Get the format of the screenshot image.
	*/
	public function getFormat()
	{
		return $this->format;
	}

	/*
	Set the id of the only HTML element in the web page to turn into a screenshot.
	*/
	public function setTargetElement($value)
	{
		$this->targetElement = $value;
	}

	/*
	Get the id of the only HTML element in the web page to turn into a screenshot.
	*/
	public function getTargetElement()
	{
		return $this->targetElement;
	}
	
	/*
	Set the number of milliseconds to wait before creating the capture.
	*/
	public function setDelay($value)
	{
		$this->delay = $value;
	}

	/*
	Get the number of milliseconds to wait before creating the capture.
	*/
	public function getDelay()
	{
		return $this->delay;
	}	
	
	/*
	Set which user agent type should be used: Standard Browser = 0, Mobile Browser = 1, Search Engine = 2 and Fallback Browser = 3.
	*/
	public function setRequestAs($value)
	{
		$this->requestAs = $value;
	}

	/*
	Get which user agent type should be used.
	*/
	public function getRequestAs()
	{
		return $this->requestAs;
	}

	/*
	Set a custom watermark to add to the screenshot.
	*/
	public function setCustomWaterMarkId($value)
	{
		$this->customWaterMarkId = $value;
	}

	/*
	Get the custom watermark id.
	*/
	public function getCustomWaterMarkId()
	{
		return $this->customWaterMarkId;
	}

	/*
	Set the quality of the screenshot where 0 is poor and 100 excellent. The default is -1 which uses the recommended quality.
	*/
	public function setQuality($value)
	{
		$this->quality = $value;
	}

	/*
	Get the quality of the screenshot.
	*/
	public function getQuality()
	{
		return $this->quality;
	}

	public function _getSignatureString($applicationSecret, $callBackURL, $url = null)
	{
		$urlParam = '';
		if ($url != null)
		{
			$urlParam = $this->nullToEmpty($url)."|";
		}		
		
		$callBackURLParam = '';
		if ($callBackURL != null)
		{
			$callBackURLParam = $this->nullToEmpty($callBackURL);
		}				
		
		return $this->nullToEmpty($applicationSecret)."|". $urlParam . $callBackURLParam .
		"|".$this->nullToEmpty($this->format)."|".$this->nullToEmpty($this->height)."|".$this->nullToEmpty($this->width)."|".$this->nullToEmpty($this->browserHeight)
		."|".$this->nullToEmpty($this->browserWidth)."|".$this->nullToEmpty($this->getCustomId())."|".$this->nullToEmpty($this->delay)."|".$this->nullToEmpty($this->targetElement)
		."|".$this->nullToEmpty($this->customWaterMarkId)."|".$this->nullToEmpty(intval($this->requestAs))."|".$this->nullToEmpty($this->getCountry())."|".
		$this->nullToEmpty($this->quality);	  
	}
	
	public function _getParameters($applicationKey, $sig, $callBackURL, $dataName, $dataValue)
	{
		$params = $this->createParameters($applicationKey, $sig, $callBackURL, $dataName, $dataValue);		
		$params['width'] = $this->nullToEmpty($this->width);
		$params['height'] = $this->nullToEmpty($this->height);
		$params['format'] = $this->nullToEmpty($this->format);
		$params['bwidth'] = $this->nullToEmpty($this->browserWidth);
		$params['customwatermarkid'] = $this->nullToEmpty($this->customWaterMarkId);
		$params['bheight'] = $this->nullToEmpty($this->browserHeight);
		$params['delay'] = $this->nullToEmpty($this->delay);
		$params['target'] = $this->nullToEmpty($this->targetElement);
		$params['delay'] = $this->nullToEmpty($this->delay);
		$params['requestmobileversion'] = $this->nullToEmpty(intval($this->requestAs));		
		$params['quality'] = $this->nullToEmpty($this->quality);			
		
		return $params;
	}
}
?>