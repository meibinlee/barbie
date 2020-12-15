<?php

$request = json_decode(file_get_contents('php://input'), true);
$c_id = $request["c_id"];
$c_pw = $request["c_pw"];
$c_name = $request["c_name"];
$c_address_si = $request["c_address_si"];
$c_address_gu = $request["c_address_gu"];
$c_phonenumber = $request["c_phonenumber"];

try{
	$conn = oci_connect("B789041", "audqls", "203.249.87.162:1521/orcl"); //디비 접속

	$sql = "update customer
     set c_pw='".$c_pw."', c_name='".$c_name."', c_address_si='".$c_address_si."', c_address_gu='".$c_address_gu."', c_phonenumber='".$c_phonenumber."'
     where c_id='".$c_id."'";

	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);
	oci_free_statement($stmt);
	oci_close($conn);

	$response->result = 0;
	$response->body = "Update success!!";
	$json = json_encode($response);
	echo $json;
}
catch(Exception $e){
 $response->result = 1;
 $response->error = $e->getMessage();
 $json = json_encode($response);
 echo $json;
}

?>