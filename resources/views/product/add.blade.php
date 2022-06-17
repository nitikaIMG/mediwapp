@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">ADD PRODUCT</h4>
       
        <form class="forms-sample" method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Product Name</label>
                    <input type="text" name="product_name" class="form-control"  value="{{old('product_name')}}" id="exampleInputName1"  placeholder=" Category Name">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Category</label>
                    <select name="category_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option {{ old('category_id') == 1 ? "selected" : "" }} value="1" > 1</option>
                        <option {{ old('category_id') == 2 ? "selected" : "" }} value="2" >2</option>
                        <option {{ old('category_id') == 3 ? "selected" : "" }} value="3" >3</option>
                    </select>
                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Category Type</label>
                    <select name="subcategory_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option {{ old('subcategory_id') == 1 ? "selected" : "" }} value="1" >Food</option>
                        <option {{ old('subcategory_id') == 2 ? "selected" : "" }} value="1" >Cosmetics</option>
                        <option {{ old('subcategory_id') == 3 ? "selected" : "" }} value="1" >Medicine</option>
                    </select>
                    
                </div>
                <div class="form-group col-md-6">
                   
                    <label for="formFileMultiple" class="form-label">Product Image</label>
                    <input class="form-control" name="product_image[]" type="file" id="formFileMultiple" multiple>
                    
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Purchase Price</label>
                    <input type="text" name="purchase_price" class="form-control"  value="{{old('purchase_price')}}" id="exampleInputName1"  placeholder=" Product Price">
                </div>
                    
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Sale Price</label>
                    <input type="text" name="sale_price" class="form-control"  value="{{old('sale_price')}}" id="exampleInputName1"  placeholder=" Sale Price">
                </div>
            </div>
            <div class="row">
                <label for="exampleSelectGender">Product Description</label>
                <textarea class="ckeditor form-control" id="ck" name="prod_desc"></textarea>
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
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