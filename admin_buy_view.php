<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<?php
  $buy = getBuyesById($conn, $_GET["id"]);
  $buy_details = getBuyDetailsByBuyId($conn, $_GET["id"]);
  $customer = getCustomerById($conn, $buy["customer_id"]);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("buy_dashboard"); ?></title>

    <script src="js/bootstrap3-typeahead.min.js"></script>

  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <div class="container">
      <h1>
        Buy Info
      </h1>

      <div class="row">
        <!-- Button trigger change customer modal -->
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ChangeCustomerModal">
          Change customer
        </button>

        <!-- change customer modal -->
        <div class="modal fade" id="ChangeCustomerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Customer</h4>
              </div>
              <div class="modal-body">
                <div class="form-group has-warning">
                  <label for="customerSearch">customerSearch</label>
                  <input type="text" id="customerSearch" class="form-control" autocomplete="off">
                </div>

                <script type="text/javascript">
                  var selectedCustomer;
                  var $inputCustomer = $('#customerSearch');
                  var customers = <?= json_encode(getAllCustomersRenamed($conn)) ?>;
                  console.log(customers);
                  // $input.typeahead({source:[{id: "someId1", name: "Display name 1"},
                  //           {id: "someId2", name: "Display name 2"}],
                  //           autoSelect: true});
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
                          selectedCustomer = null;
                      }
                    } else {
                      // Nothing is active so it is a new value (or maybe empty value)
                      selectedCustomer = null;
                    }
                  });

                  function fillCustomer(customer) {
                    selectedCustomer = customer;
                    $("#customerName").html(customer.customer_name);


                  }

                  function transferCustomer() {
                    if (typeof selectedCustomer == 'undefined') {
                      return;
                    }

                    // ajax
                    $("#btnTransferCustomer").prop('disabled', true);

                    var data = {
                      buy_id : "<?= $_GET["id"]?>",
                      new_customer_id : selectedCustomer.id
                    };

                    var jqxhr = $.ajax({
                      method: "POST",
                      url: "admin_buy_transfer_customer.php",
                      data: data
                    })
                    .done(function(data) {
                      // alert( "success" );
                      console.log(data);

                      if (data.result===false) {
                        return;
                      }

                      // refresh
                      location.reload();
                    })
                    .fail(function() {
                      alert( "error" );
                    });
                  }
                </script>

                <dl class="dl-horizontal">
                  <dt>Name</dt>
                  <dd id="customerName"></dd>
                </dl>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnTransferCustomer" onclick="transferCustomer()">Save change</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <dl class="dl-horizontal">
            <dt>Id</dt>
            <dd><?= $customer["id"] ?></dd>
          </dl>

          <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd><?= $customer["name"] ?></dd>
          </dl>

        </div>

        <div class="col-lg-6">
          <dl class="dl-horizontal">
            <dt>date</dt>
            <dd><?= $buy["buy_created_at"] ?></dd>
          </dl>

          <dl class="dl-horizontal">
            <dt>shipping method</dt>
            <dd><?= $buy["shipping_method"] ?></dd>
          </dl>

          <dl class="dl-horizontal">
            <dt>buy_price_level</dt>
            <dd><?= $customer["buy_price_level"] ?></dd>
          </dl>

        </div>

      </div>

      <?php
      function makeDeleteButton($id) {
        $button = "<button type='button' id='btnDelete$id' class='btn btn-danger btn-xs' ";
        $button .= "onclick='javascript:deleteBuyDetail($id)'>";
        $button .= "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
        $button .= "</button>";

        return $button;
      }
      ?>

      <div class="row">
        <h3>
          buy details
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddProduct">
            Add Product
          </button>
        </h3>
        <div class="col-lg-12">
          <table class="table table-hover table-striped">
            <thead>
              <tr>
                <th>id</th>
                <th><?= s2("product_name") ?></th>
                <th><?= s2("product_original_price") ?></th>
                <th><?= s2("product_custom_price") ?></th>
                <th><?= s2("product_quantity") ?></th>
                <th><?= s2("product_quantity") ?> b</th>
                <th><?= s2("discount") ?></th>
                <th><?= s2("product_total") ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($buy_details as $buy_detail) {
                ?>
                <tr class="<?= $buy_detail["is_price_edited"]>0 ? "info" : ""?>">
                  <td>
                    <?= makeDeleteButton($buy_detail["id"]) ?>
                    <?= $buy_detail["id"]?>
                  </td>
                  <td><?= $buy_detail["product_name"]?></td>
                  <td><?= $buy_detail["original_price"]?></td>
                  <td><?= $buy_detail["custom_price"]?></td>
                  <td><?= $buy_detail["quantity"]?></td>
                  <td><?= $buy_detail["quantity_b"]?></td>
                  <td><?= percentFormat($buy_detail["discount"])?></td>
                  <td><?= $buy_detail["total"]?></td>
                </tr>
                <?php
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="7"><?= s2("product_total") ?></th>
                <th><?= $buy["total"] ?></th>
              </tr>

              <tr>
                <th colspan="7"><?= s2("tax_vat") ?></th>
                <th><?= percentFormat($buy["tax_vat"]) ?></th>
              </tr>

              <tr>
                <th colspan="7"><?= s2("product_total") ?></th>
                <th><?= $buy["grand_total"] ?></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <script type="text/javascript">
        function deleteBuyDetail(id) {
          // alert(id);

          var r = confirm("Press a button!");

          if (!r) {
            return;
          }
          $("#btnDelete"+id).prop('disabled', true);

          var jqxhr = $.ajax({
            method: "POST",
            url: "admin_buy_detail_delete_process.php",
            data: {
              id: id
            }
          })
          .done(function(data) {
            // alert( "success" );
            console.log(data);

            if (data.result===false) {
              return;
            }

            // refresh
            location.reload();
          })
          .fail(function() {
            alert( "error" );
          });
        }

        function addBuyDetail() {
          var original_price = 0;
          switch (currentCustomer.buy_price_level) {
            case "1":
              original_price = selectedProduct.buy_price_1;
              break;
            case "2":
              original_price = selectedProduct.buy_price_2;
              break;
            case "3":
              original_price = selectedProduct.buy_price_3;
              break;
            default:
              $("#p_price").val(0);
          }
          var data = {
            buy_id : "<?= $_GET["id"]?>",
            product_id : ""+selectedProduct.id,
            price_level : ""+currentCustomer.buy_price_level,
            original_price : ""+original_price,
            custom_price : $("#p_price").val(),
            quantity : $("#p_quantity").val(),
            quantityB : $("#p_quantity_b").val(),
            discount : $('input[name=p_discount]:checked').val()
          };
          console.log(data);

          $("#addDetail").prop('disabled', true);

          var jqxhr = $.ajax({
            method: "POST",
            url: "admin_buy_detail_add_process.php",
            data: data
          })
          .done(function(data) {
            // alert( "success" );
            console.log(data);

            if (data.result===false) {
              return;
            }

            // refresh
            location.reload();
          })
          .fail(function() {
            alert( "error" );
          });
        }
      </script>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog" aria-labelledby="modalAddProductLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalAddProductLabel">Add product</h4>
          </div>
          <div class="modal-body">
            <div class="form-group has-warning">
              <label for="productSearch"><?= s2("product_shortname") ?></label>
              <input type="text" id="productSearch" class="form-control" autocomplete="off">
            </div>

            <script type="text/javascript">
              var currentCustomer = <?= json_encode($customer) ?>;
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
                  // Some item from your model is active!
                  if (current.name == $inputProduct.val()) {
                      // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
                      console.log($inputProduct.val());
                      console.log(current);

                      fillProduct(current);
                  } else {
                      // This means it is only a partial match, you can either add a new item
                      // or take the active if you don't want new items
                      selectedProduct = null;
                  }
                } else {
                  // Nothing is active so it is a new value (or maybe empty value)
                  selectedProduct = null;
                }
              });

              function fillProduct(product) {
                selectedProduct = product;
                $("#p_product_name").val(product.product_name);
                switch (currentCustomer.buy_price_level) {
                  case "1":
                    $("#p_price").val(product.buy_price_1);
                    break;
                  case "2":
                    $("#p_price").val(product.buy_price_2);
                    break;
                  case "3":
                    $("#p_price").val(product.buy_price_3);
                    break;
                  default:
                    $("#p_price").val(0);
                }

              }
            </script>

            <div class="form-group">
              <label for="p_product_name"><?= s2("product_name") ?></label>
              <input type="text" class="form-control" id="p_product_name" readonly>
            </div>

            <div class="form-group has-warning">
              <label for="p_price"><?= s2("product_price") ?></label>
              <input type="number" class="form-control" id="p_price" step="0.01" min="0">
            </div>

            <div class="form-group has-warning">
              <label for="p_quantity"><?= s2("product_quantity") ?></label>
              <input type="number" class="form-control" id="p_quantity" step="0.01" min="0">
            </div>

            <div class="form-group has-warning">
              <label for="p_quantity_b"><?= s2("product_quantity") ?> b</label>
              <input type="number" class="form-control" id="p_quantity_b" step="0.01" min="0">
            </div>

            <div class="form-group has-warning">
              <label><?= s2("discount") ?></label><br/>
              <label class="radio-inline">
                <input type="radio" name="p_discount" id="inlineRadio0" value="0" checked> 0 %
              </label>
              <?php
              $discount = getConstant("discount");
              for ($i=0; $i<count($discount); $i++) {
              ?>
              <label class="radio-inline">
                <input type="radio" name="p_discount" id="inlineRadio<?= $i+1 ?>" value="<?= $discount[$i] ?>"> <?= percentFormat($discount[$i]) ?>
              </label>
              <?php
              }
              ?>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="addDetail" onclick="javascript:addBuyDetail()">Add</button>
          </div>
        </div>
      </div>
    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
