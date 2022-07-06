@extends('layouts.home')
@section('content')
@php
$product_name="";
if(isset($_GET['product_name'])){
  $product_name=$_GET['product_name'];
}  
@endphp
<div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                  <div class="card-header">
                    Prdouct Quantity Filteration
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <form>
                        <div class="row">
                          <div class="col">
                            <input type="text" name="product_name"  id="product_name" value="{{$product_name}}" class="form-control" placeholder="Product name">
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
                <h5 class="card-header">Prdouct Quantity</h5>
                <div class="card-body">
                  
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap" id="display_cat" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th>Sno.</th>
                              <th>Product Image</th>
                              <th>Product Name</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>Sno.</th>
                              <th>Product Image</th>
                              <th>Product Name</th>
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
                               "url": '{{route('display_product_quantity')}}?product_name='+product_name,
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
                          { "data": "product_name" },
                          { "data": "product_quantity" },
                          { "data": "action" },
                      ],
                      'columnDefs': [ {
                      'targets': [0],
                      'orderable': false,
                  }]
            
                  }); 
            });
            </script>
@endsection

