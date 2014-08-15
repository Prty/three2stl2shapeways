<?php

require "consumer_key.php";
require "access_token.php";
require "api_url_base.php";
require "error.php";

$id = uniqid();
$stl = $_POST['stl'];



$link = mysql_connect("localhost","root", "7m76zz23pu");
if (!$link) {
    die('failed' . mysql_error());
}else{
$dbname = "3dtweet";
$tblname="3dt";


mysql_select_db($dbname,$link);
mysql_query('SET NAMES utf8', $link );


//$res_up = mysql_query( "DELETE FROM 3dt WHERE id = '$id'", $link);
	





	$file_name = 'data/'.$id.'.stl';
	touch($file_name);

	chmod( $file_name, 0777 );

	$fp = fopen($file_name, "w");
	fwrite($fp, $stl);
	fclose($fp);

$res_m = mysql_query( "INSERT INTO 3dt(id,stl) VALUES ('$id','$file_name')", $link);


	mysql_close($link);

try {
	$oauth = new Oauth($consumer_key, $consumer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION);
	$oauth->enableDebug();
	$oauth->setToken($access_token, $access_secret);
} catch(OAuthException $E) {
	Error("setup exception", $E->getMessage(), null, null, $E->debugInfo);
}

try {
	$filename = $file_name;
	$file = file_get_contents($filename);
	$data = array("fileName" => "$filename",
		"file" => rawurlencode(base64_encode($file)),
		"hasRightsToModel" => 1,
		"acceptTermsAndConditions" => 1,
	);
	$data_string = json_encode($data);
	$oauth->fetch($api_url_base ."/models/v1", $data_string, OAUTH_HTTP_METHOD_POST, array("Accept" => "application/json"));
	$response = $oauth->getLastResponse();
	$json = json_decode($response);    
	if (null == $json) {
		PrintJsonLastError();
		var_dump($response);
	} else {
		print_r($json);
	}
} catch(OAuthException $E) {
	Error("fetch exception", $E->getMessage(), null, $oauth->getLastResponseInfo(), $E->debugInfo);
}



}




?>