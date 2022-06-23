@extends('layouts.home')
@section('content')
@php
$product_name="";
if(isset($_GET['product_name'])){
  $product_name=$_GET['product_name'];
}  
$user_name="";
if(isset($_GET['user_name'])){
  $user_name=$_GET['user_name'];
}  
@endphp
<div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                  <div class="card-header">
                    User Sales Report
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <form>
                        <div class="row">
                          {{-- <div class="col">
                            <input type="text" name="product_name"  id="product_name" value="{{$product_name}}" class="form-control" placeholder="Product name">
                          </div> --}}
                          <div class="col">
                            <input type="text" name="user_name" id="user_name" value="{{$user_name}}" class="form-control" placeholder="User First name">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3 pt-4">
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
                <div class="card-body">
                  
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap" id="display_cat" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th>Sno.</th>
                              <th>User Name</th>
                              <th>User Orders</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>Sno.</th>
                              <th>User Name</th>
                              <th>User Orders</th>
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
                var user_name=$('#user_name').val();
                var product_name=$('#product_name').val();
              $.fn.dataTable.ext.errMode = 'none';
                  $('#display_cat').DataTable({
                      'responsive': true,
                      "bFilter" : false,
                "processing": true,
                
                    "serverSide": true,
                      "ajax":{
                               "url": '{{route('display_usersalesreport')}}?product_name='+product_name+'&user_name='+user_name,
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
                        { "data": "id" },
                        { "data": "user_name" },
                        { "data": "cnt" },
                      ],
                      'columnDefs': [ {
                      'targets': [0],
                      'orderable': false,
                  }]
            
                  }); 
            });
            </script>
            
@endsection

