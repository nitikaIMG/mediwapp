@extends('layouts.home')
@section('content')
@php
$order_id="";
if(isset($_GET['order_id'])){
  $order_id=$_GET['order_id'];
}  
$order_status="";
if(isset($_GET['order_status'])){
  $order_status=$_GET['order_status'];
}  
@endphp
<div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                  <div class="card-header">
                    Order Filteration
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <form>
                        <div class="row">
                          <div class="col">
                            <input type="text" name="order_id"  id="order_id" value="{{$order_id}}" class="form-control" placeholder="Subcategory name">
                          </div>
                          <div class="form-group col-md-6">
                            <select name="order_status" class="form-control" id="order_status">
                                <option disabled selected value> -- select  order status -- </option>
                                <option {{ $order_status == 1 ? "selected" : "" }} value="1" >Create</option>
                                <option {{ $order_status == 2 ? "selected" : "" }} value="2" >Pending</option>
                                <option {{ $order_status == 3 ? "selected" : "" }} value="3" >Dispatch</option>
                                <option {{ $order_status == 4 ? "selected" : "" }} value="4" >Delivered</option>
                                <option {{ $order_status == 5 ? "selected" : "" }} value="5" >Denied</option>
                                <option {{ $order_status == 6 ? "selected" : "" }} value="6" >Cancel</option>
                                <option {{ $order_status == 7 ? "selected" : "" }} value="7" >Return</option>
                            </select>
                        </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3 pt-4">
                            <a class="btn" href="{{url('create_pdf_order')}}" style="background-color: #f16f23; margin:0%; padding:10px;"><i class="fa fa-file-pdf-o text-white"></i></a>
                            <a class="btn" href="{{url('create_csv_order')}}" style="background-color: #f16f23; margin:0%; padding:10px;"><i class="fa fa-file-excel-o text-white"></i></a>
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
                <h5 class="card-header">Orders</h5>
                <div class="card-body">
                  
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap" id="display_cat" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th><input type="checkbox" name=" chk_box" id="mult_del"></th>
                              <th>Sno.</th>
                              <th>Order Id</th>
                              <th>Order Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                            <th>#D</th>
                            <th>Sno.</th>
                            <th>Order Id</th>
                            <th>Order Status</th>
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
                var order_id=$('#order_id').val();
                var order_status=$('#order_status').val();
              $.fn.dataTable.ext.errMode = 'none';
                  $('#display_cat').DataTable({
                      'responsive': true,
                      "bFilter" : false,
                "processing": true,
                
                    "serverSide": true,
                      "ajax":{
                               "url": '{{route('display_order')}}?order_status='+order_status+'&order_id='+order_id,
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
                        { "data": "order_id" },
                        { "data": "order_status" },
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
                  $('.multiple_delete').on('click', function(e) {
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
                                  url: '{{route('multiple_delete')}}',
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

