<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(100);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $customer_id = $products = $user_id = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = testInput($_POST["customer_id"]);
    $user_id = testInput($_POST["user_id"]);
    $shipping_method = testInput($_POST["shipping_method"]);
    $tax_vat = testInput($_POST["tax_vat"]);
  }

  $products = $_POST["products"];

  $sql_buy = "INSERT INTO buyes (user_id, customer_id, shipping_method, tax_vat, created_at, updated_at)
          VALUES ($user_id, $customer_id, '$shipping_method', $tax_vat, now(), now())";

  // echo $sql;
  if ($conn->query($sql_buy) === TRUE) {
    $buy_id = $conn->insert_id;
    $buy["buy_id"] = $buy_id;

    foreach ($products as $product) {
      $product_quantity = $product["quantity"]===""? 0 : $product["quantity"];
      $product_quantity_b = $product["quantityB"]===""? 0 : $product["quantityB"];
      $sql_buy_detail = "INSERT INTO buyes_details (
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
        $product[id],
        $product[priceLevel],
        $product[originalPrice],
        $product[customPrice],
        $product_quantity,
        $product_quantity_b,
        $product[discount],
        now(),
        now()
      ) ";

      if ($conn->query($sql_buy_detail) === TRUE) {
        $buy_detail_id = $conn->insert_id;

        $buy["details"][] = $buy_detail_id;
      } else {
        $result["result"]=false;
        $result["reason"]=$conn->error;
        break;
      }
    }



    $result["result"]=true;
    $result["buy"]=$buy;
  } else {
    // echo $conn->error;
    $result["result"]=false;
    $result["reason"]=$conn->error;
  }


  $conn->close();
  header('Content-Type: application/json');
  echo json_encode($result);
?>
