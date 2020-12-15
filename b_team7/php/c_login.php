<?php

$request = json_decode(file_get_contents('php://input'), true);	//js에서 post로 준 data 받음
$id = $request["c_id"];	//$:변수 post에서 받은 Json
$pw = $request["c_pw"];

try{ 
 $conn = oci_connect("B789041", "audqls", "203.249.87.162:1521/orcl");	//db접속

 $sql = "select c_id,c_pw,c_name,c_gender,c_address_si,c_address_gu,c_phonenumber,c_birthdate
         from customer where c_id='".$id."' and c_pw='".$pw."'";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);

 $customers = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $customers[$index]->c_id = $row[0];
  $customers[$index]->c_pw = $row[1];
  $customers[$index]->c_name = $row[2];
  $customers[$index]->c_gender = $row[3];
  $customers[$index]->c_address_si = $row[4];
  $customers[$index]->c_address_gu = $row[5];
  $customers[$index]->c_phonenumber = $row[6];
  $customers[$index]->c_birthdate = $row[7];
  $index++;
 }
  if ($index==0){
   $response->result = 1;
   $response->error = "Customer Not Found";
   $json = json_encode($response);
   echo $json;  //result가 전달
   return;
 }

 $si = $customers[0]->c_address_si;
 $gu = $customers[0]->c_address_gu;
 $sql = "select s_id,s_name,s_phonenumber,s_address_si,s_address_gu,s_address_detail
         from salon where s_address_si='".$si."' and s_address_gu='".$gu."' order by s_name ";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);

 $nearSalons = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $nearSalons[$index]->s_id = $row[0];
  $nearSalons[$index]->s_name = $row[1];
  $nearSalons[$index]->s_phonenumber = $row[2];
  $nearSalons[$index]->s_address_si = $row[3];
  $nearSalons[$index]->s_address_gu = $row[4];
  $nearSalons[$index]->s_address_detail = $row[5];
  $index++;
 }

 
 $today = date("Ymd", time());
 $sql = "select salon.s_name,
 salon.s_address_si, salon.s_address_gu, salon.s_address_detail,
 h_name, r_id, r_date, r_time from reservation
 inner join hairdresser on reservation.h_id = hairdresser.h_id
 inner join salon on salon.s_id = hairdresser.s_id where c_id='".$id."'
  and r_date>='" .$today. "' order by r_date desc ";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);
 $myReservations = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $myReservations[$index]->s_name = $row[0];
  $myReservations[$index]->s_address_si = $row[1];
  $myReservations[$index]->s_address_gu = $row[2];
  $myReservations[$index]->s_address_detail = $row[3];
  $myReservations[$index]->h_name = $row[4];
  $myReservations[$index]->r_id = $row[5];
  $myReservations[$index]->r_date = $row[6];
  $myReservations[$index]->r_time = $row[7];
  $index++;
 }

 $response->result = 0;
 $response->customer = $customers[0];
 $response->nearSalons = $nearSalons;
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
    