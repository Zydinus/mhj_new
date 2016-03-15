<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  $customer = getCustomerById($conn, $_GET["id"]);
  $sales = getSalesWithCustomerId($conn, $_GET["id"]);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("customer_dashboard"); ?></title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSaleChart);

      function drawSaleChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Total'],
          <?php
          foreach ($sales as $sale) {
            echo "['$sale[sale_created_at]',$sale[total]],";
          }
          ?>
        ]);

        var options = {
          title: 'Sale Total',
          legend: { position: 'right' }
        };

        var saleChart = new google.visualization.LineChart(document.getElementById('sale_chart_div'));

        saleChart.draw(data, options);
      }
    </script>

  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <div class="container">
      <h1>
        <?= s2("customer_dashboard"); ?>
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
            <dt>sale_price_level</dt>
            <dd><?= $customer["sale_price_level"] ?></dd>
          </dl>

          <dl class="dl-horizontal">
            <dt>buy_price_level</dt>
            <dd><?= $customer["buy_price_level"] ?></dd>
          </dl>
        </div>

      </div>

      <div class="row">
        <h3>Total Chart</h3>
        <div id="sale_chart_div"></div>
      </div>

      <div class="row">
        <h3>Total Table</h3>
        <div class="col-lg-6">
          <table class="table table-hover table-striped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sales_reversed = array_reverse($sales);
              foreach ($sales_reversed as $sale) {
                ?>
                <tr>
                  <td><?= $sale["sale_created_at"]?></td>
                  <td><?= $sale["total"]?></td>
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
