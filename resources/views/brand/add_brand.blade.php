@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">ADD BRAND</h4>
       
        <form class="forms-sample" method="POST" action="{{route('brand.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Brand Name</label>
                    <input type="text" name="brand_name" class="form-control"  value="{{old('brand_name')}}" id="exampleInputName1"  placeholder=" Brand Name">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Category</label>
                    <select name="category_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option {{ old('category_id') == 1 ? "selected" : "" }} value="1" >Test</option>
                        <option {{ old('category_id') == 2 ? "selected" : "" }} value="2" >Nitesh</option>
                        <option {{ old('category_id') == 3 ? "selected" : "" }} value="3" >Demo</option>
                    </select>
                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Subcategory</label>
                    <select name="subcategory_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option {{ old('subcategory_id') == 1 ? "selected" : "" }} value="1" >Food</option>
                        <option {{ old('subcategory_id') == 2 ? "selected" : "" }} value="1" >Cosmetics</option>
                        <option {{ old('subcategory_id') == 3 ? "selected" : "" }} value="1" >Medicine</option>
                    </select>
                    
                </div>
                <div class="form-group col-md-6">
                   
                    <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                    <input class="form-control" name="brand_image" type="file" id="formFileMultiple">
                    
                </div>
            </div>
          {{--ckeditor-}}
            {{-- <div class="row">
                <label for="exampleSelectGender">Category Description</label>
                <textarea class="ckeditor form-control" id="ck" name="cat_desc"></textarea>
            </div> --}}
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>
{{----ck editor -}}
  {{-- <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
  <script type="text/javascript">
      $(document).ready(function() {
         $('#ck').ckeditor();
      });
  </script> --}}
@endsection