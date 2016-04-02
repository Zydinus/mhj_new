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

      <?php
      if ( isset($_GET["success"]) ) {
        if ( $_GET["success"]=="true" && $_GET["command"]=="delete" ) {
          ?>
          <div class="row">
            <div class="alert alert-success" role="alert">
              Delete sale success.
            </div>
          </div>
          <?php
        }
      }
      ?>

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
                <th><?= s2("contact_name") ?></th>
                <th><?= s2("date_time") ?></th>
                <th><?= s2("total") ?></th>
                <th><?= s2("by_user") ?></th>
                <th><?= s2("command") ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              function makeInfoButton($sale) {
                $button = "<a role='button' class='btn btn-info btn-sm' ";
                $button .= "href='admin_sale_view.php?id=$sale[sale_id]'>";
                $button .= "<span class='glyphicon glyphicon-info-sign' aria-hidden='true'></span>";
                $button .= "</a>";

                return $button;
              }

              function makeDeleteButton($sale) {
                $button = "<button type='button' class='btn btn-danger btn-sm' ";
                $button .= "onclick='javascript:deleteSale($sale[sale_id])'>";
                $button .= "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
                $button .= "</button>";

                return $button;
              }

              $d1=new DateTime("now");
              $d1->setTimezone(new DateTimeZone('Asia/Bangkok'));

              $begin_date = isset($_GET["begin_date"]) ? $_GET["begin_date"] : $d1->format('Y-m-d');
              $end_date = isset($_GET["end_date"]) ? $_GET["end_date"] : $d1->format('Y-m-d');

              $sales = getSalesWithTotal($conn, $begin_date, $end_date);
              foreach ($sales as $sale) {
                ?>
                <tr class="<?= $sale["is_price_edited"]>0 ? "info": ""?>">
                  <td><?= $sale["customer_name"]?></td>
                  <td><?= $sale["contact_name"]?></td>
                  <td><?= $sale["sale_created_at"]?></td>
                  <td><?= $sale["total"]?></td>
                  <td><?= $sale["user_name"]?></td>
                  <td><?= makeInfoButton($sale) ?> <?= makeDeleteButton($sale) ?></td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>

    <script type="text/javascript">
      function deleteSale(id) {
        var c = confirm("Delete ?");

        if (c) {
          var url = "admin_sale_delete_process.php?id="+id;
          url += "&begin_date=<?= $begin_date ?>";
          url += "&end_date=<?= $end_date ?>";
          window.location = url;
        }
      }
    </script>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
