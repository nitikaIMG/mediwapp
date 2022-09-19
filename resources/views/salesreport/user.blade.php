@extends('layouts.home')
@section('content')
@php
$user_email="";
if(isset($_GET['user_email'])){
  $user_email=$_GET['user_email'];
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
                          <div class="col">
                            <input type="text" name="user_email"  id="user_email" value="{{$user_email}}" class="form-control" placeholder="User Email">
                          </div>
                          <div class="col">
                            <input type="text" name="user_name" id="user_name" value="{{$user_name}}" class="form-control" placeholder="User First name">
                          </div>
                        </div>
                        <div class="row">
                          
                          <div class="text-right pt-4">
                            
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
                              <th>User Email</th>
                              <th>User Orders</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>Sno.</th>
                              <th>User Name</th>
                              <th>User Email</th>
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
                var user_email=$('#user_email').val();
              $.fn.dataTable.ext.errMode = 'none';
                  $('#display_cat').DataTable({
                      'responsive': true,
                      "bFilter" : false,
                "processing": true,
                
                    "serverSide": true,
                      "ajax":{
                               "url": '{{route('display_usersalesreport')}}?user_email='+user_email+'&user_name='+user_name,
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
                        { "data": "user_email" },
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

