var app = angular.module('myCart', []);  
app.controller('cartController', function($scope,$http,$timeout,$sce,$interval) {
	var basePath=$('#base_path').val();
	angular.extend($scope,{
		subTotal:0,
		tax_value:0,
		swalMessage:function(msg,text){

		Swal.fire({
		allowOutsideClick: false,
		title:text,
		type:msg,
		icon:msg,
		button:false,
		timer:1500
		});
		},

		getProducts:function(){

			$('#product').val('');
			$('#product_id').val('');
			$('#price').val('');

		   $http({
				method:'POST',
				url:basePath+'/Mycart/getProducts',
				headers:{
					'Content-Type':'application/x-www-form-urlencoded',
					'X-Requested-With':'XMLHttpRequest'
				}
			}).then(function successCallback(response){
				
				if(response.data){
					$scope.Products=response.data.list;
				}
			});

		},

		edit_product:function(index){

		$('#product').val($scope.Products[index].product);
		$('#product_id').val($scope.Products[index].id);
		$('#price').val($scope.Products[index].price);
		$('#discount').val($scope.Products[index].discount);

		},

		add_Products:function(){

		var form_data=$('#addProducts').serialize();
		$http({
			method:'POST',
			url:basePath+'/Mycart/SaveProducts',
			data:form_data,
			headers:{
				'Content-Type':'application/x-www-form-urlencoded',
				'X-Requested-With':'XMLHttpRequest'
			}
		}).then(function successCallback(response){
			
			if(response.data){
				if (response.data.response==1) {
					$scope.swalMessage('success','Success');
				}else if(response.data.response==4){
					$scope.swalMessage('warning','Already exist');
				}
				else{
					$scope.swalMessage('error','Failed to add');
				}

				 $scope.getProducts();
			}
		});

		},

		UpdateStatus:function(id,index){
		if ($('#status'+index).is(':checked')==true) {
		var status=1;
		}else if($('#status'+index).is(':checked')==false){
		var status=0;
		}
		$http({
		method:'POST',
		url:basePath+'/Mycart/UpdateStatus',
		data:'&id='+id+'&status='+status,
		headers:{
		'Content-Type':'application/x-www-form-urlencoded',
		'X-Requested-With':'XMLHttpRequest'
		}
		}).then(function successCallback(response){

		if(response.data){
		 $scope.getProducts();
		if (response.data.response==1) {
		$scope.swalMessage('success','Status changed');
		}else{
		$scope.swalMessage('error','Failed');
		}
		

		}
		});

		},


		delete_product:function(id){
			if (id) {
				if (confirm('Realy want to delete ?')) {
					$http({
						method:'POST',
						url:basePath+'/Mycart/delete_product',
						data:'&id='+id,
						headers:{
						'Content-Type':'application/x-www-form-urlencoded',
						'X-Requested-With':'XMLHttpRequest'
						}
					}).then(function successCallback(response){

						if(response.data){
						$scope.getProducts();

						if (response.data.response==1) {
						$scope.swalMessage('success','Deleted');
						}else{
						$scope.swalMessage('error','Failed');
						}
						}
					});

				}
			}

		},
		get_all_products_details:function(){
		   $http({
				method:'POST',
				url:basePath+'/Mycart/get_all_products_details',
				headers:{
					'Content-Type':'application/x-www-form-urlencoded',
					'X-Requested-With':'XMLHttpRequest'
				}
			}).then(function successCallback(response){
				
				if(response.data){
					// console.log(reponse.data);
					$scope.Products_list=response.data.list;
					$scope.cart_count=response.data.count_cart;
					$scope.invoice=response.data.invoice;
				}
			});

		},

		count_decrease:function(index){
			var active_count=$('#product_count'+index).val();
			var current_count=(Number(active_count)-Number(1));
			if (active_count>1) {
			$('#product_count'+index).val(current_count);
			}
		},
			count_increase:function(index){

			var active_count=$('#product_count'+index).val();
			var current_count=(Number(active_count)+Number(1));
			$('#product_count'+index).val(current_count);
			},


			add_to_cart:function(id,index){

				var quantity=$('#product_count'+index).val();

				$http({
				method:'POST',
				url:basePath+'/Mycart/add_to_cart',
				data:'&product_id='+id+'&quantity='+quantity,
				headers:{
					'Content-Type':'application/x-www-form-urlencoded',
					'X-Requested-With':'XMLHttpRequest'
				}
			}).then(function successCallback(response){
				
				if(response.data){
					if (response.data.response==1) {
						$scope.swalMessage('success','Added to the cart');
						}else{
						$scope.swalMessage('error','Failed');
						}

					$scope.get_all_products_details();
				}
			});


			},

			get_cart_details:function(){
$timeout(function(){

				$http({
				method:'POST',
				url:basePath+'/Mycart/get_cart_details',
				headers:{
					'Content-Type':'application/x-www-form-urlencoded',
					'X-Requested-With':'XMLHttpRequest'
				}
			}).then(function successCallback(response){
				
				if(response.data){

					$scope.cart_details=response.data.cart_details;
					$scope.discount=response.data.discount;
					$scope.tax=response.data.tax;
					$scope.calculate_totals();

					$('#myModal').modal('show');
				}
			});


			},500);

			},

			remove_cart_item:function(id){
			if (id) {
				if (confirm('Realy want to delete ?')) {
					$http({
						method:'POST',
						url:basePath+'/Mycart/remove_cart_item',
						data:'&id='+id,
						headers:{
						'Content-Type':'application/x-www-form-urlencoded',
						'X-Requested-With':'XMLHttpRequest'
						}
					}).then(function successCallback(response){

						if(response.data){
						$scope.get_cart_details();
						$scope.get_all_products_details();
						}
					});

				}
			}

		},

		calculate_totals(){
			$scope.subTotal=0;
			angular.forEach($scope.cart_details,function(value,key){
				$scope.subTotal=($scope.subTotal) + (value.price) * (value.quantity);
			});

			$scope.with_tax=($scope.subTotal) +(($scope.subTotal) * (($scope.tax_value/100)));
			$scope.garnd_total=($scope.with_tax);
			if ($scope.discount_value) {
				$scope.garnd_total=($scope.with_tax-(($scope.with_tax)*($scope.discount_value/100)));
			}

			$('#with_out_tax').text('$ '+$scope.subTotal);
			$('#with_tax').text('$ '+$scope.with_tax);
			$('#grant_total').text('$ '+$scope.garnd_total);

		},

		Place_order:function(){

			var form_data=$('#place_order_id').serialize();

			$http({
						method:'POST',
						url:basePath+'/Mycart/Place_order',
						data:form_data,
						headers:{
						'Content-Type':'application/x-www-form-urlencoded',
						'X-Requested-With':'XMLHttpRequest'
						}
					}).then(function successCallback(response){

						if(response.data){
						$('#myModal').modal('hide');
						$scope.get_all_products_details();
							if (response.data.response==1) {
							$scope.swalMessage('success','Order Placed');
							}else{
							$scope.swalMessage('error','Failed');
							}
						}
					});

				

		},


		getDiscounts:function(){

			$('#discount_id').val('');
			$('#discount').val('');

		   $http({
				method:'POST',
				url:basePath+'/Mycart/getDiscounts',
				headers:{
					'Content-Type':'application/x-www-form-urlencoded',
					'X-Requested-With':'XMLHttpRequest'
				}
			}).then(function successCallback(response){
				
				if(response.data){
					$scope.Discounts=response.data.list;
				}
			});

		},

		edit_discount:function(index){

		$('#discount').val($scope.Discounts[index].discount);
		$('#discount_id').val($scope.Discounts[index].discount_id);
		},

		add_discounts:function(){

		var form_data=$('#adddiscounts').serialize();
		$http({
			method:'POST',
			url:basePath+'/Mycart/Savediscounts',
			data:form_data,
			headers:{
				'Content-Type':'application/x-www-form-urlencoded',
				'X-Requested-With':'XMLHttpRequest'
			}
		}).then(function successCallback(response){
			
			if(response.data){
				if (response.data.response==1) {
					$scope.swalMessage('success','Success');
				}else if(response.data.response==4){
					$scope.swalMessage('warning','Already exist');
				}
				else{
					$scope.swalMessage('error','Failed to add');
				}

				 $scope.getDiscounts();
			}
		});

		},

		delete_discount:function(id){
			if (id) {
				if (confirm('Realy want to delete ?')) {
					$http({
						method:'POST',
						url:basePath+'/Mycart/delete_discount',
						data:'&id='+id,
						headers:{
						'Content-Type':'application/x-www-form-urlencoded',
						'X-Requested-With':'XMLHttpRequest'
						}
					}).then(function successCallback(response){

						if(response.data){
						$scope.getDiscounts();

						if (response.data.response==1) {
						$scope.swalMessage('success','Deleted');
						}else{
						$scope.swalMessage('error','Failed');
						}
						}
					});

				}
			}

		},




});  
});