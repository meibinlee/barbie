<?php

$request = json_decode(file_get_contents('php://input'), true);	//js에서 post로 준 data 받음
$id = $request["s_id"];	//$:변수 post에서 받은 Json

try{ 
 $conn = oci_connect("B789041", "audqls", "203.249.87.162:1521/orcl");	//db접속

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
 if ($index==0){
   $response->result = 1;
   $response->error = "hairdressers Not Found";
   $json = json_encode($response);
   echo $json;  //result가 전달
   return;
 }

 $sql = "select s_name
         from salon where s_id='".$id."'";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);
 $salons = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $salons[$index]->s_name = $row[0];
  $index++;
 }
 if ($index==0){
   $response->result = 1;
   $response->error = "salon Not Found";
   $json = json_encode($response);
   echo $json;  //result가 전달
   return;
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

 $response->result = 0;
 $response->hairdressers = $hairdressers;
 $response->salon = $salons[0];
 $response->price = $prices[0];
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
    