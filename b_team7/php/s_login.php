<?php

$request = json_decode(file_get_contents('php://input'), true);	//js에서 post로 준 data 받음
$id = $request["s_id"];	//$:변수 post에서 받은 Json
$pw = $request["s_pw"];

try{ 
 $conn = oci_connect("B789041", "audqls", "203.249.87.162:1521/orcl");	//db접속

 $sql = "select s_id,s_pw,s_name,s_phonenumber,s_address_si,s_address_gu,s_address_detail
         from salon where s_id='".$id."' and s_pw='".$pw."'";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);
 $salons = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $salons[$index]->s_id = $row[0];
  $salons[$index]->s_pw = $row[1];
  $salons[$index]->s_name = $row[2];
  $salons[$index]->s_phonenumber = $row[3];
  $salons[$index]->s_address_si = $row[4];
  $salons[$index]->s_address_gu = $row[5];
  $salons[$index]->s_address_detail = $row[6];
  $index++;
 }
 if ($index==0){
   $response->result = 1;
   $response->error = "Salon Not Found";
   $json = json_encode($response);
   echo $json;  //result가 전달
   return;
 }

 $sql = "select h_id,h_name,h_gender,h_career
         from hairdresser where s_id='".$id."'";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);
 $hairdressers = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $hairdressers[$index]->h_id = $row[0];
  $hairdressers[$index]->h_name = $row[1];
  $hairdressers[$index]->h_gender = $row[2];
  $hairdressers[$index]->h_career = $row[3];
  $index++;
 }

 $sql = "select dyeing,perm,cut
         from price where s_id='".$id."'";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);
 $prices = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $prices[$index]->dyeing = $row[0];
  $prices[$index]->perm = $row[1];
  $prices[$index]->cut = $row[2];
  $index++;
 }
 if ($index==0){
   $response->result = 1;
   $response->error = "Price Info Not Found";
   $json = json_encode($response);
   echo $json;  //result가 전달
   return;
 }

 $today = date("Ymd", time());
 $sql = "select c_id,r_style,r_date,r_time from reservation 
 where reservation.h_id in
 (select hairdresser.h_id from hairdresser where hairdresser.s_id='".$id."'
  and reservation.r_date='".$today."')";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);
 $todayReservations = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $todayReservations[$index]->c_id = $row[0];
  $todayReservations[$index]->r_style = $row[1];
  $todayReservations[$index]->r_date = $row[2];
  $todayReservations[$index]->r_time = $row[3];
  $index++;
 }
 
 $tmrw = date("Ymd", strtotime($day." +1 day"));
 $sql = "select c_id,r_style,r_date,r_time from reservation 
 where reservation.h_id in
 (select hairdresser.h_id from hairdresser where hairdresser.s_id='".$id."'
  and reservation.r_date='".$tmrw."')";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);
 $tmrwReservations = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $tmrwReservations[$index]->c_id = $row[0];
  $tmrwReservations[$index]->r_style = $row[1];
  $tmrwReservations[$index]->r_date = $row[2];
  $tmrwReservations[$index]->r_time = $row[3];
  $index++;
 }
 
 $response->result = 0;
 $response->salon = $salons[0];
 $response->hairdresser1 = $hairdressers[0];
 $response->hairdresser2 = $hairdressers[1];
 $response->hairdresser3 = $hairdressers[2];
 $response->price = $prices[0];
 $response->todayReservations = $todayReservations;
 $response->tmrwReservations = $tmrwReservations;
 $json = json_encode($response);
 echo $json;  //result가 전달
}

catch(Exception $e){
 $response->result = 1;
 $response->error = $e->getMessage();
 $json = json_encode($response);
 echo $json;
}

?>
    