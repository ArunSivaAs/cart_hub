<div class="content-wrapper" ng-app="myCart" ng-controller="cartController" ng-init="getDiscounts()">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Discounts</h1>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="row">      
       <div class="col-sm-12">
            <form id="adddiscounts">
              <div class="row form-group">
               
               <input type="hidden" name="discount_id" id="discount_id">    
                <div class="col-sm-4">
                  <label>discount:<span style="color: red">*</span></label>
                  <input type="text" name="discount" id="discount" class="form-control" placeholder="discount name">
                  <span style="color: red" id="valid_discount"></span>
                </div>
                <div class="col-sm-2">
                   <button type="button" style="margin-top: 2em;" id="save" class="btn btn-success form-control" ng-click="add_discounts()" >Submit</button>
                </div>
                
              </div>
              </form>
        </div>
    </div>
  </section>


  <section class="content">
    <div class="row" style="margin-top: 1em;">
      <div class="col-sm-12">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Discount</th>
                  <td>action</td>
                </tr>
              </thead>
              <tbody ng-if="Discounts.length>0">
                    <tr ng-repeat="values in Discounts track by $index">
                      <td>{{$index+1}}</td>
                      <td>{{values.discount}} %</td>
                      <td>
                        <button type="button" class="btn btn-primary" ng-click="edit_discount($index)"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger" ng-click="delete_discount(values.discount_id)"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
              </tbody>
            </table>
      </div>
    </div>
  </section>
</div>