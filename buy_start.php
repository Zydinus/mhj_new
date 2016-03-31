<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(100);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("buy_system") ?></title>

  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <?php
    $d1=new DateTime("now");
    $d1->setTimezone(new DateTimeZone('Asia/Bangkok'));
    ?>
    <div class="container">
      <h1>
        <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
        <?= s2("buy_system") ?>
      </h1>

      <div class="row">

        <div class="col-lg-8">
          <h3><?= s2("sale_list_today") ?> <?= $d1->format(DateTime::RSS)?></h3>
          <table class="table table-hover table-striped table-condensed">
            <thead>
              <tr>
                <th><?= s2("customer_name") ?></th>
                <th><?= s2("contact_name") ?></th>
                <th><?= s2("date_time") ?></th>
                <th><?= s2("total") ?></th>
                <th><?= s2("by_user") ?></th>
                <th><?= s2("edit") ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sales = getTodayBuyesWithTotal($conn);
              foreach ($sales as $sale) {
                ?>
                <tr>
                  <td><?= $sale["customer_name"]?></td>
                  <td><?= $sale["contact_name"]?></td>
                  <td><?= $sale["sale_created_at"]?></td>
                  <td><?= $sale["total"]?></td>
                  <td><?= $sale["user_name"]?></td>
                  <td>.</td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>

        <div class="col-lg-4">
          <p class="text-center">
            <a href="buy_form.php" class="btn btn-primary btn-lg">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              <?= s2("buy_new") ?>
            </a>
          </p>
        </div>

      </div>
    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
