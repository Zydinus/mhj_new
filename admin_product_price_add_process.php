<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $inputProductId = $inputPrice = $inputPriceType = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputProductId = testInput($_POST["inputProductId"]);
    $inputPrice = testInput($_POST["inputPrice"]);
    $inputPriceLevel = testInput($_POST["inputPriceLevel"]);
    $inputPriceType = testInput($_POST["inputPriceType"]);
  }

  if ($inputPriceType==="sale") {
    $sql = "INSERT INTO product_sale_prices (product_id, price, price_level, created_at, updated_at)
            VALUES ($inputProductId, $inputPrice, $inputPriceLevel, now(), now())";
  } elseif ($inputPriceType==="buy") {
    $sql = "INSERT INTO product_buy_prices (product_id, price, price_level, created_at, updated_at)
            VALUES ($inputProductId, $inputPrice, $inputPriceLevel, now(), now())";
  }

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;

    $result["result"]=true;
    $result["insert_id"]=$last_id;
    $result["price"]=getPriceById($conn, $last_id, $inputPriceType);
  } else {
    echo $conn->error;
    $result["result"]=false;
    $result["reason"]=$conn->error;
  }

  $conn->close();
  header('Content-Type: application/json');
  echo json_encode($result);
?>
