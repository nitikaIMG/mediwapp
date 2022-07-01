@extends('layouts.home')
@section('content')
@php
$product_name="";
if(isset($_GET['product_name'])){
  $product_name=$_GET['product_name'];
}  
$category_id="";
if(isset($_GET['category_id'])){
  $category_id=$_GET['category_id'];
}  
@endphp
<div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                  <div class="card-header">
                    Product Filteration
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <form>
                        <div class="row">
                          <div class="col">
                            <input type="text" name="product_name"  id="product_name" value="{{$product_name}}" class="form-control" placeholder="Product name">
                          </div>
                          <div class="col">
                            <input type="text" name="category_id" id="category_id" value="{{$category_id}}" class="form-control" placeholder="Category name">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3 pt-4">
                            <a class="btn" href="{{route('product.create')}}" style="background-color: #f16f23; margin:0%; padding:10px;"><i class="fa fa-plus text-white"></i></a>
                            <a class="btn delete_all" style="background-color: #f16f23; margin:0%; padding:10px;"><i class="fa fa-trash text-white"></i></a>
                            <a class="btn" href="{{url('create_pdf_product')}}" style="background-color: #f16f23; margin:0%; padding:10px;"><i class="fa fa-file-pdf-o text-white"></i></a>
                            <a class="btn" href="{{url('create_csv_product')}}" style="background-color: #f16f23; margin:0%; padding:10px;"><i class="fa fa-file-excel-o text-white"></i></a>
                          </div>
                          <div class="col-md-6">
                            {{-- blank --}}
                          </div>
                          <div class="col-md-3 text-right pt-4">
                            
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button type="reset" class="btn btn-secondary">reset</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                <h5 class="card-header">Category</h5>
                  
                <div class="card-body">
                  
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap" id="display_cat" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th><input type="checkbox" name=" chk_box" id="mult_del"></th>
                              <th>Sno.</th>
                              <th>Product Image</th>
                              <th>Product Name</th>
                              <th>Category Name</th>
                              <th>Subcategory Name</th>
                              <th>Price</th>
                              <th>Package Type</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                            <th>#D</th>
                              <th>Sno.</th>
                              <th>Product Image</th>
                              <th>Product Name</th>
                              <th>Category Name</th>
                              <th>Subcategory Name</th>
                              <th>Price</th>
                              <th>Package Type</th>
                              <th>Action</th>
                          </tr>
                      </tfoot>
                      <tbody>
                      </tbody>
                  </table>
                  </div>
                </div>
              </div>
            </div>

            <script type="text/javascript">
              $(document).ready(function() {
                let arr=[];
                var category_id=$('#category_id').val();
                var product_name=$('#product_name').val();
              $.fn.dataTable.ext.errMode = 'none';
                  $('#display_cat').DataTable({
                      'responsive': true,
                      "bFilter" : false,
                "processing": true,
                
                    "serverSide": true,
                      "ajax":{
                               "url": '{{route('display_product')}}?product_name='+product_name+'&category_id='+category_id,
                               "dataType": "json",
                               "type": "POST",
                               "data":{ _token: "{{csrf_token()}}"},
                             },
                             "dom": 'lBfrtip',
                             "lengthMenu": [[10, 25, 50,100,1000,10000 ], [10, 25, 50,100,1000,10000]],
                      "buttons": [
                         {
                             extend: 'collection',
                             text: 'Export',
                             buttons: [
                                 'copy',
                                 'excel',
                                 'csv',
                                 'pdf',
                                 'print'
                             ]
                         }
                     ],
                      "columns": [
                          { "data": "multidelete" },
                          { "data": "id" },
                          { "data": "product_image" },
                          { "data": "product_name" },
                          { "data": "category_name" },
                          { "data": "subcategory_name" },
                          { "data": "price" },
                          { "data": "package_type" },
                          { "data": "action" },
                      ],
                      'columnDefs': [ {
                      'targets': [0],
                      'orderable': false,
                  }]
            
                  }); 
            });
            </script>
            <script type="text/javascript">
              $(document).ready(function () {
                  $('#mult_del').on('click', function(e) {
                   if($(this).is(':checked',true))  
                   {
                      $(".sub_chk").prop('checked', true);  
                   } else {  
                      $(".sub_chk").prop('checked',false);  
                   }  
                  });
                  $('.delete_all').on('click', function(e) {
                      var allVals = [];  
                      $(".sub_chk:checked").each(function() {  
                          allVals.push($(this).attr('data-id'));
                      });  
                      if(allVals.length <=0)  
                      {  
                          alert("Please select row.");  
                      }  else {  
                          var check = confirm("Are you sure you want to delete this row?");  
                          if(check == true){  
                              var join_selected_values = allVals.join(",");
                              $.ajax({
                                  url: '{{route('multiple_delete_product')}}',
                                  type: 'GET',
                                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                  data: 'ids='+join_selected_values,
                                  success: function (data) {
                                      if (data['success']) {
                                          $(".sub_chk:checked").each(function() {  
                                              $(this).parents("tr").remove();
                                          });
                                          alert(data['success']);
                                      } else if (data['error']) {
                                          alert(data['error']);
                                      } else {
                                          alert('Whoops Something went wrong!!');
                                      }
                                  },
                                  error: function (data) {
                                      alert(data.responseText);
                                  }
                              });
                            $.each(allVals, function( index, value ) {
                                $('table tr').filter("[data-row-id='" + value + "']").remove();
                            });
                          }  
                      }  
                  });
                 
                  
              });
          </script>
@endsection

