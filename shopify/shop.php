<?php

$product_name = $_POST['product_name'];
$description = $_POST['description'];
$vendor = $_POST['vendor'];
$product_type = $_POST['product_type'];
$tags = $_POST['tags'];
$price = (float)$_POST['price'];
$image_url = $_POST['image_url'];


  //Modify these
  $API_KEY = '0e89f6f34ecb6980cedb6eb3271aa68d';
  $SECRET = '145a1b574007b219aa3206bf206323bc';
  $TOKEN = 'bdb26dbe0a8b81ab93311527e6901535';
  $STORE_URL = 'tweetchain.myshopify.com';
  $PRODUCT_ID = '346158531';

  $url = 'https://' . $API_KEY . ':' . $TOKEN . '@' . $STORE_URL . '/admin/products.json';


  $session = curl_init();


$data = array("product" => array("title" => $product_name, "body_html" => $description,"vendor" =>$vendor, "product_type" => $product_type, "tags" =>$tags,"variants" =>array("price" => $price),"images" =>array("src" => $image_url)));                                                                    
$data_string = json_encode($data);   

//echo $data_string;

//echo $data_string;                                                        
curl_setopt($session, CURLOPT_URL, $url);             
curl_setopt($session, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($session, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($session, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                   
 
$result = curl_exec($session);

curl_close($session);

$result = json_decode($result);

 $handle = $result -> {"product"} ->{"handle"};
	$red_url = 'https://' . $STORE_URL .'/products/'.$handle;
header("Location: ".$red_url);

?>