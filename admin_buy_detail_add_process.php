<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $buy_id = $product_id = $price_level = $original_price = $custom_price = $quantity = $discount = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $buy_id = testInput($_POST["buy_id"]);
    $product_id = testInput($_POST["product_id"]);
    $price_level = testInput($_POST["price_level"]);
    $original_price = testInput($_POST["original_price"]);
    $custom_price = testInput($_POST["custom_price"]);
    $quantity = testInput($_POST["quantity"]);
    $quantity_b = testInput($_POST["quantityB"]);
    $discount = testInput($_POST["discount"]);

    $quantity = $quantity === "" ? 0 : $quantity;
    $quantity_b = $quantity_b === "" ? 0 : $quantity_b;
  }

  $sql = "INSERT INTO buyes_details (
    buy_id,
    product_id,
    price_level,
    original_price,
    custom_price,
    quantity,
    quantity_b,
    discount,
    created_at,
    updated_at
  )
  VALUES (
    $buy_id,
    $product_id,
    $price_level,
    $original_price,
    $custom_price,
    $quantity,
    $quantity_b,
    $discount,
    now(),
    now()
  ) ";

  $result["sql"]=$sql;
  // $conn->query($sql) === TRUE
  if ($conn->query($sql) === TRUE) {

    $result["result"]=true;
    $result["details_id"] = $conn->insert_id;
  } else {
    $result["result"]=false;
    $result["reason"]=$conn->error;
  }


  $conn->close();
  header('Content-Type: application/json');
  echo json_encode($result);
?>
