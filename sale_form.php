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

    <style>
      body { padding-bottom: 70px; }
    </style>
  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <div class="container">
      <h1>Sale Form</h1>
      <div class="row">
        <div class="col-lg-3">
          <h3>Search Customer</h3>
          <p>
            <input type="text" id="customerSearch" class="form-control" autocomplete="off">
            <script type="text/javascript">
              var $input = $('#customerSearch');
              var customers = <?= json_encode(getAllCustomersRenamed($conn)) ?>;
              console.log(customers);
              // $input.typeahead({source:[{id: "someId1", name: "Display name 1"},
              //           {id: "someId2", name: "Display name 2"}],
              //           autoSelect: true});
              $input.typeahead({source: customers, autoSelect: true});
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
                $("#contact_name").html(customer.contact_name);
                $("#address_text").html(customer.address_text);
                $("#tel").html(customer.tel);
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
                <dt>customer_name</dt>
                <dd><span id="customer_name"></span></dd>
              </dl>

              <dl class="dl-horizontal">
                <dt>contact_name</dt>
                <dd><span id="contact_name"></span></dd>
              </dl>

              <dl class="dl-horizontal">
                <dt>address_text</dt>
                <dd><span id="address_text"></span></dd>
              </dl>

              <dl class="dl-horizontal">
                <dt>tel</dt>
                <dd><span id="tel"></span></dd>
              </dl>

            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-9">
          <h3>Detail</h3>

          <p>
            <table class="table table-hover table-striped table-bordered" id="tableProduct">
              <thead>
                <tr>
                  <th>id</th>
                  <th>name</th>
                  <th>price</th>
                  <th>quantity</th>
                  <th>total</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4">total</th>
                  <th id="total">
                  </th>
                </tr>
              </tfoot>
            </table>
          </p>

        </div>

        <div class="col-lg-3">
          <h4>product add</h4>
          <input type="text" id="productSearch" class="form-control" autocomplete="off">
          <script type="text/javascript">
            var $inputProduct = $('#productSearch');
            var products = <?= json_encode(getProductsWithPriceRenamed($conn)) ?>;
            console.log(products);
            // $input.typeahead({source:[{id: "someId1", name: "Display name 1"},
            //           {id: "someId2", name: "Display name 2"}],
            //           autoSelect: true});
            $inputProduct.typeahead({source: products, autoSelect: true});
            $inputProduct.change(function() {
              var current = $inputProduct.typeahead("getActive");
              if (current) {
                  // Some item from your model is active!
                  if (current.name == $inputProduct.val()) {
                      // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
                      console.log($inputProduct.val());
                      console.log(current);

                      // fillProduct(current);
                  } else {
                      // This means it is only a partial match, you can either add a new item
                      // or take the active if you don't want new items
                  }
              } else {
                  // Nothing is active so it is a new value (or maybe empty value)
              }
            });

            function fillProduct(product) {
              $("#customer_name").html(customer.customer_name);
              $("#contact_name").html(customer.contact_name);
              $("#address_text").html(customer.address_text);
              $("#tel").html(customer.tel);
            }
          </script>

          <p class="text-center">
            <button type="button" class="btn btn-primary" onclick="javascript:addProductRow()">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              add
            </button>
          </p>

          <script type="text/javascript">
            var rowCounter = 0;
            function addProductRow() {
              var btnDelete = "<button id='btnDelete"+(++rowCounter)+"' onclick='deleteProductRow("+rowCounter+")'>Remove</button>";
              var col1 = "<td>"+btnDelete+" "+rowCounter+"</td>";
              var col2 = "<td>COL1</td>";
              var col3 = "<td>COL1</td>";
              var col4 = "<td>COL1</td>";
              var col5 = "<td>COL1</td>";
              var newRowContent = "<tr>"+col1+col2+col3+col4+col5+"</tr>";
              $("#tableProduct tbody").append(newRowContent);
            }

            function deleteProductRow(id) {
              $("#btnDelete"+id).parents("tr").remove();
            }
          </script>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <p class="text-center">
            <a role="button" class="btn btn-default btn-lg">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
              cancel
            </a>
            <button type="button" class="btn btn-danger btn-lg">
              <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
              save
            </button>
          </p>
        </div>
      </div>
    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
