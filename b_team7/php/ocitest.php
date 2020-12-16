<?php 
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
 $json = json_encode($response);
 echo $json;
} 
catch(PDOException $e){
 echo "Failed to obtain database handle " . $e->getMessage(); 
} 
?>
