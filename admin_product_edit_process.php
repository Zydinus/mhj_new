<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $inputId = $inputName = $inputEmail = $inputPassword = $optionsPermission = $source = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputId = testInput($_POST["inputIdEdit"]);
    $inputCustomId = testInput($_POST["inputCustomId"]);
    $inputName = testInput($_POST["inputName"]);
    $inputShortName = testInput($_POST["inputShortName"]);
    $inputUnit = testInput($_POST["inputUnit"]);
    $inputWeight = testInput($_POST["inputWeight"]);
    $optionsCategory = testInput($_POST["optionsCategory"]);
    $source = testInput($_POST["source"]);
  }

  $sql = "UPDATE products
          SET custom_id='$inputCustomId',
            name='$inputName',
            short_name='$inputShortName',
            unit='$inputUnit',
            weight=$inputWeight,
            category_id=$optionsCategory,
            updated_at=now()
          WHERE id=$inputId;";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    header("Location: $source?success=true&command=edit");
    die();
  } else {
      // echo "Error: " . $sql . "<br>" . $conn->error;
    if ( strrpos($conn->error, "Duplicate") !== false ) {
      // echo "Duplicate";
      header("Location: $source?success=false&command=edit&reason=duplicate");
      die();
    } else {
      echo $conn->error;
    }
  }
?>
