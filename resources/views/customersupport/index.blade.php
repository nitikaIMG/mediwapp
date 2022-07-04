@extends('layouts.home')
@section('content')
@php
$ticket_number="";
if(isset($_GET['ticket_number'])){
  $ticket_number=$_GET['ticket_number'];
}  
@endphp
<div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                  <div class="card-header">
                    Customer Support
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <form>
                        <div class="row">
                          <div class="col">
                            <input type="text" name="ticket_number"  id="ticket_number" value="{{$ticket_number}}" class="form-control" placeholder="Ticket Number">
                          </div>
                         
                        </div>
                        <div class="row">
                          <div class="col-md-3 pt-4">
                            <a class="btn multiple_delete" style="background-color: #f16f23; margin:0%; padding:10px;"><i class="fa fa-trash text-white"></i></a>
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
                <h5 class="card-header">SLIDER</h5>
                <div class="card-body">
                  
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap" id="display_cat" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th><input type="checkbox" name=" chk_box" id="mult_del"></th>
                              <th>Sno.</th>
                              <th>Ticket Number</th>
                              <th>User Name</th>
                              <th>User Phone Number</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                            <th>#D</th>
                              <th>Sno.</th>
                              <th>Ticket Number</th>
                              <th>User Name</th>
                              <th>User Phone Number</th>
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
                var ticket_number=$('#ticket_number').val();
              $.fn.dataTable.ext.errMode = 'none';
                  $('#display_cat').DataTable({
                      'responsive': true,
                      "bFilter" : false,
                "processing": true,
                
                    "serverSide": true,
                      "ajax":{
                               "url": '{{route('displaysupport')}}?ticket_number='+ticket_number,
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
                        { "data": "ticket_number" },
                        { "data": "user_name" },
                        { "data": "user_phonenumber" },
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
                                  url: '{{route('multiple_delete_slider')}}',
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

