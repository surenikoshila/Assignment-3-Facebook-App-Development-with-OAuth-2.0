<?php
if(!session_id()) {
    session_start();
}
 
ini_set('display_errors', 1);
error_reporting(~0);
require_once __DIR__ . '/vendor/facebook/graph-sdk/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '108571173096588', // Replace {app-id} with your app id
  'app_secret' => '9c1b9b1ffc00e8e7884133f1b5f06121',
  'default_graph_version' => 'v2.2',
  ]);
$helper = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state']=$_GET['state'];
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}
 
$_SESSION['fb_access_token'] = (string) $accessToken;
 try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('me?fields=id,name', $accessToken->getValue());
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
 
 $object = $response->getGraphObject();
 echo "id ".$object->getProperty('id');
	echo '<br>';
 echo "name ".$object->getProperty('name');

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->post('/me/feed',array('message' => 'hello '.$object->getProperty('name')), $accessToken->getValue());
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
?>
