<?php

require "consumer_key.php";
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

	$verbose_debug = true;
	$oauth_client = new Oauth($consumer_key, $consumer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION);
	$oauth_client->enableDebug();

	$oauth_token = "c9199349abac8d3490ab2e5ec7c1fda894a378d8";
	$oauth_token_secret = "9669805fd51824a46fda7c72945b10ae1b5bbe43";

	$oauth_client->setToken( $oauth_token,$oauth_token_secret );

	$pin = "c429b7";
	try {
		$info = $oauth_client->getAccessToken("$api_url_base/oauth1/access_token/v1", null, $pin);
		if ( array_key_exists('oauth_token', $info) &&
			array_key_exists('oauth_token_secret', $info) ) {
			echo "Access token        : ".$info['oauth_token']."\n";
			echo "Access token secret : ".$info['oauth_token_secret']."\n";
			echo "\nYou can store these access token values in access_token.php for the other scripts to use.\n";
			$oauth_client->setToken( $info['oauth_token'] , $info['oauth_token_secret'] );
		} else {
			Error("getAccessToken", null, $info, $oauth_client->getLastResponseInfo(), null);
		}
	} catch(OAuthException $E){
		echo "fff";
	}


}




?>