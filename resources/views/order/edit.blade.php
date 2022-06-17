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
                @php
                    $order_status='';
                    if($edit_data['order_status'] == '1'){
                    $order_status="Create";
                }else if($edit_data['order_status']=='2'){
                    $order_status="Pending";
                }else if($edit_data['order_status']=='3'){
                    $order_status="Dispatch";
                }else if($edit_data['order_status']=='4'){
                    $order_status="Delivered";
                }else if($edit_data['order_status']=='5'){
                    $order_status="Denied";
                }else if($edit_data['order_status']=='6'){
                    $order_status="Cancel";
                }else{
                    $order_status="Return";
                }
                @endphp
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap" id="display_cat" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th>Sno.</th>
                              <th>User</th>
                              <th>User Phone</th>
                              <th>Product</th>
                              <th>Order Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                            <td>1</td>
                            <td>{{ucfirst($user_data['user_firstname'].$user_data['user_lastname'])}}</td>
                            <td>{{$user_data['user_phonenumber']}}</td>
                            <td>{{$edit_data['product']}}</td>
                            <td>{{$order_status}}</td>
                            <td><div class="dropdown" >
                                <button class="btn btn-secondary dropdown-toggle" style="float:right; margin:10px 20px 0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Update Status
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{url('status_update'.'/1')}}">Create</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/2')}}">Pending</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/'.$edit_data['order_id'].'/3')}}">Dispatch</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/4')}}">Delivered</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/5')}}">Denied</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/6')}}">Cancel</a>
                                    <a class="dropdown-item" href="{{url('status_update'.'/7')}}">Return</a>
                                </div>
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

