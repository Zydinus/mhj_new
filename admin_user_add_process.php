<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $inputName = $inputUsername = $inputEmail = $inputPassword = $optionsPermission = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputName = testInput($_POST["inputName"]);
    $inputUsername = testInput($_POST["inputUsername"]);
    $inputEmail = testInput($_POST["inputEmail"]);
    $inputPassword = testInput($_POST["inputPassword"]);
    $optionsPermission = testInput($_POST["optionsPermission"]);
  }

  $sql = "INSERT INTO users (name, username, email, password, level, created_at, updated_at)
          VALUES ('$inputName', '$inputUsername', '$inputEmail', '$inputPassword', $_POST[optionsPermission], now(), now() )";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    header("Location: admin_users_view.php?success=true&command=add");
    die();
  } else {
      // echo "Error: " . $sql . "<br>" . $conn->error;
    if ( strrpos($conn->error, "Duplicate") !== false ) {
      header("Location: admin_users_view.php?success=false&command=add&reason=duplicate");
    } else {
      echo $conn->error;
    }
  }
?>
