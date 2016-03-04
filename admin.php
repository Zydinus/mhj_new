<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "include/include_head.php" ?>
  <title>Admin</title>

</head>
<body>
  <?php include "include/include_body.php" ?>
  <div class="container">
    <h1><?php echo $s_title; ?></h1>
    <?php
      $users = getUsers($conn);
      $normal_users = getUsers($conn,'normal');
      $admin_users = getUsers($conn,'admin');
    ?>

    <div class="row">

      <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Admin User</h3>
          </div>
          <div class="panel-body">

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>name</th>
                  <th>email</th>
                  <th>password</th>
                </tr>
              </thead>
              <tbody>
                <?php
                for ($i=0; $i < count($admin_users); $i++) {
                  echo "<tr>";
                  echo "<td>".$admin_users[$i]["name"]."</td>";
                  echo "<td>".$admin_users[$i]["email"]."</td>";
                  echo "<td>".$admin_users[$i]["password"]."</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>

          </div>
          <div class="panel-footer text-right table-hover">
            <a href="admin_users_view.php" class="btn btn-info">View</a>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Normal User</h3>
          </div>
          <div class="panel-body">

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>name</th>
                  <th>email</th>
                  <th>password</th>
                </tr>
              </thead>
              <tbody>
                <?php
                for ($i=0; $i < count($normal_users); $i++) {
                  echo "<tr>";
                  echo "<td>".$normal_users[$i]["name"]."</td>";
                  echo "<td>".$normal_users[$i]["email"]."</td>";
                  echo "<td>".$normal_users[$i]["password"]."</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>

          </div>
          <div class="panel-footer text-right table-hover">
            <a href="admin_users_view.php" class="btn btn-info">View</a>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Item</h3>
          </div>
          <div class="panel-body">
            active: <br/>
            inactive:
          </div>
          <div class="panel-footer text-right">
            view | add
          </div>
        </div>
      </div>

    </div>

  </div>

  <!--  nev bar -->
  <?php include "nev_bar.php" ?>
</body>
</html>
