@extends('layouts.home')
@section('content')
@php
$brand_name="";
if(isset($_GET['brand_name'])){
  $brand_name=$_GET['brand_name'];
}  
$category_id="";
if(isset($_GET['category_id'])){
  $category_id=$_GET['category_id'];
}  
@endphp
<div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                  <div class="card-header">
                    Brand Filteration
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <form>
                        <div class="row">
                          <div class="col">
                            <input type="text" name="brand_name"  id="brand_name" value="{{$brand_name}}" class="form-control" placeholder="Brand name">
                          </div>
                          <div class="col">
                            <input type="text" name="category_id" id="category_id" value="{{$category_id}}" class="form-control" placeholder="Category name">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col text-right pt-4">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button type="reset" class="btn btn-secondary">reset</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                <h5 class="card-header">Brand</h5>
                  <div class="dropdown" >
                    <button class="btn btn-secondary dropdown-toggle" style="float:right; margin:10px 20px 0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      ADD-DELETE
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('brand.create')}}">ADD</a>
                      <a class="dropdown-item brand_multiple_delete" href="#">MULTIPLE DELETE</a>
                    </div>
                  </div>
                <div class="card-body">
                  
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap" id="display_cat" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                            <th><input type="checkbox" name=" chk_box" id="mult_del"></th>
                            <th>Sno.</th>
                            <th>Brand Image</th>
                            <th>Brand Name</th>
                            <th>Category name</th>
                            <th>Subcategory name</th>
                            <th>Action</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                            <th></th>
                            <th>Sno.</th>
                            <th>Brand Image</th>
                            <th>Brand Name</th>
                            <th>Category name</th>
                            <th>Subcategory name</th>
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
                var brand_name=$('#brand_name').val();
                var category_id=$('#category_id').val();
              $.fn.dataTable.ext.errMode = 'none';
                  $('#display_cat').DataTable({
                      'responsive': true,
                      "bFilter" : false,
                "processing": true,
                
                    "serverSide": true,
                      "ajax":{
                               "url": '{{route('display_brand')}}?brand_name='+brand_name+'&category_id='+category_id,
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
                          { "data": "brand_image" },
                          { "data": "brand_name" },
                          { "data": "category_id" },
                          { "data": "subcategory_id" },
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
                  $('.brand_multiple_delete').on('click', function(e) {
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
                                  url: '{{route('brand_multiple_delete')}}',
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

