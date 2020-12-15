<?php

$request = json_decode(file_get_contents('php://input'), true);
$s_id = $request["s_id"];
$s_pw = $request["s_pw"];
$s_name = $request["s_name"];
$s_address_si = $request["s_address_si"];
$s_address_gu = $request["s_address_gu"];
$s_address_detail = $request["s_address_detail"];
$s_phonenumber = $request["s_phonenumber"];

$h_id_1 = $request["h_id_1"];
$h_name_1 = $request["h_name_1"];
$h_gender_1 = $request["h_gender_1"];
$h_career_1 = $request["h_career_1"];

$h_id_2 = $request["h_id_2"];
$h_name_2 = $request["h_name_2"];
$h_gender_2 = $request["h_gender_2"];
$h_career_2 = $request["h_career_2"];

$h_id_3 = $request["h_id_3"];
$h_name_3 = $request["h_name_3"];
$h_gender_3 = $request["h_gender_3"];
$h_career_3 = $request["h_career_3"];


$dyeing = $request["dyeing"];
$perm = $request["perm"];
$cut = $request["cut"];

try{
	$conn = oci_connect("B789041", "audqls", "203.249.87.162:1521/orcl"); //디비 접속

	$sql = "update salon
     set s_pw='".$s_pw."', s_name='".$s_name."', s_address_si='".$s_address_si."', s_address_gu='".$s_address_gu."', s_address_detail='".$s_address_detail."', s_phonenumber='".$s_phonenumber."'
     where s_id='".$s_id."'";
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);


	$sql = "update hairdresser
     set h_name='".$h_name_1."', h_gender='".$h_gender_1."', h_career='".$h_career_1."'
     where h_id='".$h_id_1."'";
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);

	$sql = "update hairdresser
     set h_name='".$h_name_2."', h_gender='".$h_gender_2."', h_career='".$h_career_2."'
     where h_id='".$h_id_2."'";
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);

	$sql = "update hairdresser
     set h_name='".$h_name_3."', h_gender='".$h_gender_3."', h_career='".$h_career_3."'
     where h_id='".$h_id_3."'";
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);


	$sql = "update price
     set dyeing='".$dyeing."', perm='".$perm."', cut='".$cut."'
     where s_id='".$s_id."'";
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