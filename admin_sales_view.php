<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("title") ?></title>

  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <div class="container">
      <h1>
        <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
        <?= s2("sale_dashboard") ?>
      </h1>

      <div class="row">
        <form method="get">
          <div class="col-lg-2 col-lg-offset-5">
            <div class="form-group">
              <label for="begin_date">begin_date</label>
              <input type="date" class="form-control" id="begin_date" name="begin_date" required>
            </div>
            <div class="form-group">
              <label for="begin_date">end_date</label>
              <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="form-group text-right">
              <a href="admin_sales_view.php" class="btn btn-default" role="button">
                <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                Reset
              </a>
              <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                Filter
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class="row">

        <div class="col-lg-12">
          <h3>
            <?= s2("sale_list") ?>
            <?= isset($_GET["begin_date"]) ? $_GET["begin_date"] : "";?> &lt;-&gt;
            <?= isset($_GET["end_date"]) ? $_GET["end_date"] : "";?>
          </h3>
          <table class="table table-hover table-striped table-condensed">
            <thead>
              <tr>
                <th><?= s2("customer_name") ?></th>
                <th><?= s2("contract_name") ?></th>
                <th><?= s2("date_time") ?></th>
                <th><?= s2("total") ?></th>
                <th><?= s2("by_user") ?></th>
                <th><?= s2("edit") ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $d1=new DateTime("now");
              $d1->setTimezone(new DateTimeZone('Asia/Bangkok'));

              $begin_date = isset($_GET["begin_date"]) ? $_GET["begin_date"] : $d1->format('Y-m-d');
              $end_date = isset($_GET["end_date"]) ? $_GET["end_date"] : $d1->format('Y-m-d');

              $sales = getSalesWithTotal($conn, $begin_date, $end_date);
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

      </div>
    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
