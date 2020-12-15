<?php

$request = json_decode(file_get_contents('php://input'), true);	//js에서 post로 준 data 받음
$c_id = $request["c_id"];

try{ 
 $conn = oci_connect("B789041", "audqls", "203.249.87.162:1521/orcl");	//db접속

 $sql = "select salon.s_name,
 salon.s_address_si, salon.s_address_gu, salon.s_address_detail,
 h_name, r_date, r_time from reservation
 inner join hairdresser on reservation.h_id = hairdresser.h_id
 inner join salon on salon.s_id = hairdresser.s_id where c_id='".$id."'";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);
 $myReservations = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $myReservations[$index]->s_id = $row[0];
  $myReservations[$index]->s_address_si = $row[1];
  $myReservations[$index]->s_address_gu = $row[2];
  $myReservations[$index]->s_address_detail = $row[3];
  $myReservations[$index]->h_name = $row[4];
  $myReservations[$index]->r_date = $row[5];
  $myReservations[$index]->r_time = $row[6];
  $index++;
 }

 $response->result = 0;
 $response->myReservations = $myReservations;
 $json = json_encode($response);
 echo $json;	//result가 전달
}
catch(Exception $e){
 $response->result = 1;
 $response->error = $e->getMessage();
 $json = json_encode($response);
 echo $json;
}

?>
    