<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  $product = getProductById($conn, $_GET["id"]);
  $product_sale_prices = getPricesByProductId($conn, $_GET["id"], "sale");
  $product_buy_prices = getPricesByProductId($conn, $_GET["id"], "buy");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("title") ?></title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSaleChart);
      google.charts.setOnLoadCallback(drawBuyChart);

      function drawSaleChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Sale price'],
          <?php
          foreach ($product_sale_prices as $sale_price) {
            echo "['$sale_price[created_at]',$sale_price[price]],";
          }
          ?>
        ]);

        var options = {
          title: 'Sale Price',
          legend: { position: 'right' }
        };

        var saleChart = new google.visualization.LineChart(document.getElementById('sale_chart_div'));

        saleChart.draw(data, options);
      }

      function drawBuyChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Buy price'],
          <?php
          foreach ($product_buy_prices as $buy_price) {
            echo "['$buy_price[created_at]',$buy_price[price]],";
          }
          ?>
        ]);

        var options = {
          title: 'Buy Price',
          legend: { position: 'right' }
        };

        var buyChart = new google.visualization.LineChart(document.getElementById('buy_chart_div'));

        buyChart.draw(data, options);
      }
    </script>

  </head>
  <body>
    <?php include "include/include_body.php" ?>

    <div class="container">
      <h1><?= $product["name"] ?> - <?= $product["category_name"] ?></h1>

      <div class="row">
        <dl class="dl-horizontal">
          <dt>Custom id</dt>
          <dd><?= $product["custom_id"] ?></dd>
        </dl>

        <dl class="dl-horizontal">
          <dt>Name</dt>
          <dd><?= $product["name"] ?></dd>
        </dl>

        <dl class="dl-horizontal">
          <dt>Short name</dt>
          <dd><?= $product["name"] ?></dd>
        </dl>

        <dl class="dl-horizontal">
          <dt>Unit</dt>
          <dd><?= $product["unit"] ?></dd>
        </dl>

        <dl class="dl-horizontal">
          <dt>Weight</dt>
          <dd><?= $product["weight"] ?></dd>
        </dl>
      </div>

      <div class="row">
        <h3>Sale Price</h3>
        <div id="sale_chart_div"></div>
      </div>

      <div class="row">
        <h3>Buy Price</h3>
        <div id="buy_chart_div"></div>
      </div>
    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
