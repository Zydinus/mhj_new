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
      <h1><?= s2("sale_form") ?></h1>
      <div class="row">
        <div class="col-lg-3">
          <h3><?= s2("search_customer") ?></h3>
          <p>
            <input type="text" id="customerSearch" class="form-control" autocomplete="off" placeholder="<?= s2("customer_name") ?>">
            <script type="text/javascript">
              var currentCustomer;
              var $inputCustomer = $('#customerSearch');
              var customers = <?= json_encode(getAllCustomersRenamed($conn)) ?>;
              console.log(customers);
              $inputCustomer.typeahead({source: customers, autoSelect: true});
              $inputCustomer.change(function() {
                var current = $inputCustomer.typeahead("getActive");
                if (current) {
                  // Some item from your model is active!
                  if (current.name == $inputCustomer.val()) {
                      // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
                      console.log($inputCustomer.val());
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
                $("#c_customer_name").html(customer.customer_name);
                $("#c_contact_name").html(customer.contact_name);
                $("#c_address_text").html(customer.address_text);
                $("#c_tel").html(customer.tel);
                $("#c_type").html(customer.customer_type);

                currentCustomer = customer;
              }
            </script>
          </p>
        </div>

        <div class="col-lg-9">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?= s2("customer") ?></h3>
            </div>
            <div class="panel-body">
              <dl class="dl-horizontal">
                <dt><?= s2("customer_name") ?></dt>
                <dd><span id="c_customer_name"></span></dd>
              </dl>

              <dl class="dl-horizontal">
                <dt><?= s2("contract_name") ?></dt>
                <dd><span id="c_contact_name"></span></dd>
              </dl>

              <dl class="dl-horizontal">
                <dt><?= s2("address") ?></dt>
                <dd><span id="c_address_text"></span></dd>
              </dl>

              <dl class="dl-horizontal">
                <dt><?= s2("tel") ?></dt>
                <dd><span id="c_tel"></span></dd>
              </dl>

              <dl class="dl-horizontal">
                <dt><?= s2("type") ?></dt>
                <dd><span id="c_type"></span></dd>
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
                  <th>#</th>
                  <th>id</th>
                  <th><?= s2("product_name") ?></th>
                  <th><?= s2("product_original_price") ?></th>
                  <th><?= s2("product_custom_price") ?></th>
                  <th><?= s2("product_quantity") ?></th>
                  <th><?= s2("product_total") ?></th>
                </tr>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <tr>
                  <th colspan="6"><?= s2("product_total") ?></th>
                  <th id="total">
                  </th>
                </tr>
              </tfoot>
            </table>
          </p>

        </div>

        <div class="col-lg-3">
          <div class="panel panel-warning">
            <div class="panel-heading">
              <h3 class="panel-title"><?= s2("product_add") ?></h3>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="productSearch"><?= s2("product_shortname") ?></label>
                <input type="text" id="productSearch" class="form-control" autocomplete="off">
              </div>

              <script type="text/javascript">
                var selectedProduct;
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
                    if (currentCustomer === undefined) {
                      $("#customerSearch").focus();
                      alert("Select customer first");
                      return;
                    }
                    // Some item from your model is active!
                    if (current.name == $inputProduct.val()) {
                        // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
                        console.log($inputProduct.val());
                        console.log(current);

                        fillProduct(current);
                    } else {
                        // This means it is only a partial match, you can either add a new item
                        // or take the active if you don't want new items
                    }
                  } else {
                    // Nothing is active so it is a new value (or maybe empty value)
                  }
                });

                function fillProduct(product) {
                  selectedProduct = product;
                  $("#p_product_name").val(product.product_name);
                  switch (currentCustomer.sale_price_level) {
                    case "1":
                      $("#p_price").val(product.sale_price_1);
                      break;
                    case "2":
                      $("#p_price").val(product.sale_price_2);
                      break;
                    case "3":
                      $("#p_price").val(product.sale_price_3);
                      break;
                    default:
                      $("#p_price").val(0);
                  }

                }
              </script>

              <div class="form-group">
                <label for="p_product_name"><?= s2("product_name") ?></label>
                <input type="text" class="form-control" id="p_product_name">
              </div>

              <div class="form-group">
                <label for="p_price"><?= s2("product_price") ?></label>
                <input type="number" class="form-control" id="p_price" step="0.01" min="0">
              </div>

              <div class="form-group">
                <label for="p_quantity"><?= s2("product_quantity") ?></label>
                <input type="number" class="form-control" id="p_quantity" step="0.01" min="0">
              </div>

              <p class="text-center">
                <button type="button" class="btn btn-primary" onclick="javascript:addProductRow()">
                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                  <?= s2("add") ?>
                </button>
              </p>

              <script type="text/javascript">
                var rowCounter = 0;
                function addProductRow() {
                  if ($("#productSearch").val() === "") {
                    return;
                  }
                  if (parseFloat($("#p_quantity").val()) === 0 || $("#p_quantity").val() === "") {
                    return;
                  }

                  var originalPrice = 0;

                  switch (currentCustomer.sale_price_level) {
                    case "1":
                      originalPrice = selectedProduct.sale_price_1;
                      break;
                    case "2":
                      originalPrice = selectedProduct.sale_price_2;
                      break;
                    case "3":
                      originalPrice = selectedProduct.sale_price_3;
                      break;
                  }

                  var btnDelete = "<button id='btnDelete"+(++rowCounter)+"' ";
                  btnDelete += "onclick='deleteProductRow("+rowCounter+")' ";
                  btnDelete += "class='btn btn-danger btn-xs' >";
                  btnDelete += "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
                  btnDelete += "</button>";
                  var col1 = "<td>"+btnDelete+"</td>";
                  var col2 = "<td>"+selectedProduct.id+"</td>";
                  var col3 = "<td>"+selectedProduct.product_name+"</td>";
                  var col4 = "<td>"+originalPrice+"</td>";
                  var col5 = "<td>"+$("#p_price").val()+"</td>";
                  var col6 = "<td>"+$("#p_quantity").val()+"</td>";
                  var col7 = "<td>"+$("#p_price").val()*$("#p_quantity").val()+"</td>";
                  var newRowContent = "<tr>"+col1+col2+col3+col4+col5+col6+col7+"</tr>";
                  $("#tableProduct tbody").append(newRowContent);

                  updateTotal();

                  $("#productSearch").val("");
                  $("#p_product_name").val("");
                  $("#p_price").val("");
                  $("#p_quantity").val("");
                }

                function deleteProductRow(id) {
                  $("#btnDelete"+id).parents("tr").remove();
                  updateTotal();
                }

                function updateTotal() {
                  var productRows = $('#tableProduct').find('tbody').find('tr');
                  var sum = 0;
                  for (var i = 0; i < productRows.length; i++) {
                    var row = $(productRows[i]);
                    var colTotal = row.find('td:eq(6)');
                    sum += parseFloat(colTotal.html());
                  }
                  $("#total").html(sum);
                }
              </script>
            </div>
          </div>


        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <p class="text-center">
            <a href="sale_start.php" role="button" class="btn btn-default btn-lg">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
              <?= s2("cancel") ?>
            </a>
            <button type="button" class="btn btn-danger btn-lg" onclick="javascript:submitSale()">
              <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
              <?= s2("save") ?>
            </button>
          </p>
        </div>

        <script type="text/javascript">
          function submitSale() {
            if ($("#total").html()==="" || parseFloat($("#total").html()) == 0) {
              return;
            }

            var products = [];

            var productRows = $('#tableProduct').find('tbody').find('tr');
            for (var i = 0; i < productRows.length; i++) {
              var row = $(productRows[i]);
              var colId = row.find('td:eq(1)').html();
              var colOriginalPrice = row.find('td:eq(3)').html();
              var colCustomPrice = row.find('td:eq(4)').html();
              var colQuantity = row.find('td:eq(5)').html();

              var product = {};
              product.id = colId
              product.priceLevel = currentCustomer.sale_price_level;
              product.originalPrice = colOriginalPrice;
              product.customPrice = colCustomPrice;
              product.quantity = colQuantity;
              products.push(product);
            }

            var dateToSend = {
              user_id: <?= getUserId()?>,
              customer_id: currentCustomer.id,
              products: products
            };

            console.log(dateToSend);

            // ajax
            // var jqxhr = $.ajax({
            //   method: "POST",
            //   url: "sale_add_process.php",
            //   data: dateToSend
            // })
            // .done(function(data) {
            //   // alert( "success" );
            //   console.log(data);
            //
            //   if (data.result===false) {
            //     return;
            //   }
            //
            //   // update display data
            //   if (type==="sale") {
            //     $("#p"+id+"SalePrice"+level).html(data.price.price);
            //     $("#p"+id+"SaleDate"+level).html(data.price.created_at);
            //   } else if (type==="buy") {
            //     $("#p"+id+"BuyPrice"+level).html(data.price.price);
            //     $("#p"+id+"BuyDate"+level).html(data.price.created_at);
            //   }
            // })
            // .fail(function() {
            //   alert( "error" );
            // });
          }
        </script>
      </div>

    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
