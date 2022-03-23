<div class="content-wrapper" ng-app="myCart" ng-controller="cartController" ng-init="getProducts()">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Products</h1>

        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="row">      
       <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <form id="addProducts">
              <div class="row form-group">
               
               <input type="hidden" name="product_id" id="product_id">    
                <div class="col-sm-4">
                  <label>Product Name:<span style="color: red">*</span></label>
                  <input type="text" name="product" id="product" class="form-control" placeholder="product name">
                  <span style="color: red" id="valid_product"></span>
                </div>
                <div class="col-sm-3">
                  <label>Price (in $):<span style="color: red">*</span></label>
                  <input type="number" name="price" id="price" class="form-control" placeholder="price">
                  <span style="color: red" id="valid_price"></span>
                </div>
                <div class="col-sm-3">
                  <label>Discount:<span style="color: red">*</span></label>
                  <select class="form-control" id="discount" name="discount">
                    <option selected disabled>Select</option>
                    <option ng-repeat="discount_det in discount" value="{{discount_det.discount}}">{{discount_det.discount}}%</option>
                  </select>
                  <span style="color: red" id="valid_price"></span>
                </div>
                <div class="col-sm-2">
                   <button type="button" style="margin-top: 2em;" id="save" class="btn btn-success form-control" ng-click="add_Products()" >Submit</button>
                </div>
                
              </div>
              </form>
            </div>
          </div>
        </div>
    </div>
  </section>


  <section class="content">
    <div class="row" style="margin-top: 1em;">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th>Staus</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody ng-if="Products.length>0">
                    <tr ng-repeat="values in Products track by $index">
                      <td>{{$index+1}}</td>
                      <td>{{values.product}}</td>
                      <td>{{values.price}}</td>
                      <td>{{values.discount}}%</td>
                      <td>
                      <label class="switch">
                      <input type="checkbox" ng-checked="values.status==1" id="status{{$index}}" ng-model="status" ng-click="UpdateStatus(values.id,$index)">
                      <span class="slider round"></span>
                      </label>
                      </td>
                      <td>
                        <button type="button" class="btn btn-primary" ng-click="edit_product($index)"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger" ng-click="delete_product(values.id)"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>