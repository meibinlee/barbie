<?php

  $request = json_decode(file_get_contents('php://input'), true);
  $c_id = $request["c_id"];
  $h_id = $request["h_id"];
  $r_date = $request["r_date"];
  $r_style = $request["r_style"];
  $r_time = $request["r_time"];

  try{
   $conn = oci_connect("B789041", "audqls", "203.249.87.162:1521/orcl");

    $sql = "select h_id, r_date, r_time from reservation
     where h_id='".$h_id."' and r_date='".$r_date."' and r_time='".$r_time."'";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);

    $reservations = array();
    $index = 0;
    while ($row=oci_fetch_row($stmt)) {
    $reservations[$index]->h_id = $row[0];
    $reservations[$index]->r_date = $row[1];
    $reservations[$index]->r_time = $row[2];
    $index++;
    }

    if ($index == 1){
     $response->result = 1;
     $response->error = "Please Choose Another Time";
     $json = json_encode($response);
     echo $json;  //result가 전달
     return;
    }

    $sql = "insert into reservation (r_id, c_id, h_id, r_date, r_style,r_time)
    values (r_seq.NEXTVAL, '".$c_id."', '".$h_id."', '".$r_date."', '".$r_style."', '".$r_time."')";

    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    oci_free_statement($stmt);
    oci_close($conn);

    $response->result = 0;
    $response->body = "Complete Reservation";
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