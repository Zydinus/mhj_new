<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  $sale = getSalesById($conn, $_GET["id"]);
  $sale_details = getSaleDetailsBySaleId($conn, $_GET["id"]);
  $customer = getCustomerById($conn, $sale["customer_id"]);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("sale_dashboard"); ?></title>

  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <div class="container">
      <h1>
        <?= s2("sale_dashboard"); ?>
      </h1>

      <div class="row">
        <div class="col-lg-6">
          <dl class="dl-horizontal">
            <dt>Id</dt>
            <dd><?= $customer["id"] ?></dd>
          </dl>

          <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd><?= $customer["name"] ?></dd>
          </dl>

        </div>

        <div class="col-lg-6">
          <dl class="dl-horizontal">
            <dt>date</dt>
            <dd><?= $sale["sale_created_at"] ?></dd>
          </dl>

          <dl class="dl-horizontal">
            <dt>shipping method</dt>
            <dd><?= $sale["shipping_method"] ?></dd>
          </dl>

          <dl class="dl-horizontal">
            <dt>sale_price_level</dt>
            <dd><?= $customer["sale_price_level"] ?></dd>
          </dl>

        </div>

      </div>

      <div class="row">
        <h3>sale details</h3>
        <div class="col-lg-12">
          <table class="table table-hover table-striped">
            <thead>
              <tr>
                <th>id</th>
                <th><?= s2("product_name") ?></th>
                <th><?= s2("product_original_price") ?></th>
                <th><?= s2("product_custom_price") ?></th>
                <th><?= s2("product_quantity") ?></th>
                <th><?= s2("product_total") ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($sale_details as $sale_detail) {
                ?>
                <tr class="<?= $sale_detail["is_price_edited"]>0 ? "info" : ""?>">
                  <td><?= $sale_detail["product_id"]?></td>
                  <td><?= $sale_detail["product_name"]?></td>
                  <td><?= $sale_detail["original_price"]?></td>
                  <td><?= $sale_detail["custom_price"]?></td>
                  <td><?= $sale_detail["quantity"]?></td>
                  <td><?= $sale_detail["total"]?></td>
                </tr>
                <?php
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="5"><?= s2("product_total") ?></th>
                <th><?= $sale["total"] ?></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
