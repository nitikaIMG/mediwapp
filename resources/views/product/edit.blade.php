@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">EDIT PRODUCT</h4>
       
        <form class="forms-sample" method="POST" action="{{route('product.update',$edit_data['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Product Name</label>
                    <input type="text" name="product_name" class="form-control" id="exampleInputName1"  value="{{$edit_data['product_name']}}" placeholder=" Category Name">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Category</label>
                    <select name="category_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($category as $cat)
                        <option value="{{$cat->id}}" {{$edit_data['category_id']==$cat->id ? 'selected':''}}>{{$cat->category_name}}</option>
                        @endforeach
                    </select>
                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Subcategory</label>
                    <select name="subcategory_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($subcategory as $subcat)
                        <option value="{{$subcat->id}}" {{ $edit_data['subcategory_id'] == $subcat->id ? 'selected' : '' }}>{{$subcat->subcategory_name}}</option>
                        @endforeach
                    </select>
                    
                </div>
                <div class="form-group col-md-6">
                   <label for="formFileMultiple" class="form-label">Product Image</label>
                    <input class="form-control" name="product_image[]" type="file" value="{{$edit_data['product_image']}}" id="formFileMultiple" multiple>
                    @php
                        if(!empty($file)){
                            $data = $file[0];
                            $images=explode(",",$data);
                        }
                    @endphp
                    @foreach ($images as  $img )
                    <img src="{{ asset('public/product_image/'.$img)}}" alt="Image Alternative text" title="Image Title" width="50" height="50">
                    @endforeach
                </div>
            </div>
          
            <div class="row">
                {{-- <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Category Name</label>
                    <select name="category_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($category as $cat)
                        <option value="{{$cat->id}}" {{$edit_data['category_id']==$cat->id ? 'selected':''}}>{{$cat->category_name}}</option>
                        @endforeach
                    </select>
                    
                </div> --}}
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputName1">Price</label>
                        <input type="text" name="price" class="form-control"  value="{{$edit_data['price']}}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  id="exampleInputName1"  placeholder=" Product Price">
                    </div>
                        
                    <div class="form-group col-md-6">
                        <label for="exampleInputName1">Opening Quantity</label>
                        <input type="text" name="opening_quantity" class="form-control"  value="{{$edit_data['opening_quantity']}}" id="exampleInputName1"  placeholder="Opening Quantity">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputName1">Min quantity</label>
                        <input type="text" name="min_quantity" class="form-control"  value="{{$edit_data['min_quantity']}}" id="exampleInputName1"  placeholder=" Min Quantity">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputName1">Package Type</label>
                        <input type="text" name="package_type" class="form-control"  value="{{$edit_data['package_type']}}" id="exampleInputName1"  placeholder=" Package Type">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="formFileMultiple" class="form-label">Brand Image</label>
                        <input class="form-control" name="brand_image" type="file" id="formFileMultiple">
                    <img src="{{ asset('public/brand_image/'.$edit_data['brand_image'])}}" alt="Image Alternative text" title="Image Title" width="50" height="50">

                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputName1">Validate Date</label>
                        <input type="date" name="validate_date" class="form-control"  value="{{$edit_data['validate_date']}}" id="exampleInputName1"  placeholder=" Validate Date">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputName1">Offer</label>
                        <input type="text" name="offer" class="form-control"  value="{{$edit_data['offer']}}" id="exampleInputName1"  placeholder="Offer">
                    </div>
                        
                    <div class="form-group col-md-6">
                        <label for="exampleInputName1">Offer Type</label>
                        <input type="text" name="offer_type" class="form-control"  value="{{$edit_data['offer_type']}}" id="exampleInputName1"  placeholder=" Offer Type">
                    </div>
                </div>
                <label for="exampleSelectGender">Product Description</label>
                <textarea class="ckeditor form-control" id="ck" name="prod_desc">{{$edit_data['prod_desc']}}</textarea>
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