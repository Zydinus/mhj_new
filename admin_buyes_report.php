<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  $sales = getAllBuyes($conn);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("buy_report"); ?></title>

  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <div class="container">
      <h1>
        <?= s2("sale_report"); ?>
      </h1>

      <div class="row">
        <h3>Total Buy Table</h3>
        <div class="col-lg-12">
          <table class="table table-hover table-striped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Customer name</th>
                <th>Total</th>
                <th>Tax</th>
                <th>Grand Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sales_reversed = array_reverse($sales);
              foreach ($sales_reversed as $sale) {
                ?>
                <tr>
                  <td><?= $sale["buy_created_at"]?></td>
                  <td><?= $sale["customer_name"]?></td>
                  <td><?= $sale["total"]?></td>
                  <td><?= $sale["tax_vat_value"]?></td>
                  <td><?= $sale["grand_total"]?></td>
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
