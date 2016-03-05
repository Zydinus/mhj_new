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
          $button .= "data-category='$product[category_id]' >";
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
                    <th>custom_id</th>
                    <th>name</th>
                    <th>short_name</th>
                    <th>unit</th>
                    <th>weight</th>
                    <th>sale price</th>
                    <th>sale price</th>
                    <th>buy price</th>
                    <th>buy price at</th>
                    <th>command</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // $products = getProducts($conn, $product_category["id"]);
                  $products = getProductsWithPrice($conn, $product_category["id"]);

                  foreach ( $products as $product) {
                    echo "<tr>";
                    echo "<td>".$product["custom_id"]."</td>";
                    echo "<td>".$product["name"]."</td>";
                    echo "<td>".$product["short_name"]."</td>";
                    echo "<td>".$product["unit"]."</td>";
                    echo "<td class='text-right'>".$product["weight"]."</td>";
                    echo "<td class='text-right'>".$product["sale_price"]."</td>";
                    echo "<td>".$product["sale_price_updated_at"]."</td>";
                    echo "<td class='text-right'>".$product["buy_price"]."</td>";
                    echo "<td>".$product["buy_price_updated_at"]."</td>";
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
                <label for="inputUnit" class="col-md-3 control-label">Unit</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputUnit" id="inputUnit" placeholder="Unit" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputWeight" class="col-md-3 control-label">Weight</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputWeight" id="inputWeight" step="0.01" placeholder="XX.XX" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputSalePrice" class="col-md-3 control-label">Sale Price</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputSalePrice" id="inputSalePrice" placeholder="xx.xx" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputBuyPrice" class="col-md-3 control-label">Buy Price</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputBuyPrice" id="inputBuyPrice" placeholder="xx.xx" required>
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
    </script>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
