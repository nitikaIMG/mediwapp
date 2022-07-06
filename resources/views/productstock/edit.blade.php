@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">EDIT PRODUCT</h4>
       
        <form class="forms-sample" method="POST" action="{{route('productstock.update',$edit_data['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Product Name</label>
                    <input type="text" name="product_name" class="form-control" id="exampleInputName1"  value="{{$edit_data['product_name']}}" placeholder=" Category Name" disabled>
                    
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Product Quantity</label>
                    <input type="text" name="product_quantity" class="form-control"  value="{{$edit_data['product_quantity']}}" id="exampleInputName1"  placeholder=" Product Price">
                </div>
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Update</button>
        </form>
      </div>
    </div>
  </div>

  <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
  <script type="text/javascript">
      $(document).ready(function() {
         $('#ck').ckeditor();
      });
  </script>
@endsection