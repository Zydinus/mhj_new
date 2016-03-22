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

    <title><?= s2("customer_dashboard"); ?></title>

  </head>
  <body>
    <?php include "include/include_body.php" ?>
    <div class="container-fluid">
      <h1>
        <?= s2("customer_dashboard"); ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCustomerModal">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
          <?= s2("customer_add"); ?>
        </button>
      </h1>

      <?php
        function makeCustomerByIdButton($customer) {
          $button = "<a role='button' class='btn btn-info' ";
          $button .= "href='admin_customer_view.php?id=$customer[id]'> ";
          $button .= "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
          $button .= "</a>";

          return $button;
        }

        function makeCustomerDeleteButton($customer) {
          $button = "<button type='button' class='btn btn-danger' ";
          $button .= "onclick='javascript:deleteCustomer($customer[id])'>";
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
              Add Customer success.
            </div>
          </div>
          <?php
        } elseif ( $_GET["success"]=="true" && $_GET["command"]=="edit" ) {
          ?>
          <div class="row">
            <div class="alert alert-success" role="alert">
              Edit Customer success.
            </div>
          </div>
          <?php
        } elseif ( $_GET["success"]=="true" && $_GET["command"]=="delete" ) {
          ?>
          <div class="row">
            <div class="alert alert-success" role="alert">
              Delete Customer success.
            </div>
          </div>
          <?php
        }
      }
      ?>

      <div class="row">

        <h3><?= s2("customer_all") ?></h3>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>id</th>
              <th>short_name</th>
              <th>title</th>
              <th>name</th>
              <th>first_contact_date</th>
              <th>contact_name</th>
              <th>tax_vat</th>
              <th>address_text</th>
              <th>region</th>
              <th>province</th>
              <th>district</th>
              <th>zip</th>
              <th>distance</th>
              <th>tel</th>
              <th>fax</th>
              <th>mobile_tel</th>
              <th>email</th>
              <th>customer_type</th>
              <th>payment</th>
              <th>credit</th>
              <th>sale price level</th>
              <th>buy price level</th>
              <th>command</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $customers = getAllCustomers($conn);
            foreach ( $customers as $customer) {
              echo "<tr>";
              echo "<td>$customer[id]</td>";
              echo "<td>$customer[short_name]</td>";
              echo "<td>$customer[title]</td>";
              echo "<td>$customer[name]</td>";
              echo "<td>$customer[first_contact_date]</td>";
              echo "<td>$customer[contact_name]</td>";
              echo "<td>$customer[tax_vat]</td>";
              echo "<td>$customer[address_text]</td>";
              echo "<td>$customer[region]</td>";
              echo "<td>$customer[province]</td>";
              echo "<td>$customer[district]</td>";
              echo "<td>$customer[zip]</td>";
              echo "<td>$customer[distance]</td>";
              echo "<td>$customer[tel]</td>";
              echo "<td>$customer[fax]</td>";
              echo "<td>$customer[mobile_tel]</td>";
              echo "<td>$customer[email]</td>";
              echo "<td>$customer[customer_type]</td>";
              echo "<td>$customer[payment]</td>";
              echo "<td>$customer[credit]</td>";
              echo "<td>$customer[sale_price_level]</td>";
              echo "<td>$customer[buy_price_level]</td>";
              echo "<td>";
              echo makeCustomerByIdButton($customer)." ";
              // echo makeCustomerEditButton($product)." ";
              echo makeCustomerDeleteButton($customer);
              echo "</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>

      </div>

    </div>

    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="addCustomerModalLabel"><?= s2("customer_add"); ?></h4>
          </div>
          <div class="modal-body">
            <form action="admin_customer_add_process.php" method="post" class="form-horizontal" name="addCustomer" id="addCustomer">
              <input type="hidden" name="source" value="admin_customers_view.php" required>

              <div class="form-group">
                <label for="inputShortName" class="col-md-3 control-label">Short Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputShortName" id="inputShortName" placeholder="Short Name" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputTitle" class="col-md-3 control-label">Title</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputTitle" id="inputTitle" placeholder="Title">
                </div>
              </div>

              <div class="form-group">
                <label for="inputName" class="col-md-3 control-label">Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Name" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputFirstContactDate" class="col-md-3 control-label">First Contact Date</label>
                <div class="col-md-9">
                  <input type="date" class="form-control" name="inputFirstContactDate" id="inputFirstContactDate">
                </div>
              </div>

              <div class="form-group">
                <label for="inputContactName" class="col-md-3 control-label">Contact Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputContactName" id="inputContactName" placeholder="Contact Name" required>
                </div>
              </div>

              <div class="form-group">
                <label for="inputTaxVat" class="col-md-3 control-label">Tax Vat</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputTaxVat" id="inputTaxVat" step="0.01">
                  <p class="help-block"><?= s2("tax_vat_help_text");?></p>
                </div>
              </div>

              <div class="form-group">
                <label for="inputAddress" class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                  <textarea type="text" class="form-control" name="inputAddress" id="inputAddress" rows="4"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="inputProvince" class="col-md-3 control-label">Province</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputProvince" id="inputProvince" placeholder="Province">
                </div>
              </div>

              <datalist id="regions">
                <?php
                $regions = getConstant("regions");
                foreach ($regions as $region) {
                  echo "<option value=\"$region\">$region</option>";
                }
                ?>
              </datalist>

              <div class="form-group">
                <label for="inputRegion" class="col-md-3 control-label">Region</label>
                <div class="col-md-9">
                  <input list="regions" class="form-control" name="inputRegion" id="inputRegion">
                </div>
              </div>

              <div class="form-group">
                <label for="inputDistrict" class="col-md-3 control-label">District</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputDistrict" id="inputDistrict" placeholder="District">
                </div>
              </div>

              <div class="form-group">
                <label for="inputZip" class="col-md-3 control-label">Zip</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputZip" id="inputZip" placeholder="Zip">
                </div>
              </div>

              <div class="form-group">
                <label for="inputDistance" class="col-md-3 control-label">Distance</label>
                <div class="col-md-9">
                  <input type="number" class="form-control" name="inputDistance" id="inputDistance" step="0.01" placeholder="xx.xx">
                </div>
              </div>

              <div class="form-group">
                <label for="inputTel" class="col-md-3 control-label">Tel</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputTel" id="inputTel" placeholder="xx-xxxx-xxxx">
                </div>
              </div>

              <div class="form-group">
                <label for="inputFax" class="col-md-3 control-label">Fax</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputFax" id="inputFax" placeholder="xx-xxxx-xxxx">
                </div>
              </div>

              <div class="form-group">
                <label for="inputMobileTel" class="col-md-3 control-label">Mobile Tel</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="inputMobileTel" id="inputMobileTel" placeholder="xx-xxxx-xxxx">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail" class="col-md-3 control-label">Email</label>
                <div class="col-md-9">
                  <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="xxx@yyy.zzz">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Customer Type</label>
                <div class="col-md-9">
                  <?php
                  $customer_types = getConstant("customer_types");
                  for ($i=0; $i<count($customer_types); $i++) {
                  ?>
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsCustomerType" id="optionsCustomerType<?= $i?>" value="<?= $customer_types[$i]?>">
                      <?= $customer_types[$i]?>
                    </label>
                  </div>
                  <?php
                  }
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Payment</label>
                <div class="col-md-9">
                  <?php
                  $payments = getConstant("payments");
                  for ($i=0; $i<count($payments); $i++) {
                  ?>
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsPayment" id="optionsPayment<?= $i?>" value="<?= $payments[$i]?>">
                      <?= $payments[$i]?>
                    </label>
                  </div>
                  <?php
                  }
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Credit</label>
                <div class="col-md-9">
                  <?php
                  $credits = getConstant("credits");
                  for ($i=0; $i<count($credits); $i++) {
                  ?>
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsCredit" id="optionsCredit<?= $i?>" value="<?= $credits[$i]?>">
                      <?= $credits[$i]?>
                    </label>
                  </div>
                  <?php
                  }
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Sale price level</label>
                <div class="col-md-9">
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="optionsSalePriceLevel" id="optionsSalePriceLevel1" value="1" checked="">
                      1
                    </label>
                  </div>
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="optionsSalePriceLevel" id="optionsSalePriceLevel2" value="2">
                      2
                    </label>
                  </div>
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="optionsSalePriceLevel" id="optionsSalePriceLevel3" value="3">
                      3
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Buy price level</label>
                <div class="col-md-9">
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="optionsBuyPriceLevel" id="optionsBuyPriceLevel1" value="1" checked="">
                      1
                    </label>
                  </div>
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="optionsBuyPriceLevel" id="optionsBuyPriceLevel2" value="2">
                      2
                    </label>
                  </div>
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="optionsBuyPriceLevel" id="optionsBuyPriceLevel3" value="3">
                      3
                    </label>
                  </div>
                </div>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= s2("cancel")?></button>
            <button type="submit" class="btn btn-info" form="addCustomer"><?= s2("add")?></button>
          </div>
        </div>
      </div>
    </div>

    <!--  nev bar -->
    <?php include "nev_bar.php" ?>

  </body>
</html>
