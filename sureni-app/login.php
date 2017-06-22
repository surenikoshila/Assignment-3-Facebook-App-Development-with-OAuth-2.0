<?php
if (!session_id()) {
    session_start();
}
ini_set('display_errors', 1);
error_reporting(~0);
// Include the autoloader provided in the SDK
require_once __DIR__ . '/vendor/facebook/graph-sdk/src/Facebook/autoload.php'; 
$fb = new Facebook\Facebook([
  'app_id' => '108571173096588', // Replace {app-id} with your app id
  'app_secret' => '9c1b9b1ffc00e8e7884133f1b5f06121',// Replace {app_secret} with your app id
  'default_graph_version' => 'v2.2',
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ["email","user_posts","publish_actions","user_posts"]; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost/sureni-app/callback.php', $permissions);
echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>



