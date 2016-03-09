<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $inputCustomId = $inputName = $inputShortName = $inputUnit = $inputUnit = $inputWeight = $inputGroup = $optionsActive = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputCustomId = testInput($_POST["inputCustomId"]);
    $inputName = testInput($_POST["inputName"]);
    $inputShortName = testInput($_POST["inputShortName"]);
    $inputUnit = testInput($_POST["inputUnit"]);
    $inputWeight = testInput($_POST["inputWeight"]);
    $inputGroup = testInput($_POST["inputGroup"]);
    $inputSalePrice1 = testInput($_POST["inputSalePrice1"]);
    $inputSalePrice2 = testInput($_POST["inputSalePrice2"]);
    $inputSalePrice3 = testInput($_POST["inputSalePrice3"]);
    $inputBuyPrice1 = testInput($_POST["inputBuyPrice1"]);
    $inputBuyPrice2 = testInput($_POST["inputBuyPrice2"]);
    $inputBuyPrice3 = testInput($_POST["inputBuyPrice3"]);
    $optionsCategory = testInput($_POST["optionsCategory"]);
  }

  $sql = "INSERT INTO products (category_id, name, short_name, custom_id, unit, weight, product_group, created_at, updated_at)
          VALUES ($optionsCategory, '$inputName', '$inputShortName', '$inputCustomId','$inputUnit', $inputWeight, '$inputGroup', now(), now() )";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;

    $sql2 = "INSERT INTO product_sale_prices (product_id, price, price_level, created_at, updated_at)
             VALUES
              ($last_id, $inputSalePrice1, 1, now(), now()),
              ($last_id, $inputSalePrice2, 2, now(), now()),
              ($last_id, $inputSalePrice3, 3, now(), now())
              ;";
    $sql3 = "INSERT INTO product_buy_prices (product_id, price, price_level, created_at, updated_at)
             VALUES
              ($last_id, $inputBuyPrice1, 1, now(), now()),
              ($last_id, $inputBuyPrice2, 2, now(), now()),
              ($last_id, $inputBuyPrice3, 3, now(), now())
              ;";

    if ($conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE) {
      header("Location: admin_products_view.php?success=true&command=add");
      die();
    } else {
      if ( strrpos($conn->error, "Duplicate") !== false ) {
        // echo "Duplicate";
        header("Location: admin_products_view.php?success=false&command=add&reason=duplicate");
        die();
      } else {
        echo $conn->error;
      }
    }


  } else {
      // echo "Error: " . $sql . "<br>" . $conn->error;
    if ( strrpos($conn->error, "Duplicate") !== false ) {
      // echo "Duplicate";
      header("Location: admin_products_view.php?success=false&command=add&reason=duplicate");
      die();
    } else {
      echo $conn->error;
    }
  }
?>
