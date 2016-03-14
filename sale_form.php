<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(100);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("title") ?></title>

    <script src="js/bootstrap3-typeahead.min.js"></script>
  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <div class="container">
      <h1>Sale Form</h1>
      <div class="row">
        <div class="col-lg-3">
          <h3>Search Customer</h3>
          <p>
            <input type="text" id="customerSearch" class="form-control">
            <script type="text/javascript">
              var $input = $('#customerSearch');
              var customers = <?= json_encode(getAllCustomersRenamed($conn)) ?>;
              console.log(customers);
              // $input.typeahead({source:[{id: "someId1", name: "Display name 1"},
              //           {id: "someId2", name: "Display name 2"}],
              //           autoSelect: true});
              $input.typeahead({source: customers,
                        autoSelect: true});
              $input.change(function() {
                var current = $input.typeahead("getActive");
                if (current) {
                    // Some item from your model is active!
                    if (current.name == $input.val()) {
                        // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
                        console.log($input.val());
                        console.log(current);

                        fillCustomer(current);
                    } else {
                        // This means it is only a partial match, you can either add a new item
                        // or take the active if you don't want new items
                    }
                } else {
                    // Nothing is active so it is a new value (or maybe empty value)
                }
              });

              function fillCustomer(customer) {
                $("#customer_name").html(customer.customer_name);
              }
            </script>
          </p>
        </div>

        <div class="col-lg-9">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Customer</h3>
            </div>
            <div class="panel-body">
              <dl class="dl-horizontal">
                <dt>customer name</dt>
                <dd><span id="customer_name"></span></dd>
              </dl>
              
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <h3>Detail</h3>



          <p>
            product
          </p>

          <p>
            summary
          </p>

        </div>
      </div>
    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
