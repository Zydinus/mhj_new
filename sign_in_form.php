<?php include "include/include_pre.php" ?>
<?php
  requireSignin(false);
  // requireLevel(100);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'include/include_head.php'; ?>

  <title><?= s2("title") ?></title>
</head>
<body>
  <div class="container">

    <div class="row">

      <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-info">
          <div class="panel-body">

            <form class="form-horizontal" method="post" action="control_sign_in.php">
              <fieldset>
                <legend>
                  <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                  <?= s2("title") ?>
                </legend>
                <div class="form-group">
                  <label for="inputToken" class="col-md-3 control-label"><?= s2("email") ?> <?= s2("or") ?> <?= s2("username") ?></label>

                  <div class="col-md-9">
                    <input type="text" class="form-control" id="inputToken" name="inputToken" placeholder="<?= s2("email") ?> <?= s2("or") ?> <?= s2("username") ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword" class="col-md-3 control-label"><?= s2("password") ?></label>

                  <div class="col-md-9">
                    <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="<?= s2("password") ?>">

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-10 col-md-offset-2 text-right">
                    <button type="button" class="btn btn-default"><?= s2("cancel") ?></button>
                    <button type="submit" class="btn btn-primary"><?= s2("sign_in") ?></button>
                  </div>
                </div>
              </fieldset>
            </form>

          </div>
        </div>
      </div>

    </div>

  </div>

  <!--  nev bar -->
  <?php include "nev_bar.php" ?>
</body>
</html>
