<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $customer_id = "";
  $buy_id = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = testInput($_POST["new_customer_id"]);
    $buy_id = testInput($_POST["buy_id"]);
  }

  // die();
  $sql = "UPDATE buyes SET customer_id=$customer_id WHERE id=$buy_id";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    $result["result"]=true;
    $result["customer_id"]=$customer_id;
  } else {
    $result["result"]=false;
    $result["reason"]=$conn->error;
  }

  $conn->close();
  header('Content-Type: application/json');
  echo json_encode($result);
?>
