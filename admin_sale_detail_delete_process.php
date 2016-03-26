<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $id = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = testInput($_POST["id"]);
  }

  // die();
  $sql = "DELETE FROM sales_details WHERE id=$id";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    $result["result"]=true;
    $result["delete_id"]=$id;
  } else {
    $result["result"]=false;
    $result["reason"]=$conn->error;
  }

  $conn->close();
  header('Content-Type: application/json');
  echo json_encode($result);
?>
