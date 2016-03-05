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
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addProductModal">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
          <?= s2("product_add"); ?>
        </button>
      </h1>

      <?php
        $active_products = getProducts($conn,'active');
        $inactive_products = getProducts($conn,'inactive');

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
          $button .= "data-name='$product[name]' ";
          $button .= "data-type='$product[type]' ";
          $button .= "data-price='$product[price]' ";
          $button .= "data-unit='$product[unit]' ";
          $button .= "data-isactive='$product[is_active]'>";
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

        <div class="col-lg-6">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Active Item</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>name</th>
                    <th>type</th>
                    <th>price</th>
                    <th>unit</th>
                    <th>command</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ( $active_products as $active_product) {
                    echo "<tr>";
                    echo "<td>".$active_product["name"]."</td>";
                    echo "<td>".$active_product["type"]."</td>";
                    echo "<td class='text-right'>".$active_product["price"]."</td>";
                    echo "<td>".$active_product["unit"]."</td>";
                    echo "<td>";
                    echo makeProductByIdButton($active_product)." ";
                    echo makeProductEditButton($active_product)." ";
                    echo makeProductDeleteButton($active_product);
                    echo "</td>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Inactive Item</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>name</th>
                    <th>type</th>
                    <th>price</th>
                    <th>unit</th>
                    <th>command</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ( $inactive_products as $inactive_product) {
                    echo "<tr>";
                    echo "<td>".$inactive_product["name"]."</td>";
                    echo "<td>".$inactive_product["type"]."</td>";
                    echo "<td class='text-right'>".$inactive_product["price"]."</td>";
                    echo "<td>".$inactive_product["unit"]."</td>";
                    echo "<td>";
                    echo makeProductByIdButton($inactive_product)." ";
                    echo makeProductEditButton($inactive_product)." ";
                    echo makeProductDeleteButton($inactive_product);
                    echo "</td>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

    </div>

    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="addProductModalLabel"><?= $s_add_product; ?></h4>
          </div>
          <div class="modal-body">
            <form action="admin_product_add_process.php" method="post" class="form-horizontal" name="addProduct" id="addProduct">
              <input type="hidden" name="source" value="admin_products_view.php">

              <div class="form-group">
                <label for="inputName" class="col-md-2 control-label">Name</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Name">
                </div>
              </div>

              <div class="form-group">
                <label for="inputType" class="col-md-2 control-label">Type</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" name="inputType" id="inputType" placeholder="Type">
                </div>
              </div>

              <div class="form-group">
                <label for="inputPrice" class="col-md-2 control-label">Price</label>
                <div class="col-md-10">
                  <input type="number" class="form-control" name="inputPrice" id="inputPrice" placeholder="xx.xx">
                </div>
              </div>

              <div class="form-group">
                <label for="inputUnit" class="col-md-2 control-label">Unit</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" name="inputUnit" id="inputUnit" placeholder="Unit">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label">Active?</label>
                <div class="col-md-10">
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="optionsActive" id="optionsActiveYes" value="1" checked="">
                      Active
                    </label>
                  </div>
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="optionsActive" id="optionsActiveNo" value="0">
                      Inactive
                    </label>
                  </div>
                </div>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info" form="addProduct">Add</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="editUserModalLabel"><?= $s_edit_product; ?></h4>
          </div>
          <div class="modal-body">
            <form action="admin_product_edit_process.php" method="post" class="form-horizontal" name="editProduct" id="editProduct">
              <input type="hidden" name="inputIdEdit" id="inputIdEdit" value="">
              <input type="hidden" name="source" value="admin_products_view.php">

              <div class="form-group">
                <label for="inputName" class="col-md-2 control-label">Name</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" name="inputName" id="inputNameEdit" placeholder="Name">
                </div>
              </div>

              <div class="form-group">
                <label for="inputType" class="col-md-2 control-label">Type</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" name="inputType" id="inputTypeEdit" placeholder="Type">
                </div>
              </div>

              <div class="form-group">
                <label for="inputPrice" class="col-md-2 control-label">Price</label>
                <div class="col-md-10">
                  <input type="number" class="form-control" name="inputPrice" id="inputPriceEdit" placeholder="xx.xx">
                </div>
              </div>

              <div class="form-group">
                <label for="inputUnit" class="col-md-2 control-label">Unit</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" name="inputUnit" id="inputUnitEdit" placeholder="Unit">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label">Active?</label>
                <div class="col-md-10">
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="optionsActive" id="optionsActiveYesEdit" value="1" checked="">
                      Active
                    </label>
                  </div>
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="optionsActive" id="optionsActiveNoEdit" value="0">
                      Inactive
                    </label>
                  </div>
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
        var name = button.data('name');
        var type = button.data('type');
        var price = button.data('price');
        var unit = button.data('unit');
        var isActive = button.data('isactive');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('#inputIdEdit').val(id);
        modal.find('#inputNameEdit').val(name);
        modal.find('#inputTypeEdit').val(type);
        modal.find('#inputPriceEdit').val(price);
        modal.find('#inputUnitEdit').val(unit);
        if ( isActive===1 ) {
          modal.find('#optionsActiveYesEdit').prop("checked", true);
        } else {
          modal.find('#optionsActiveNoEdit').prop("checked", true);
        }
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
