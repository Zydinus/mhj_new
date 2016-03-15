<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  $product = getProductById($conn, $_GET["id"]);
  $product_sale_prices_1 = getPricesByProductIdLevel($conn, $_GET["id"], "sale", 1);
  $product_sale_prices_2 = getPricesByProductIdLevel($conn, $_GET["id"], "sale", 2);
  $product_sale_prices_3 = getPricesByProductIdLevel($conn, $_GET["id"], "sale", 3);
  $product_buy_prices_1 = getPricesByProductIdLevel($conn, $_GET["id"], "buy", 1);
  $product_buy_prices_2 = getPricesByProductIdLevel($conn, $_GET["id"], "buy", 2);
  $product_buy_prices_3 = getPricesByProductIdLevel($conn, $_GET["id"], "buy", 3);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("title") ?></title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSale1Chart);
      google.charts.setOnLoadCallback(drawSale2Chart);
      google.charts.setOnLoadCallback(drawSale3Chart);
      google.charts.setOnLoadCallback(drawBuy1Chart);
      google.charts.setOnLoadCallback(drawBuy2Chart);
      google.charts.setOnLoadCallback(drawBuy3Chart);

      function drawSale1Chart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Sale price 1'],
          <?php
          foreach ($product_sale_prices_1 as $sale_price) {
            echo "['$sale_price[created_at]',$sale_price[price]],";
          }
          ?>
        ]);

        var options = {
          title: 'Sale Price 1',
          legend: { position: 'right' }
        };

        var saleChart = new google.visualization.LineChart(document.getElementById('sale_1_chart_div'));

        saleChart.draw(data, options);
      }

      function drawSale2Chart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Sale price 2'],
          <?php
          foreach ($product_sale_prices_2 as $sale_price) {
            echo "['$sale_price[created_at]',$sale_price[price]],";
          }
          ?>
        ]);

        var options = {
          title: 'Sale Price 2',
          legend: { position: 'right' }
        };

        var saleChart = new google.visualization.LineChart(document.getElementById('sale_2_chart_div'));

        saleChart.draw(data, options);
      }

      function drawSale3Chart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Sale price 3'],
          <?php
          foreach ($product_sale_prices_3 as $sale_price) {
            echo "['$sale_price[created_at]',$sale_price[price]],";
          }
          ?>
        ]);

        var options = {
          title: 'Sale Price 3',
          legend: { position: 'right' }
        };

        var saleChart = new google.visualization.LineChart(document.getElementById('sale_3_chart_div'));

        saleChart.draw(data, options);
      }

      function drawBuy1Chart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Buy price 1'],
          <?php
          foreach ($product_buy_prices_1 as $buy_price) {
            echo "['$buy_price[created_at]',$buy_price[price]],";
          }
          ?>
        ]);

        var options = {
          title: 'Buy Price 1',
          legend: { position: 'right' }
        };

        var buyChart = new google.visualization.LineChart(document.getElementById('buy_1_chart_div'));

        buyChart.draw(data, options);
      }

      function drawBuy2Chart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Buy price 2'],
          <?php
          foreach ($product_buy_prices_2 as $buy_price) {
            echo "['$buy_price[created_at]',$buy_price[price]],";
          }
          ?>
        ]);

        var options = {
          title: 'Buy Price 2',
          legend: { position: 'right' }
        };

        var buyChart = new google.visualization.LineChart(document.getElementById('buy_2_chart_div'));

        buyChart.draw(data, options);
      }

      function drawBuy3Chart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Buy price 3'],
          <?php
          foreach ($product_buy_prices_3 as $buy_price) {
            echo "['$buy_price[created_at]',$buy_price[price]],";
          }
          ?>
        ]);

        var options = {
          title: 'Buy Price 3',
          legend: { position: 'right' }
        };

        var buyChart = new google.visualization.LineChart(document.getElementById('buy_3_chart_div'));

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
        <h3>Sale Price 1</h3>
        <div id="sale_1_chart_div"></div>
      </div>

      <div class="row">
        <h3>Sale Price 2</h3>
        <div id="sale_2_chart_div"></div>
      </div>

      <div class="row">
        <h3>Sale Price 3</h3>
        <div id="sale_3_chart_div"></div>
      </div>

      <div class="row">
        <h3>Buy Price 1</h3>
        <div id="buy_1_chart_div"></div>
      </div>

      <div class="row">
        <h3>Buy Price 2</h3>
        <div id="buy_2_chart_div"></div>
      </div>

      <div class="row">
        <h3>Buy Price 3</h3>
        <div id="buy_3_chart_div"></div>
      </div>

      <div class="row">

        <?php
        function priceTableGenerator($prices) {
          $output = '<table class="table table-striped table-hover">';
          $output .= '<thead><tr><th>date</th><th>price</th></tr></thead>';
          $output .= '<tbody>';
          foreach ($prices as $price) {
            $output .= '<tr>';
            $output .= "<td>".$price["created_at"]."</td>";
            $output .= "<td>".$price["price"]."</td>";
            $output .= '</tr>';
          }
          $output .= '</tbody>';
          $output .= '</table>';

          return $output;
        }
        ?>

        <div class="col-lg-4">
          <h3>Sale price 1 table</h3>
          <?= priceTableGenerator(array_reverse($product_sale_prices_1)) ?>
        </div>

        <div class="col-lg-4">
          <h3>Sale price 2 table</h3>
          <?= priceTableGenerator(array_reverse($product_sale_prices_2)) ?>
        </div>

        <div class="col-lg-4">
          <h3>Sale price 3 table</h3>
          <?= priceTableGenerator(array_reverse($product_sale_prices_3)) ?>
        </div>

      </div>

      <div class="row">

        <div class="col-lg-4">
          <h3>Buy price 1 table</h3>
          <?= priceTableGenerator(array_reverse($product_buy_prices_1)) ?>
        </div>

        <div class="col-lg-4">
          <h3>Buy price 2 table</h3>
          <?= priceTableGenerator(array_reverse($product_buy_prices_2)) ?>
        </div>

        <div class="col-lg-4">
          <h3>Buy price 3 table</h3>
          <?= priceTableGenerator(array_reverse($product_buy_prices_3)) ?>
        </div>

      </div>
    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
