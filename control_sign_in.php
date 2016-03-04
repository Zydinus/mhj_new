<?php include "include/include_pre.php" ?>
<?php
  // Start the session
  // session_start();

  // echo $_POST["inputEmail"]."<br/>";
  // echo $_POST["inputPassword"]."<br/>";

  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

  $input_email = $_POST["inputEmail"];
  $input_password = $_POST["inputPassword"];

  $sql = "SELECT * FROM users WHERE email='$input_email' AND password='$input_password'";
  $result = $conn->query($sql);
  if ( $result->num_rows == 1 ) {
    while($row = $result->fetch_assoc()) {
        $user_level = $row["level"];
    }
    $_SESSION["user_is_signin"] = true;
    $_SESSION["user_email"] = $_POST["inputEmail"];
    $_SESSION["user_level"] = $user_level;
    header("Location: index.php");
    die();
  } else {
    header("Location: sign_in_form.php?message=miss match email or password");
    die();
  }



?>
