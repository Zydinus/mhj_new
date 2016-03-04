<div class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">

    <div class="navbar-header">
      <button type="button"
      class="navbar-toggle"
      data-toggle="collapse"
      data-target=".navbar-responsive-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php"><?= s2("project_name")?></a>
    </div>

    <div class="navbar-collapse collapse navbar-responsive-collapse">

      <ul class="nav navbar-nav">
        <li><a href="home.php"><?= s2("home")?></a></li>
        <li><a href="sale.php"><?= s2("sale_system")?></a></li>
        <?php if ( getUserLevel()==0 ) { ?>
        <li><a href="admin.php">Admin</a></li>
        <?php } ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li>
          <?php if ( !isSignin() ) { ?>
            <a href="sign_in_form.php">
              <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
              <?= s2("sign_in")?>
            </a>
          <?php } else { ?>
            <a href="control_sign_out.php">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              <?= getUserEmail() ?> |
              <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
              <?= s2("sign_out") ?>
            </a>
          <?php } ?>

        </li>
      </ul>

    </div>
  </div>
</div>
