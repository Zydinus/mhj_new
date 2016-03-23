<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $source = $id = $inputCategoryName = $inputCategoryShortName = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = testInput($_POST["id"]);
    $source = testInput($_POST["source"]);
    $inputCategoryName = testInput($_POST["inputCategoryName"]);
    $inputCategoryShortName = testInput($_POST["inputCategoryShortName"]);
  }

  $sql = "UPDATE product_categories SET
          name='$inputCategoryName',
          custom_id='$inputCategoryShortName',
          updated_at=now()
          WHERE id=$id ";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {

    $result["result"]=true;
    $result["update_id"]=$id;
  } else {
    echo $conn->error;
    $result["result"]=false;
    $result["reason"]=$conn->error;
  }

  $conn->close();
  header('Content-Type: application/json');
  echo json_encode($result);
?>
