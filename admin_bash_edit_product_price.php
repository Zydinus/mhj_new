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

    <title><?= s2("product_dashboard"); ?></title>

  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <div class="container">

      <?php
      if ( isset($_GET["success"]) ) {
        if ( $_GET["success"]=="true" && $_GET["command"]=="add" ) {
          ?>
          <div class="row">
            <div class="alert alert-success" role="alert">
              Add Product success.
            </div>
          </div>
          <?php
        } elseif ( $_GET["success"]=="true" && $_GET["command"]=="edit" ) {
          ?>
          <div class="row">
            <div class="alert alert-success" role="alert">
              Edit Product success.
            </div>
          </div>
          <?php
        } elseif ( $_GET["success"]=="true" && $_GET["command"]=="delete" ) {
          ?>
          <div class="row">
            <div class="alert alert-success" role="alert">
              Delete Product success.
            </div>
          </div>
          <?php
        }
      }
      ?>

      <div class="row">

        <?php

        $product_categories = getProductCategories($conn, 'all');
        foreach ($product_categories as $product_category) {

        ?>
        <div class="col-lg-12">
          <div class="panel panel-info">
            <div class="panel-heading">
              <!-- <h3 class="panel-title"><?= $product_category["name"]; ?></h3> -->
              <a role="button"
              href="admin_bash_edit_product_price_form.php?catid=<?= $product_category["id"]; ?>"
              class="btn btn-warning" >
                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                <?= s2("edit")?> <?= $product_category["name"]; ?>
              </a>
            </div>
            <div class="panel-body">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th><?= s2("product_group")?></th>
                    <th><?= s2("product_custom_id")?></th>
                    <th><?= s2("product_name")?></th>
                    <th><?= s2("product_shortname")?></th>
                    <th><?= s2("product_unit")?></th>
                    <th><?= s2("product_weight")?></th>
                    <th>sale price 1</th>
                    <th>sale price 2</th>
                    <th>sale price 3</th>
                    <th>buy price 1</th>
                    <th>buy price 2</th>
                    <th>buy price 3</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // $products = getProducts($conn, $product_category["id"]);
                  $products = getProductsWithPrice($conn, $product_category["id"]);

                  foreach ( $products as $product) {
                    echo "<tr>";
                    echo "<td>".$product["product_group"]."</td>";
                    echo "<td>".$product["custom_id"]."</td>";
                    echo "<td>".$product["name"]."</td>";
                    echo "<td>".$product["short_name"]."</td>";
                    echo "<td>".$product["unit"]."</td>";
                    echo "<td class='text-right'>".$product["weight"]."</td>";

                    echo "<td class='text-right'><span id=\"p$product[id]SalePrice1\">".$product["sale_price_1"]."</span>";
                    echo "<br/><span id=\"p$product[id]SaleDate1\">".$product["sale_price_updated_at_1"]."</span></td>";
                    echo "<td class='text-right'><span id=\"p$product[id]SalePrice2\">".$product["sale_price_2"]."</span>";
                    echo "<br/><span id=\"p$product[id]SaleDate2\">".$product["sale_price_updated_at_2"]."</span></td>";
                    echo "<td class='text-right'><span id=\"p$product[id]SalePrice3\">".$product["sale_price_3"]."</span>";
                    echo "<br/><span id=\"p$product[id]SaleDate3\">".$product["sale_price_updated_at_3"]."</span></td>";

                    echo "<td class='text-right'><span id=\"p$product[id]BuyPrice1\">".$product["buy_price_1"]."</span>";
                    echo "<br/><span id=\"p$product[id]BuyDate1\">".$product["buy_price_updated_at_1"]."</span></td>";
                    echo "<td class='text-right'><span id=\"p$product[id]BuyPrice2\">".$product["buy_price_2"]."</span>";
                    echo "<br/><span id=\"p$product[id]BuyDate2\">".$product["buy_price_updated_at_2"]."</span></td>";
                    echo "<td class='text-right'><span id=\"p$product[id]BuyPrice3\">".$product["buy_price_3"]."</span>";
                    echo "<br/><span id=\"p$product[id]BuyDate3\">".$product["buy_price_updated_at_3"]."</span></td>";

                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php
        }
        ?>

      </div>

    </div>



    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
