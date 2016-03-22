<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $source = $inputCategoryName = $inputCategoryShortName = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $source = testInput($_POST["source"]);
    $inputCategoryName = testInput($_POST["inputCategoryName"]);
    $inputCategoryShortName = testInput($_POST["inputCategoryShortName"]);
  }

  $sql = "INSERT INTO product_categories (name, custom_id, created_at, updated_at)
          VALUES ('$inputCategoryName', '$inputCategoryShortName', now(), now())";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;

    $result["result"]=true;
    $result["insert_id"]=$last_id;
  } else {
    echo $conn->error;
    $result["result"]=false;
    $result["reason"]=$conn->error;
  }

  $conn->close();
  header('Content-Type: application/json');
  echo json_encode($result);
?>
