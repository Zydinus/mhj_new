<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // echo $_POST["inputName"];
  // echo $_POST["inputEmail"];
  // echo $_POST["inputPassword"];
  // echo $_POST["optionsPermission"];

  $sql = "INSERT INTO users (name, email, password, level, created_at, updated_at)
          VALUES ('$_POST[inputName]', '$_POST[inputEmail]', '$_POST[inputPassword]', $_POST[optionsPermission], now(), now() )";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    header("Location: admin_users_view.php?success=true");
    die();
  } else {
      // echo "Error: " . $sql . "<br>" . $conn->error;
    if ( strrpos($conn->error, "Duplicate") !== false ) {
      echo "Duplicate";
    } else {
      echo $conn->error;
    }
  }
?>
