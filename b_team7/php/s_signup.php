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

	$sql = "insert into salon (s_id, s_pw, s_name, s_address_si, s_address_gu, s_address_detail, s_phonenumber)
        values ('".$s_id."','".$s_pw."','".$s_name."','".$s_address_si."','".$s_address_gu."','".$s_address_detail."',
        '".$s_phonenumber."')";
    $stmt = oci_parse($conn, $sql);
	oci_execute($stmt);

	$sql = "insert into hairdresser (h_id, s_id, h_name, h_gender, h_career)
	    values (h_seq.NEXTVAL, '".$s_id."', '".$h_name_1."','".$h_gender_1."','".$h_career_1."')";
    $stmt = oci_parse($conn, $sql);
	oci_execute($stmt);

	$sql = "insert into hairdresser (h_id, s_id, h_name, h_gender, h_career)
	    values (h_seq.NEXTVAL, '".$s_id."', '".$h_name_2."','".$h_gender_2."','".$h_career_2."')";
    $stmt = oci_parse($conn, $sql);
	oci_execute($stmt);

	$sql = "insert into hairdresser (h_id, s_id, h_name, h_gender, h_career)
	    values (h_seq.NEXTVAL, '".$s_id."', '".$h_name_3."','".$h_gender_3."','".$h_career_3."')";
    $stmt = oci_parse($conn, $sql);
	oci_execute($stmt);


    $sql = "insert into price (s_id, dyeing, perm, cut)
	    values ('".$s_id."', '".$dyeing."', '".$perm."', '".$cut."')";
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