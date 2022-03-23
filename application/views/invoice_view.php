<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-6"><h1>Details</h1></div>
          <div class="col-sm-6" align="right">
          </div>
        </div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Product(s)</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Invoice</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($invoice_details)) {

                  foreach ($invoice_details as $key=>$data) {?>
                    <tr>
                      <td><?= $key+1; ?></td>
                      <td><?= $data['product']; ?></td>
                      <td><?= $data['quantity']; ?></td>
                      <td>$<?=$data['price'];?></td>
                      <td>
                        <a href="<?php echo site_url('Mycart/invoice/'.$data['order_id']) ?>" target="_blank"><i class="fa fa-download"></i></a>
                      </td>
                    </tr>
                  <?php 
                  } 
                } else {  ?>
                  <td colspan="4">Data Not found</td>
                <?php } ?>
              </tbody>
            </table>
      </div>
    </div>
  </section>
</div>