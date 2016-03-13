<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(100);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("title") ?></title>

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
        <?= s2("sale_system") ?>
      </h1>

      <div class="row">

        <div class="col-lg-8">
          <h3><?= s2("sale_list_today") ?> <?= $d1->format(DateTime::RSS)?></h3>
          <table class="table table-hover table-striped table-condensed">
            <thead>
              <tr>
                <th><?= s2("customer_name") ?></th>
                <th><?= s2("date_time") ?></th>
                <th><?= s2("edit") ?></th>
              </tr>
            </thead>
            <tbody>
              <tr>

              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-lg-4">
          <p class="text-center">
            <a href="sale_form.php" class="btn btn-primary btn-lg">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              <?= s2("sale_new") ?>
            </a>
          </p>
        </div>

      </div>
    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
