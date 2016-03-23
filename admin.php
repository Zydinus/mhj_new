<?php include "include/include_pre.php" ?>
<?php
  requireSignin(TRUE);
  requireLevel(0);
  $conn = connect_db($db_server, $db_username, $db_password, $db_dbname);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "include/include_head.php" ?>
  <title>Admin</title>

</head>
<body>
  <?php include "include/include_body.php" ?>
  <div class="container">
    <h1><?= s2("title") ?></h1>
    <?php
      $users = getUsers($conn);
      $normal_users = getUsers($conn,'normal');
      $admin_users = getUsers($conn,'admin');
    ?>

    <div class="row">

      <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Admin Users</h3>
          </div>
          <div class="panel-body">

            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>name</th>
                  <th>username</th>
                  <th>email</th>
                  <th>password</th>
                </tr>
              </thead>
              <tbody>
                <?php
                for ($i=0; $i < count($admin_users); $i++) {
                  echo "<tr>";
                  echo "<td>".$admin_users[$i]["name"]."</td>";
                  echo "<td>".$admin_users[$i]["username"]."</td>";
                  echo "<td>".$admin_users[$i]["email"]."</td>";
                  echo "<td>".$admin_users[$i]["password"]."</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>

          </div>
          <div class="panel-footer text-right">
            <a href="admin_users_view.php" class="btn btn-info">View</a>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Normal Users</h3>
          </div>
          <div class="panel-body">

            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>name</th>
                  <th>username</th>
                  <th>email</th>
                  <th>password</th>
                </tr>
              </thead>
              <tbody>
                <?php
                for ($i=0; $i < count($normal_users); $i++) {
                  echo "<tr>";
                  echo "<td>".$normal_users[$i]["name"]."</td>";
                  echo "<td>".$normal_users[$i]["username"]."</td>";
                  echo "<td>".$normal_users[$i]["email"]."</td>";
                  echo "<td>".$normal_users[$i]["password"]."</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>

          </div>
          <div class="panel-footer text-right">
            <a href="admin_users_view.php" class="btn btn-info">View</a>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Products by Category</h3>
          </div>
          <div class="panel-body">
            <?php
            function makeEditButton($category) {
              $output = "<button type=\"button\" class=\"btn btn-warning btn-sm\" ";
              $output .= "data-toggle=\"modal\" data-target=\"#editCategoryModal\" ";
              $output .= "data-id=\"$category[id]\" data-name=\"$category[name]\" ";
              $output .= "data-custom_id=\"$category[custom_id]\">";
              $output .= "<span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span>";
              $output .= "</button>";

              return $output;
            }

            $categories = getProductCategories($conn);

            foreach ($categories as $category) {
              echo "<p>".makeEditButton($category)." $category[name]: $category[product_count]</p>";
            }
            ?>

          </div>
          <div class="panel-footer text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
              Add Category
            </button>
            <a href="admin_products_view.php" class="btn btn-info">View</a>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- addCategoryModal -->
  <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="addCategoryModalLabel">addCategoryModal</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="addCategory">
            <input type="hidden" name="source" id="source" value="admin.php">

            <div class="form-group">
              <label for="inputShortName" class="col-md-3 control-label">Category Name</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="inputCategoryName" id="inputCategoryName" placeholder="Category Name" required>
              </div>
            </div>

            <div class="form-group">
              <label for="inputShortName" class="col-md-3 control-label">Category Short Name</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="inputCategoryShortName" id="inputCategoryShortName" placeholder="Category Short Name" required>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="btnAddCategory" onclick="javascript:ajaxAddCategory()">Add Category</button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function ajaxAddCategory() {
      $("#btnAddCategory").prop('disabled', true);

      var jqxhr = $.ajax({
        method: "POST",
        url: "admin_category_add_process.php",
        data: {
          source: $("#source").val(),
          inputCategoryName: $("#inputCategoryName").val(),
          inputCategoryShortName: $("#inputCategoryShortName").val()
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

    function ajaxEditCategory() {
      $("#btnEditCategory").prop('disabled', true);

      var jqxhr = $.ajax({
        method: "POST",
        url: "admin_category_edit_process.php",
        data: {
          source: $("#source").val(),
          id: $("#catId").val(),
          inputCategoryName: $("#inputEditCategoryName").val(),
          inputCategoryShortName: $("#inputEditCategoryShortName").val()
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
  </script>

  <!-- editCategoryModal -->
  <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="editCategoryModalLabel">editCategoryModal</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="addCategory">
            <input type="hidden" name="catId" id="catId" value="0">

            <div class="form-group">
              <label for="inputShortName" class="col-md-3 control-label">Category Name</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="inputEditCategoryName" id="inputEditCategoryName" placeholder="Category Name" required>
              </div>
            </div>

            <div class="form-group">
              <label for="inputShortName" class="col-md-3 control-label">Category Short Name</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="inputEditCategoryShortName" id="inputEditCategoryShortName" placeholder="Category Short Name" required>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="btnEditCategory" onclick="javascript:ajaxEditCategory()">Edit Category</button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $('#editCategoryModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var id = button.data('id'); // Extract info from data-* attributes
      var name = button.data('name');
      var custom_id = button.data('custom_id');
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this);
      modal.find('#catId').val(id);
      modal.find('#inputEditCategoryName').val(name);
      modal.find('#inputEditCategoryShortName').val(custom_id);
    });
  </script>

  <!--  nev bar -->
  <?php include "nev_bar.php" ?>
</body>
</html>
