<?php

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

}

print $id;



?>