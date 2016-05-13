<?php include "../include/db_connect_oo.php"; ?>
<?php
function addSale($sale_transaction, $conn) {
  $customer_id = $sale_transaction["customer_id"];
  $shipping_method = $sale_transaction["shipping_method"];
  $tax_vat = $sale_transaction["tax_vat"];
  $created_at = $sale_transaction["created_at"];
  $updated_at = $sale_transaction["updated_at"];
  $sql_sale = "INSERT INTO sales (user_id, customer_id, shipping_method, tax_vat, created_at, updated_at)
                VALUES (1, $customer_id, '$shipping_method', $tax_vat, '$created_at', '$updated_at')";
  if ($conn->query($sql_sale) === TRUE) {
    $sale_id = $conn->insert_id;
    $sql_sale_detail = "INSERT INTO sales_details (
      sale_id,
      product_id,
      price_level,
      original_price,
      custom_price,
      quantity,
      discount,
      created_at,
      updated_at
    )
    VALUES ";

    $products = $sale_transaction["products"];
    foreach ($products as $product) {
      $sql_sale_detail .= "(
        $sale_id,
        $product[id],
        $product[priceLevel],
        $product[originalPrice],
        $product[customPrice],
        $product[quantity],
        $product[discount],
        '$created_at',
        '$updated_at'
      ), ";
    }

    $sql_sale_detail = substr($sql_sale_detail, 0, -2);
    if ($conn->query($sql_sale_detail) === TRUE) {
    } else {
    }

  } else {
    echo $conn->error;
  }
}

function getProducts($conn) {
  $products = [];
  $sql = "SELECT * FROM products";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $products[] = $row;
    }
  }

  return $products;
}

function getCustomers($conn) {
  $customers = [];

  $sql = "SELECT * FROM customers";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $customers[] = $row;
    }
  }
  return $customers;
}

function getProductIdByCustomId($products, $key) {
  foreach ($products as $product) {
    if ($product["custom_id"]===$key) {
      return $product["id"];
    }
  }
  return 0;
}

function getCustomerIdByCustomId($customers) {
  foreach ($customers as $customer) {
    if ($product["custom_id"]===$key) {
      return $product["id"];
    }
  }
  return 0;
}
?>
<?php
$target_dir = "temp_file/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  // Allow certain file formats
  if($fileType != "csv") {
    echo "Sorry, only CSV file are allowed.";
    $uploadOk = 0;
  }
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
    exit();
  }
}
?>

<hr/>

<?php
$sql = "INSERT INTO products (
          category_id, name, short_name, custom_id,
          unit, weight, product_group,
          created_at, updated_at)
        VALUES ";
$sql_value = "";
$file = fopen($target_file,"r");
$counter = 0;
if ($file) {
  while( !feof($file) ) {
    $line = fgets($file);
    $entry = explode(",", $line);
    $sql_value .= "(";
    $sql_value .= "$entry[0],'$entry[1]','$entry[2]','$entry[3]',";
    $sql_value .= "'$entry[4]','$entry[5]','$entry[6]',";
    $sql_value .= "now(),now()";
    $sql_value .= "), ";
    echo $line. "<br />";
    $counter++;
  }

  echo "<hr />";
  echo $counter;
  echo "<hr />";
  $sql .= $sql_value;
  $sql = substr($sql, 0, -2);
  echo $sql;
  echo "<hr />";

  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
  if ($conn->query($sql) === TRUE) {
    echo "success";
  } else {
    echo $conn->error;
  }
  $conn->close();

  fclose($file);
  echo "<hr />";
  if (!unlink($target_file)) {
    echo ("Error deleting $target_file");
  } else {
    echo ("Deleted $target_file");
  }
} else {
  echo "file error";
  exit();
}

?>
