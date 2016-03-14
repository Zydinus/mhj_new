<?php include "include/include_pre.php" ?>
<?php
  // Start the session
  // session_start();

  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

  $input_token = $_POST["inputToken"];
  $input_password = $_POST["inputPassword"];

  $sql = "SELECT * FROM users WHERE (email='$input_token' OR username='$input_token') AND password='$input_password'";
  $result = $conn->query($sql);
  if ( $result->num_rows == 1 ) {
    while($row = $result->fetch_assoc()) {
      $user_id = $row["id"];
      $user_level = $row["level"];
      $user_email = $row["email"];
      $user_username = $row["username"];
    }
    $_SESSION["user_is_signin"] = true;
    $_SESSION["user_id"] = $user_id;
    $_SESSION["user_email"] = $user_email;
    $_SESSION["user_username"] = $user_username;
    $_SESSION["user_level"] = $user_level;
    header("Location: index.php");
    die();
  } else {
    header("Location: sign_in_form.php?message=miss_match_token_or_password");
    die();
  }



?>
