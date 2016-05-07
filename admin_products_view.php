<?php include "include/include_pre.php" ?>
<?php
  requireSignin(true);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'include/include_head.php'; ?>

    <title><?= s2("product_dashboard"); ?></title>

  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <div class="container">
      <h1>
        <?= s2("product_dashboard"); ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
          <?= s2("product_add"); ?>
        </button>
      </h1>

      <?php
        function makeProductByIdButton($product) {
          $button = "<a role='button' class='btn btn-info' ";
          $button .= "href='admin_product_view.php?id=$product[id]'> ";
          $button .= "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
          $button .= "</a>";

          return $button;
        }

        function makeProductEditButton($product) {
          $button = "<button type='button' class='btn btn-warning' ";
          $button .= "data-toggle='modal' data-target='#editProductModal' ";
          $button .= "data-id='$product[id]' ";
          $button .= "data-customid='$product[custom_id]' ";
          $button .= "data-name='$product[name]' ";
          $button .= "data-shortname='$product[short_name]' ";
          $button .= "data-unit='$product[unit]' ";
          $button .= "data-weight='$product[weight]' ";
          $button .= "data-group1='$product[product_group_1]' ";
          $button .= "data-group2='$product[product_group_2]' ";
          $button .= "data-group3='$product[product_group_3]' ";
          $button .= "data-category='$product[category_id]' >";
          $button .= "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>";
          $button .= "</button>";

          return $button;
        }

        function makePriceEditButton($id, $name, $type, $level) {
          $button = "<button type='button' class='btn btn-warning btn-xs' ";
          $button .= "onclick='javascript:editPrice($id,\"$type\",\"$name\",\"$level\")'>";
          $button .= "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>";
          $button .= "</button>";

          return $button;
        }

        function makeProductDeleteButton($product) {
          $button = "<button type='button' class='btn btn-danger' ";
          $button .= "onclick='javascript:deleteProduct($product[id])'>";
          $button .= "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
          $button .= "</button>";

          return $button;
        }
      ?>

      <?php
      if ( isset($_GET["success"]) ) {
        if ( $_GET["success"]=="true" && $_GET["command"]=="add" ) {
          ?>
          <div class="row">
            <div class="alert alert-success" role="alert">
              Add Product success.
            </div>
          </div>
          <?php
        } elseif ( $_GET["success"]=="true" && $_GET["command"]=="edit" ) {
          ?>
          <div class="row">
            <div class="alert alert-success" role="alert">
              Edit Product success.
            </div>
          </div>
          <?php
        } elseif ( $_GET["success"]=="true" && $_GET["command"]=="delete" ) {
          ?>
          <div class="row">
            <div class="alert alert-success" role="alert">
              Delete Product success.
            </div>
          </div>
          <?php
        }
      }
      ?>

      <div class="row">

        <?php

        $product_categories = getProductCategories($conn, 'all');
        foreach ($product_categories as $product_category) {

        ?>
        <div class="col-lg-12">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?= $product_category["name"]; ?></h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th><?= s2("product_group")?> 1</th>
                    <th><?= s2("product_group")?> 2</th>
                    <th><?= s2("product_group")?> 3</th>
                    <th><?= s2("product_custom_id")?></th>
                    <th><?= s2("product_name")?></th>
                    <th><?= s2("product_shortname")?></th>
                    <th><?= s2("product_unit")?></th>
                    <th><?= s2("product_weight")?></th>
                    <th>sale price 1</th>
                    <th>sale price 2</th>
                    <th>sale price 3</th>
                    <th>buy price 1</th>
                    <th>buy price 2</th>
                    <th>buy price 3</th>
                    <th><?= s2("command")?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // $products = getProducts($conn, $product_category["id"]);
                  $products = getProductsWithPrice($conn, $product_category["id"]);

                  foreach ( $products as $product) {
                    echo "<tr>";
                    echo "<td>".$product["product_group_1"]."</td>";
                    echo "<td>".$product["product_group_2"]."</td>";
                    echo "<td>".$product["product_group_3"]."</td>";
                    echo "<td>".$product["custom_id"]."</td>";
                    echo "<td>".$product["name"]."</td>";
                    echo "<td>".$product["short_name"]."</td>";
                    echo "<td>".$product["unit"]."</td>";
                    echo "<td class='text-right'>".$product["weight"]."</td>";

                    echo "<td class='text-right'><span id=\"p$product[id]SalePrice1\">".$product["sale_price_1"]."</span>";
                    echo " ".makePriceEditButton($product["id"],$product["name"],"sale",1);
                    echo "<br/><span id=\"p$product[id]SaleDate1\">".$product["sale_price_updated_at_1"]."</span></td>";
                    echo "<td class='text-right'><span id=\"p$product[id]SalePrice2\">".$product["sale_price_2"]."</span>";
                    echo " ".makePriceEditButton($product["id"],$product["name"],"sale",2);
                    echo "<br/><span id=\"p$product[id]SaleDate2\">".$product["sale_price_updated_at_2"]."</span></td>";
                    echo "<td class='text-right'><span id=\"p$product[id]SalePrice3\">".$product["sale_price_3"]."</span>";
                    echo " ".makePriceEditButton($product["id"],$product["name"],"sale",3);
                    echo "<br/><span id=\"p$product[id]SaleDate3\">".$product["sale_price_updated_at_3"]."</span></td>";

                    echo "<td class='text-right'><span id=\"p$product[id]BuyPrice1\">".$product["buy_price_1"]."</span>";
                    echo " ".makePriceEditButton($product["id"],$product["name"],"buy",1);
                    echo "<br/><span id=\"p$product[id]BuyDate1\">".$product["buy_price_updated_at_1"]."</span></td>";
                    echo "<td class='text-right'><span id=\"p$product[id]BuyPrice2\">".$product["buy_price_2"]."</span>";
                    echo " ".makePriceEditButton($product["id"],$product["name"],"buy",2);
                    echo "<br/><span id=\"p$product[id]BuyDate2\">".$product["buy_price_updated_at_2"]."</span></td>";
                    echo "<td class='text-right'><span id=\"p$product[id]BuyPrice3\">".$product["buy_price_3"]."</span>";
                    echo " ".makePriceEditButton($product["id"],$product["name"],"buy",3);
                    echo "<br/><span id=\"p$product[id]BuyDate3\">".$product["buy_price_updated_at_3"]."</span></td>";

                    echo "<td>";
                    echo makeProductByIdButton($product)." ";
                    echo makeProductEditButton($product)." ";
                    echo makeProductDeleteButton($product);
                    echo "</td>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php
        }
        ?>





      </div>

    </div>

    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="addProductModalLabel"><?= s2("product_add"); ?></h4>
          </div>
          <div class="modal-body">
            <form action="admin_product_add_process.php" method="post" class="form-horizontal" name="addProduct" id="addProduct">
              <input type="hidden" name="source" value="admin_products_view.php" required>

              <div class="form-group">
                <label for="inputGroup1" class="col-md-3 control-label">Group 1</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputGroup1" id="inputGroup1" placeholder="Group1" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputGroup2" class="col-md-3 control-label">Group 2</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputGroup2" id="inputGroup2" placeholder="Group2" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputGroup3" class="col-md-3 control-label">Group 3</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputGroup3" id="inputGroup3" placeholder="Group3" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputCustomId" class="col-md-3 control-label">Custom id</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputCustomId" id="inputCustomId" placeholder="Custom id" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputName" class="col-md-3 control-label">Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Name" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputShortName" class="col-md-3 control-label">Short name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputShortName" id="inputShortName" placeholder="Short name" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Unit</label>
                <div class="col-md-9">
                  <?php
                  $units = getConstant("units");
                  for ($i=0; $i<count($units); $i++) {
                  ?>
                  <div class="radio">
                    <label>
                      <input type="radio" name="inputUnit" id="inputUnit<?= $i?>" value="<?= $units[$i]?>">
                      <?= $units[$i]?>
                    </label>
                  </div>
                  <?php
                  }
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label for="inputWeight" class="col-md-3 control-label">Weight</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputWeight" id="inputWeight" step="0.0001" placeholder="XX.XX" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputSalePrice1" class="col-md-3 control-label">Sale Price 1</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputSalePrice1" id="inputSalePrice1" step="0.01" placeholder="xx.xx" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputSalePrice2" class="col-md-3 control-label">Sale Price 2</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputSalePrice2" id="inputSalePrice2" step="0.01" placeholder="xx.xx" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputSalePrice3" class="col-md-3 control-label">Sale Price 3</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputSalePrice3" id="inputSalePrice3" step="0.01" placeholder="xx.xx" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputBuyPrice1" class="col-md-3 control-label">Buy Price 1</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputBuyPrice1" id="inputBuyPrice1" step="0.01" placeholder="xx.xx" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputBuyPrice2" class="col-md-3 control-label">Buy Price 2</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputBuyPrice2" id="inputBuyPrice2" step="0.01" placeholder="xx.xx" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputBuyPrice3" class="col-md-3 control-label">Buy Price 3</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputBuyPrice3" id="inputBuyPrice3" step="0.01" placeholder="xx.xx" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Category</label>
                <div class="col-md-9">
                  <?php
                  foreach ($product_categories as $product_category) {
                  ?>
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsCategory" id="optionsCategory<?= $product_category['id']?>" value="<?= $product_category['id']?>">
                      <?= $product_category['name']?>
                    </label>
                  </div>
                  <?php
                  }
                  ?>
                </div>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= s2("cancel")?></button>
            <button type="submit" class="btn btn-info" form="addProduct"><?= s2("add")?></button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="editUserModalLabel"><?= s2("product_edit"); ?></h4>
          </div>
          <div class="modal-body">
            <form action="admin_product_edit_process.php" method="post" class="form-horizontal" name="editProduct" id="editProduct">
              <input type="hidden" name="inputIdEdit" id="inputIdEdit" value="">
              <input type="hidden" name="source" value="admin_products_view.php">

              <div class="form-group">
                <label for="inputGroupEdit1" class="col-md-3 control-label">Group1</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputGroup1" id="inputGroupEdit1" placeholder="Group 1">
                </div>
              </div>

              <div class="form-group">
                <label for="inputGroupEdit2" class="col-md-3 control-label">Group2</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputGroup2" id="inputGroupEdit2" placeholder="Group 2">
                </div>
              </div>

              <div class="form-group">
                <label for="inputGroupEdit3" class="col-md-3 control-label">Group3</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputGroup3" id="inputGroupEdit3" placeholder="Group 3">
                </div>
              </div>

              <div class="form-group">
                <label for="inputCustomIdEdit" class="col-md-3 control-label">Custom id</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputCustomId" id="inputCustomIdEdit" placeholder="Custom id">
                </div>
              </div>

              <div class="form-group">
                <label for="inputName" class="col-md-3 control-label">Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputName" id="inputNameEdit" placeholder="Name">
                </div>
              </div>

              <div class="form-group">
                <label for="inputShortNameEdit" class="col-md-3 control-label">Short Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputShortName" id="inputShortNameEdit" placeholder="Short Name">
                </div>
              </div>

              <div class="form-group">
                <label for="inputUnitEdit" class="col-md-3 control-label">Unit</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputUnit" id="inputUnitEdit" placeholder="Unit">
                </div>
              </div>

              <div class="form-group">
                <label for="inputWeightEdit" class="col-md-3 control-label">Weight</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputWeight" id="inputWeightEdit" step="0.01" placeholder="XX.XX">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Category</label>
                <div class="col-md-9">
                  <?php
                  foreach ($product_categories as $product_category) {
                  ?>
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsCategory" id="optionsCategory<?= $product_category['id']?>Edit" value="<?= $product_category['id']?>">
                      <?= $product_category['name']?>
                    </label>
                  </div>
                  <?php
                  }
                  ?>
                </div>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info" form="editProduct">
              <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Edit
            </button>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      $('#editProductModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var group1 = button.data('group1');
        var group2 = button.data('group2');
        var group3 = button.data('group3');
        var customId = button.data('customid');
        var name = button.data('name');
        var shortName = button.data('shortname');
        var unit = button.data('unit');
        var weight = button.data('weight');
        var category = button.data('category');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('#inputIdEdit').val(id);
        modal.find('#inputGroupEdit1').val(group1);
        modal.find('#inputGroupEdit2').val(group2);
        modal.find('#inputGroupEdit3').val(group3);
        modal.find('#inputCustomIdEdit').val(customId);
        modal.find('#inputNameEdit').val(name);
        modal.find('#inputShortNameEdit').val(shortName);
        modal.find('#inputUnitEdit').val(unit);
        modal.find('#inputWeightEdit').val(weight);
        modal.find('#optionsCategory'+category+'Edit').prop("checked", true);
      });

      function deleteProduct(id) {
        var c = confirm("Delete ?");

        if (c) {
          window.location = "admin_product_delete_process.php?id="+id;
        }

      }

      function editPrice(id, type, productName, level) {
        var price = prompt("New price for "+productName);

        if (price===null || price==="") {
          return;
        }

        if (isNaN(parseFloat(price))) {
          alert(price + " is invalid.");
          return;
        }

        // ajax
        // alert(price);
        var jqxhr = $.ajax({
            method: "POST",
            url: "admin_product_price_add_process.php",
            data: {
              inputProductId: id,
              inputPrice: price,
              inputPriceLevel: level,
              inputPriceType: type
            }
          })
          .done(function(data) {
            // alert( "success" );
            console.log(data);

            if (data.result===false) {
              return;
            }

            // update display data
            if (type==="sale") {
              $("#p"+id+"SalePrice"+level).html(data.price.price);
              $("#p"+id+"SaleDate"+level).html(data.price.created_at);
            } else if (type==="buy") {
              $("#p"+id+"BuyPrice"+level).html(data.price.price);
              $("#p"+id+"BuyDate"+level).html(data.price.created_at);
            }
          })
          .fail(function() {
            alert( "error" );
          });
      }
    </script>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
