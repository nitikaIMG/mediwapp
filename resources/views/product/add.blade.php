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
                    <label for="exampleSelectGender">Subcategory</label>
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
                    <label for="exampleInputName1">Price</label>
                    <input type="text" name="price" class="form-control"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  value="{{old('price')}}" id="exampleInputName1"  placeholder=" Product Price">
                </div>
                    
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Opening Quantity</label>
                    <input type="text" name="opening_quantity" class="form-control"  value="{{old('opening_quantity')}}" id="exampleInputName1"  placeholder="Opening Quantity">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Min quantity</label>
                    <input type="text" name="min_quantity" class="form-control"  value="{{old('min_quantity')}}" id="exampleInputName1"  placeholder=" Min Quantity">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Package Type</label>
                    <input type="text" name="package_type" class="form-control"  value="{{old('package_type')}}" id="exampleInputName1"  placeholder=" Package Type">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="formFileMultiple" class="form-label">Brand Image</label>
                    <input class="form-control" name="brand_image" type="file" id="formFileMultiple">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Validate Date</label>
                    <input type="text" name="validate_date" class="form-control"  value="{{old('validate_date')}}" id="exampleInputName1"  placeholder=" Validate Date">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Offer</label>
                    <input type="text" name="offer" class="form-control"  value="{{old('offer')}}" id="exampleInputName1"  placeholder="Offer">
                </div>
                    
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Offer Type</label>
                    <input type="text" name="offer_type" class="form-control"  value="{{old('offer_type')}}" id="exampleInputName1"  placeholder=" Sale Price">
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