<?php
$oDatabase= new Database();
if(isset($_GET['invoice_id']))
  {
    $invoice_id = $_GET['invoice_id'];
    $sql = "SELECT * FROM invoice WHERE invoice_id='$invoice_id'";
    $result = $oDatabase->fquery($sql);
    $row = $result->fetch_assoc();
    if ($result->num_rows === 0) {
      header('Location: index.php');
   }
  }else {
    header('Location: index.php');
  }
    $customer_id = $row['customer_id'];
    $csql = "SELECT * FROM customer_details WHERE customer_id='$customer_id'";
    $cresult = $oDatabase->fquery($csql);
    $crow = $cresult->fetch_assoc();

    

 ?>

<div class="page-header header-filter" data-parallax="true">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <div class="brand">
            <h1><?php echo "$crow[customer_name]"; ?></h1>
            <h3>Phone: <?php echo "$crow[customer_phone]"; ?> &middot; &middot; &middot; Address: <?php echo "$crow[customer_address]"; ?></h3>
          </div>
        </div>
          <div class="col-md-12">
          <a href="edit_invoice.php?invoice_id=<?php echo $invoice_id; ?>" class="btn btn-primary btn-round float-right" rel="tooltip" title="" data-placement="bottom"   data-original-title="Edit Order Details">
            <i class="material-icons">border_color</i></a>
        </div>
      </div>
    </div>
  </div>
  <form class="" action="form.php" method="post">
  <div class="main main-raised">
    <div class="profile-content">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="brand">
              <h2>Order Details</h2>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <div class="space-50"></div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">calendar_today</i>
                  </span>
                </div>
                <input type="text" class="form-control datetimepicker" name="datetime" value="<?php echo $row['invoice_datetime']; ?>" placeholder="<?php echo $row['invoice_datetime']; ?>" readonly/>
                <input type="hidden" name="hidden" value="place_order">
                <input type="hidden" name="invoice_id" value="<?php echo $row['invoice_id']; ?>">
              </div>
            </div>
            <div class="col-md-5"><div class="space-50"></div><h3>Product Name</h3></div>
            <div class="col-md-2"><div class="space-50"></div><h3>Quantity</h3></div>
            <div class="col-md-2"><div class="space-50"></div><h3>Rate</h3></div>
            <div class="col-md-3"><div class="space-50"></div><h3>Price</h3></div>
            <table width="95%" id="ordertbl">
              <?php 
                $idsql = "SELECT * FROM invoice_details WHERE invoice_id='$invoice_id'"; //invoice details sql
                $idresult = $oDatabase->fquery($idsql);
                while($idrow = $idresult->fetch_assoc()) {
               ?>
              <tr>
                <td width="42%">
                  <div class="col-md-12">
                    <div class="input-group">
                          <?php 
                          $psql = "SELECT * FROM products WHERE product_id ='$idrow[product_id]' ";
                          $presult = $oDatabase->fquery($psql);
                          $prow = $presult->fetch_assoc(); ?>
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">shopping_cart</i>
                        </span>
                      </div>
                      <input type="text" class="form-control" value="<?php echo $prow['product_name']; ?>" placeholder="Quantity" readonly/>
                    </div>
                  </div>
                </td>
                <td width="16%">
                  <div class="col-md-12">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">exposure_plus_1</i>
                        </span>
                      </div>
                      <input type="number" class="form-control" name="quantity[]" value="<?php echo $idrow["product_quantity"]; ?>" placeholder="Quantity" readonly/>
                    </div>
                  </div>
                </td>
                <td width="16%">
                  <div class="col-md-12">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                      </div>
                      <input type="number" class="form-control" value="<?php echo $idrow["product_rate"]; ?>" placeholder="Quantity" readonly/>
                    </div>
                  </div>
                </td>
                <td width="26%">
                  <div class="col-md-12">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                      </div>
                      <input type="number" class="form-control" value="<?php echo $idrow["product_total"]; ?>" placeholder="Quantity" readonly/>
                    </div>
                  </div>
                </td>
              </tr>
              <?php }  ?>
            </table>

            <div class="col-md-3">
              <div class="space-50"></div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Total:
                      <i class="material-icons">attach_money</i>
                  </span>
                </div>
                <input type="number" class="form-control" placeholder="Order Total" value="<?php echo $row['invoice_total']+$row['invoice_discount']; ?>" readonly/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="space-50"></div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Discount
                      <i class="material-icons">money_off</i>
                  </span>
                </div>
                <input type="number" class="form-control" name="discount" placeholder="Discount" value="<?php echo $row['invoice_discount']; ?>" readonly/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="space-50"></div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Payment
                      <i class="material-icons">attach_money</i>
                  </span>
                </div>
                <input type="number" class="form-control" name="payment" placeholder="Payment" value="<?php echo $row['invoice_paid']; ?>" readonly/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="space-50"></div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Due
                      <i class="material-icons">attach_money</i>
                  </span>
                </div>
                <input type="number" class="form-control" name="due" placeholder="Due" value="<?php echo $row['invoice_total']-$row['invoice_paid']; ?>" readonly/>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <div class="space-50"></div>
              <a href="invoice.php?invoice_id=<?php echo $row['invoice_id']; ?>" target="_blank" class="btn btn-primary btn-round">
                <i class="material-icons">print</i> Print
              </a>
            </div>
          </div>
          <div class="space-50"></div>
        </div>
      </div>
    </div>
  </form>
