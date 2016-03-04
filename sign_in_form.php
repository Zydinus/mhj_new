<?php include "include/include_pre.php" ?>
<?php
  requireSignin(false);
  // requireLevel(100);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'include/include_head.php'; ?>

  <title><?php echo $s_title; ?></title>
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
                  <?php echo $s_title; ?>
                </legend>
                <div class="form-group">
                  <label for="inputEmail" class="col-md-2 control-label"><?php echo $s_email; ?></label>

                  <div class="col-md-10">
                    <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword" class="col-md-2 control-label"><?php echo $s_password; ?></label>

                  <div class="col-md-10">
                    <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-10 col-md-offset-2 text-right">
                    <button type="button" class="btn btn-default"><?php echo $s_cancel; ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo $s_sign_in; ?></button>
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
