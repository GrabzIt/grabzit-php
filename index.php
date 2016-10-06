<?php
include("lib/GrabzItClient.class.php");
include("config.php");

$message = '';

if (count($_POST) > 0)
{
	if (isset($_POST["delete"]) && $_POST["delete"] == 1)
	{
		$files = glob('results/*');
		foreach($files as $file)
		{
			if(is_file($file))
				unlink($file);
		}
	}
	else
	{
		$url = $_POST["url"];
		$html = $_POST["html"];
		$format = $_POST["format"];
		$convert = $_POST["convert"];
		
		try
		{
			$grabzIt = new GrabzItClient($grabzItApplicationKey, $grabzItApplicationSecret);
			if ($format == "pdf")
			{
				if ($convert == 'html')
				{
					$grabzIt->HTMLToPDF($html);
				}
				else
				{
					$grabzIt->URLToPDF($url);
				}
			}
			else if ($format == "gif")
			{
				$grabzIt->URLToAnimation($url);
			}
			else
			{
				if ($convert == 'html')
				{
					$grabzIt->HTMLToImage($html);
				}
				else
				{
					$grabzIt->URLToImage($url);
				}
			}
			$grabzIt->Save($grabzItHandlerUrl);
		}
		catch (Exception $e)
		{
			$message =  $e->getMessage();
		}
	}
}
?>
<html>
<head>
<title>GrabzIt Demo</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="ajax/ui.js"></script>
</head>
<body>
<h1>GrabzIt Demo</h1>
<form method="post" action="index.php" class="inputForms">
<p><span id="spnScreenshot">Enter the HTML or URL you want to convert into a PDF or Image. The resulting capture</span><span class="hidden" id="spnGif">Enter the URL of the online video you want to convert into a animated GIF. The resulting animated GIF</span> should then be saved in the <a href="results/" target="_blank">results directory</a>. It may take a few seconds for it to appear! If nothing is happening check the <a href="http://grabz.it/account/diagnostics" target="_blank">diagnostics panel</a> to see if there is an error.</p>
<?php
if ($grabzItHandlerUrl == "URL OF YOUR handler.php FILE (http://www.example.com/grabzit/handler.php)")
{
        ?><p><span class="error">Please update the $grabzItHandlerUrl variable found in config.php file to match the URL of the handler.php file found in this demo app.</span></p><?php
}
if (!is_writable("results"))
{
    ?><span class="error">The "results" directory is not writeable! This directory needs to be made writeable in order for this demo to work.</span><?php
    return;
}
if (count($_POST) > 0 && !isset($_POST["delete"]))
{
	if (!empty($message))
	{
	    ?><p><span class="error"><?php echo $message; ?></span></p><?php
	}
	else
	{
	    ?><p><span style="color:green;font-weight:bold;">Processing...</span></p><?php
	}
}
?>
<div class="Row" id="divConvert">
<label>Convert </label><select name="convert" onchange="selectConvertChanged(this)">
  <option value="url">URL</option>
  <option value="html">HTML</option>
</select>
</div>
<div id="divHTML" class="Row hidden">
<label>HTML </label><textarea name="html"><html><body><h1>Hello world!</h1></body></html></textarea>
</div>
<div id="divURL" class="Row">
<label>URL </label><input text="input" name="url" placeholder="http://www.example.com"/>
</div>
<div class="Row">
<label>Format </label><select name="format" onchange="selectChanged(this)">
  <option value="jpg">JPG</option>
  <option value="pdf">PDF</option>
  <option value="gif">GIF</option>
</select>
</div>
<input type="submit" value="Grabz It" style="margin-left:12em"></input>
</form>
<form method="post" action="index.php" class="inputForms">
<input type="hidden" name="delete" value="1"></input>
<input type="submit" value="Clear Results"></input>
</form>
    <br />
    <h2>Completed Screenshots</h2>
    <div id="divResults"></div>
</body>
</html>