<div ng-app="myCart" ng-controller="cartController" ng-init="get_all_products_details()">
<div class="content-wrapper"  >
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><b>Product Hub</b></h1>
        </div>

        <div class="col-sm-6" align="right">
          <a class="btn btn-warning" ng-if="cart_count>0"  ng-click="get_cart_details()">
            <i class="fa fa-shopping-cart"></i>
            <span style="color: red;font-size: 1.5em; font-weight: bold;" id="cart_count">{{cart_count}}</span>
          </a>

          <a class="btn btn-primary" href="<?php echo base_url('Mycart/invoice_details'); ?>" ng-if="invoice>0">
            <i class="fa fa-eye"></i> Invoice
            <span style="color: red;font-size: 1.5em; font-weight: bold;">{{invoice}}</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="col-md-10 col-sm-10">
        <div class="row">          
          <div class="card"  ng-repeat="products in Products_list track by $index" style="margin-left: 20px;">
            <img src="<?php echo base_url('dist/img/photo1.png')?>" alt="Avatar" style="width:100%">
              <div class="container">
                <h4><b>{{products.product}}</b></h4> 
                 <p>${{products.price}}</p> 
                   <div style="padding: 0px 58px;">
                    <button ng-click="count_decrease($index)">-</button>
                   <input type="text" name="product_count"  id="product_count{{$index}}" readonly style="width: 38px;text-align: center;" value="1">
                   <button  ng-click="count_increase($index)">+</button>                   
                   </div>
                   <div style="padding: 11px 10px;">
                   <button class="btn btn-warning" ng-click="add_to_cart(products.id,$index)">Add To Cart</button>
                   <button class="btn btn-success">Buy Now</button>
                   </div>                 
              </div>
          </div>
        </div>
        </div>

      </div>
    </div>
  </section>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <h3 class="modal-title">Order Details</h3>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
         <section class="content">
    <div class="row">
      <div class="col-sm-12">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Product</th>
                  <th>Unit Price </th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="data in cart_details track by $index">
                  <td>{{$index+1}}</td>
                  <td>{{data.product}}</td>
                  <td>{{data.price}}</td>
                  <td>{{data.quantity}}</td>
                  <td>{{data.quantity * data.price}}</td>
                  <td style="color: red;text-align: center;"><i class="fa fa-times" ng-click="remove_cart_item(data.cart_id)"></i></td>
                </tr>
                
              </tbody>
            </table>
<form id="place_order_id">
            <div class="row" id="total_price">
        <div class="col-sm-12">
              <div class="col-sm-8">
                <table class="table table-bordered table-striped">

                  <tr>
                    <th>Tax<span ></span>:</th>
                    <td>
                      <select  class="form-control" id="tax" ng-model="tax_value" name="tax" ng-change="calculate_totals()" >
                        <option value="0" ng-selected="true">0%</option>
                        <option value="{{tax_det.tax}}" ng-repeat="tax_det in tax" ng-selected="tax_det.tax==1" ng-selected="tax_det.tax==5">{{tax_det.tax}}%</option>
                      </select>  
                    </td>
                  </tr>
                  
                  <tr>
                    <th>Sub Total(With out tax):</th>
                    <td>
                      <span class="with_out_tax" id="with_out_tax"></span> 
                      <input type="hidden" name="with_out_tax" value="{{subTotal}}">
                    </td>
                  </tr>

                  <tr>
                    <th>Sub Total(With tax):</th>
                    <td>
                      <span id="with_tax"></span>
                      <input type="hidden" name="with_tax" value="{{with_tax}}">
                    </td>
                  </tr>
                  <tr>
                    <th>Discount<span ></span>:</th>
                    <td>
                      <select class="form-control" id="discount" name="discount" ng-model="discount_value" ng-change="calculate_totals()" >
                        <option value="0" ng-selected="true">0%</option>
                        <option value="{{dis.discount}}" ng-repeat="dis in discount">{{dis.discount}}%</option>
                      </select>  
                    </td>
                  </tr>

                  <tr>
                    <th>Grand Total:</th>
                    <td>
                      <span class="grant" style="color: green; font-weight: bold;font-size: 1.5em;" id="grant_total"></span>
                      <input type="hidden" name="grand_total" value="{{garnd_total}}">
                    </td>
                  </tr>
                </table>
              </div>
        </div>
      </div>

      <div class="row" id="total_price1">
        <div class="col-sm-12 " style="margin-left: 41%;">
          <button type="button" class="btn btn-warning" class="close" data-dismiss="modal" >Back</button>
          <button type="button" class="btn btn-primary" style="background-color: #fb641b; " ng-click="Place_order()">PLACE ORDER</button>
          <button type="button" class="btn btn-success" id="invoice" style="display: none;">Generate Invoice</button>
        </div>
      </div>
    </form>
      </div>
    </div>
    
  </section>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>
</div>
