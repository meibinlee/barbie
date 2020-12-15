<?php 

$request = json_decode(file_get_contents('php://input'), true);
$id = $request["c_id"];
$pw = $request["c_pw"];

try{ 
 $conn = oci_connect("B789041", "audqls", "203.249.87.162:1521/orcl");

 $sql = "select * from salon";
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);
 $salons = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $salons[$index]->s_id = $row[0];
  $salons[$index]->s_pw = $row[1];
  $salons[$index]->s_name = $row[2];
  $index++;
 }
 $response->salons = $salons;

 $sql = "select * from reservation where c_id='".$id."'";
 $response->id = $id;
 $stmt = oci_parse($conn, $sql);
 oci_execute($stmt);
 $reservations = array();
 $index = 0;
 while ($row=oci_fetch_row($stmt)) {
  $reservations[$index]->r_id = $row[0];
  $reservations[$index]->c_id = $row[1];
  $reservations[$index]->h_id = $row[2];
  $index++;
 }
 $response->reservations = $reservations;
 $response->result = 0;
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
