<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $inputCustomId = $inputName = $inputShortName = $inputUnit = $inputUnit = $inputWeight = $optionsActive = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputCustomId = testInput($_POST["inputCustomId"]);
    $inputName = testInput($_POST["inputName"]);
    $inputShortName = testInput($_POST["inputShortName"]);
    $inputUnit = testInput($_POST["inputUnit"]);
    $inputWeight = testInput($_POST["inputWeight"]);
    $inputSalePrice = testInput($_POST["inputSalePrice"]);
    $inputBuyPrice = testInput($_POST["inputBuyPrice"]);
    $optionsCategory = testInput($_POST["optionsCategory"]);
  }

  $sql = "INSERT INTO products (category_id, name, short_name, custom_id, unit, weight, created_at, updated_at)
          VALUES ($optionsCategory, '$inputName', '$inputShortName', '$inputCustomId','$inputUnit', $inputWeight, now(), now() )";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;

    $sql2 = "INSERT INTO product_sale_prices (product_id, price, created_at, updated_at)
             VALUES ($last_id, $inputSalePrice, now(), now());";
    $sql3 = "INSERT INTO product_buy_prices (product_id, price, created_at, updated_at)
             VALUES ($last_id, $inputBuyPrice, now(), now());";

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
