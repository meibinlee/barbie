<?php

$request = json_decode(file_get_contents('php://input'), true);
$c_id = $request["c_id"];
$c_pw = $request["c_pw"];
$c_name = $request["c_name"];
$c_gender = $request["c_gender"];
$c_address_si = $request["c_address_si"];
$c_address_gu = $request["c_address_gu"];
$c_phonenumber = $request["c_phonenumber"];
$c_birthdate = $request["c_birthdate"];

try{
	$conn = oci_connect("B789041", "audqls", "203.249.87.162:1521/orcl"); //디비 접속

	$sql = "insert into customer (c_id, c_pw, c_name, c_gender, c_address_si, c_address_gu, c_phonenumber, c_birthdate)
 values ('".$c_id."','".$c_pw."','".$c_name."','".$c_gender."','".$c_address_si."','".$c_address_gu."','".$c_phonenumber."','".$c_birthdate."')";
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);

	oci_free_statement($stmt);
	oci_close($conn);

	$response->result = 0;
	$response->body = "Sign up success!!";
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

