<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $source = $_POST["source"];
    $inputShortName = testInput($_POST["inputShortName"]);
    $inputTitle = testInput($_POST["inputTitle"]);
    $inputName = testInput($_POST["inputName"]);
    $inputFirstContactDate = testInput($_POST["inputFirstContactDate"]);
    $inputContactName = testInput($_POST["inputContactName"]);
    $inputTaxVat = testInput($_POST["inputTaxVat"]);
    $inputAddress = testInput($_POST["inputAddress"]);
    $inputRegion = testInput($_POST["inputRegion"]);
    $inputProvince = testInput($_POST["inputProvince"]);
    $inputDistrict = testInput($_POST["inputDistrict"]);
    $inputZip = testInput($_POST["inputZip"]);
    $inputDistance = testInput($_POST["inputDistance"]);
    $inputTel = testInput($_POST["inputTel"]);
    $inputFax = testInput($_POST["inputFax"]);
    $inputMobileTel = testInput($_POST["inputMobileTel"]);
    $inputEmail = testInput($_POST["inputEmail"]);
    $optionsCustomerType = testInput($_POST["optionsCustomerType"]);
    $optionsPayment = testInput($_POST["optionsPayment"]);
    $optionsCredit = testInput($_POST["optionsCredit"]);
  }

  $sql = "INSERT INTO customers (
          `short_name`, `title`, `name`, `first_contact_date`,
          `contact_name`, `tax_vat`, `address_text`, `region`,
          `province`, `district`, `zip`, `distance`,
          `tel`, `fax`, `mobile_tel`, `email`,
          `customer_type`, `payment`, `credit`, `created_at`, `updated_at`)
          VALUES (
            '$inputShortName', '$inputTitle', '$inputName', '$inputFirstContactDate',
            '$inputContactName', $inputTaxVat, '$inputAddress', '$inputRegion',
            '$inputProvince', '$inputDistrict', '$inputZip', $inputDistance,
            '$inputTel', '$inputFax', '$inputMobileTel', '$inputEmail',
            '$optionsCustomerType', '$optionsPayment', '$optionsCredit', now(), now() )";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    header("Location: $source?success=true&command=add");
    die();
  } else {
    if ( strrpos($conn->error, "Duplicate") !== false ) {
      // echo "Duplicate";
      header("Location: $source?success=false&command=add&reason=duplicate");
      die();
    } else {
      echo $conn->error;
    }
  }
?>
