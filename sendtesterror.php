<?php
echo '<!DOCTYPE html>
	<html>
	<head>
	<title>Raygun4WP test error</title>
	</head>
	<body>';

if ($_GET['rg4wp_status'] && function_exists('curl_version') && $_GET['rg4wp_apikey']) {
  require_once dirname(__FILE__).'/external/raygun4php/src/Raygun4php/RaygunClient.php';
  $client = new Raygun4php\RaygunClient($_GET['rg4wp_apikey'], false, true);

  if ($_GET['rg4wp_usertracking']) {
    $client->SetUser($_GET['user']);
  }

  $result = trim($client->SendError(404, 'Congratulations, Raygun4WP is working correctly!', '0', '0'));
  if ($result == 'HTTP/1.1 403 Forbidden') {
  	echo 'The Raygun service did not accept your API key, please enter there is a valid API key in the field for an application you have created, then hit \'Save Changes.\'';
  }
	else if ($result == 'HTTP/1.1 202 Accepted') {
		echo 'Raygun appears to have accepted the test issue, now check your <a href="http://app.raygun.com" target="_blank">dashboard</a>!';
	} else {
  	echo 'Woops, the errors status was not reported. Check your <a href="http://app.raygun.com" target="_blank">dashboard</a> to see if your error has been reported. If the error doesn\'t appear make sure you have entered a valid API key for an application you have created then try again.';
	}
} else {
	echo 'Something is missing! Please check that you have enabled PHP error tracking, the API key is pasted in and you have saved the settings.';
}

echo '<br /><a href="javascript:window.history.back();">Back</a></body></html>';
?>
