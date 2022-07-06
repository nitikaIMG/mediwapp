@extends('layouts.home')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>


<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Create Orders</h4>

        <form class="forms-sample" method="POST" action="{{route('order.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Product Name</label>
                             <select id="choices-multiple-remove-button" name="product_name[]" value="{{$user}}" placeholder="Select products" multiple>
                            @foreach($product_name as $u)
                            <option value="{{$u->id}}">{{$u->product_name}}</option>
                                @endforeach
                            </select>
            
                </div>
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1"> Order Amount</label>
                    <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  name="order_amount" class="form-control"  value="{{old(' Order_amount')}}" id="exampleInputName1"  placeholder="  Order Amount">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">User Name</label>
                    <input type="text" name="user_name" class="form-control"  value="{{$user->user_firstname.$user->user_lastname}}" id="exampleInputName1"  placeholder=" User Name" disabled>
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Phone Number</label>
                    <input type="text" name="user_phonenumber" class="form-control"  value="{{$user->user_phonenumber}}" id="exampleInputName1"  placeholder=" User Name" disabled>
                </div>
            </div>
          
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="formFileMultiple" class="form-label">Priscription</label>
                    <input class="form-control" name="priscription" type="file" id="formFileMultiple">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Address</label>
                    <textarea class="form-control"  name="user_address"></textarea>
                </div>
            </div>
            
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>

 <script>
     $(document).ready(function(){
    
    var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
       removeItemButton: true,
       maxItemCount:5,
       searchResultLimit:5,
       renderChoiceLimit:5
     }); 
    
    
});
 </script>
@endsection 