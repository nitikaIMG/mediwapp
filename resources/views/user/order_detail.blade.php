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
                <h5 class="card-header">Orders</h5>
                <div class="card-body">
                    <div class="mb-4" style="float:right;">
                        <a href="{{url('create_order/'.$user_order_data[0]->id)}}" class="btn btn-primary">Create Order</a>
                    </div>
                @php
                 $order_status='';
                 $payment_status='';
                 $i=1;
                @endphp
                  @foreach($user_order_data as $ord_status)
                    @php
                    if($ord_status == '1'){
                    $order_status="Create";
                    }else if($ord_status=='2'){
                        $order_status="Pending";
                    }else if($ord_status=='3'){
                        $order_status="Dispatch";
                    }else if($ord_status=='4'){
                        $order_status="Delivered";
                    }else if($ord_status=='5'){
                        $order_status="Denied";
                    }else if($ord_status=='6'){
                        $order_status="Cancel";
                    }else{
                        $order_status="Return";
                    }

                    if($ord_status->payment_status =='1'){
                        $payment_status="Successful";
                    }else{
                        $payment_status="Pending";
                    }
                    @endphp
                  @endforeach
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap" id="display_cat" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th>Sno.</th>
                              <th>Product</th>
                              <th>Order Status</th>
                              <th>Pyament Status</th>
                              <th style="width:20px !important">Action</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$user_order_data[0]['product']}}</td>
                            <td>{{$order_status}}</td>
                            <td>{{$payment_status}}</td>
                            <td><div class="dropdown" >
                                <button class="btn btn-secondary dropdown-toggle" style="float:right; margin:10px 20px 0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Update Status
                                </button>
                                @foreach($user_order_data as $ord_status)
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{url('status_update'.'/'.$ord_status->order_id.'/1')}}">Create</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/'.$ord_status->order_id.'/2')}}">Pending</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/'.$ord_status->order_id.'/3')}}">Dispatch</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/'.$ord_status->order_id.'/4')}}">Delivered</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/'.$ord_status->order_id.'/5')}}">Denied</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/'.$ord_status->order_id.'/6')}}">Cancel</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/'.$ord_status->order_id.'/7')}}">Return</a>
                                </div>
                                @endforeach

                              </div>
                            </td>
                          </tr>
                      </tfoot>
                      <tbody>
                      </tbody>
                  </table>

                  </div>
                </div>
              </div>
            </div>

@endsection

