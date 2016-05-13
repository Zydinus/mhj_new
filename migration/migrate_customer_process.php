<?php include "../include/db_connect_oo.php"; ?>
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
$sql = "INSERT INTO customers (
        `custom_id`, `short_name`, `title`, `name`, `first_contact_date`,
        `contact_name`, `tax_vat`, `address_text`, `region`,
        `province`, `district`, `zip`, `distance`,
        `tel`, `fax`, `mobile_tel`, `email`,
        `customer_type`, `payment`, `credit`,
        `sale_price_level`, `buy_price_level`,
        `created_at`, `updated_at`)
        VALUES ";
$sql_value = "";
$file = fopen($target_file,"r");
$counter = 0;
if ($file) {
  while( !feof($file) ) {
    $line = fgets($file);
    $entry = explode(",", $line);
    $sql_value .= "(";
    $sql_value .= "'$entry[0]','$entry[1]','$entry[2]','$entry[3]','$entry[4]',";
    $sql_value .= "'$entry[5]','$entry[6]','$entry[7]','$entry[8]',";
    $sql_value .= "'$entry[9]','$entry[10]','$entry[11]',$entry[12],";
    $sql_value .= "'$entry[13]','$entry[14]','$entry[15]','$entry[16]',";
    $sql_value .= "'$entry[17]','$entry[18]','$entry[19]',";
    $sql_value .= "$entry[20],$entry[21],";
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
