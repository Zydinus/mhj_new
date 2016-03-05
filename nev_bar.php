<?php
function nevbarItem($destination, $glyphicon, $text) {
  return "<li><a href=\"$destination\"><span class=\"glyphicon $glyphicon\" aria-hidden=\"true\"></span> $text</a></li>";
}
?>
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
        <?= nevbarItem("home.php", "glyphicon-home", s2("home")) ?>
        <?= nevbarItem("sale.php", "glyphicon-send", s2("sale_system")) ?>
        <?php if ( getUserLevel()==0 ) { ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Admin <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <?= nevbarItem("admin.php", "glyphicon-cog", "Admin") ?>
            <li role="separator" class="divider"></li>
            <?= nevbarItem("admin_products_view.php", "glyphicon-asterisk", s2("product_dashboard")) ?>
            <?= nevbarItem("admin_users_view.php", "glyphicon-user", s2("user_dashboard")) ?>
          </ul>
        </li>
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
              (<?= getUserUsername() ?>) <?= getUserEmail() ?> |
              <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
              <?= s2("sign_out") ?>
            </a>
          <?php } ?>

        </li>
      </ul>

    </div>
  </div>
</div>
