@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">ADD PRODUCT QUANTITY</h4>
       
        <form class="forms-sample" method="POST" action="{{route('productstock.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Category</label>
                    <select name="product_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                    @foreach($products as $prod)
                        <option value="{{$prod->id}}" >{{$prod->product_name}}</option>
                   @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Product Quantity</label>
                    <input type="text" name="product_quantity" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control"  value="{{old('product_quantity')}}" id="exampleInputName1"  placeholder="Product Quantity">
                </div>
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>
@endsection