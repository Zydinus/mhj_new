<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  // define variables and set to empty values
  $inputId = "";

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $inputId = testInput($_GET["id"]);
    $begin_date = testInput($_GET["begin_date"]);
    $end_date = testInput($_GET["end_date"]);
  }

  // die();
  $sql = "DELETE FROM buyes
          WHERE id=$inputId;";

  // echo $sql;
  if ($conn->query($sql) === TRUE) {
    $url = "admin_buyes_view.php?success=true&command=delete";
    $url .= "&begin_date=$begin_date";
    $url .= "&end_date=$end_date";
    header("Location: $url");
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
