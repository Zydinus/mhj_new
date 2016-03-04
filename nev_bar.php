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
      <a class="navbar-brand" href="home.php"><?php echo $s_project_name;?></a>
    </div>

    <div class="navbar-collapse collapse navbar-responsive-collapse">

      <ul class="nav navbar-nav">
        <li><a href="home.php">Home</a></li>
        <li><a href="sale.php">Sale</a></li>
        <li><a href="shipping.php">Shipping</a></li>
        <?php if ( getUserLevel()==0 ) { ?>
        <li><a href="admin.php">Admin</a></li>
        <?php } ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li>
          <?php if ( !isSignin() ) { ?>
            <a href="sign_in_form.php">
              <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
              <?php echo $s_sign_in;?>
            </a>
          <?php } else { ?>
            <a href="control_sign_out.php">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              <?php echo getUserEmail();?> |
              <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
              <?php echo $s_sign_out;?>
            </a>
          <?php } ?>

        </li>
      </ul>

    </div>
  </div>
</div>
