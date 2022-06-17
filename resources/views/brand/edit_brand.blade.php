@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Brand</h4>
       
        <form class="forms-sample" method="POST" action="{{route('brand.update',$edit_brand['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Brand Name</label>
                    <input type="text" name="brand_name" class="form-control" id="exampleInputName1"  value="{{$edit_brand['brand_name']}}" placeholder=" Category Name">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Subcategory</label>
                    <select name="category_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="1" {{ $edit_brand['category_id'] == 1 ? 'selected' : '' }}>PainKiller</option>
                        <option value="2" {{ $edit_brand['category_id'] == 2 ? 'selected' : '' }}>Headache</option>
                        <option value="3" {{ $edit_brand['category_id'] == 3 ? 'selected' : '' }}>Stomach Pain</option>
                    </select>
                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Category Type</label>
                    <select name="subcategory_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="1" {{ $edit_brand['subcategory_id'] == 1 ? 'selected' : '' }}>FOOD</option>
                        <option value="2" {{ $edit_brand['subcategory_id'] == 2 ? 'selected' : '' }}>Health</option>
                        <option value="3" {{ $edit_brand['subcategory_id'] == 3 ? 'selected' : '' }}>Study</option>
                    </select>
                    
                </div>
                <div class="form-group col-md-6">
                   <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                    <input class="form-control" name="brand_image" type="file" value="{{$edit_brand->brand_image}}" id="formFileMultiple">
                    <img src="{{ asset('public/brand_image/'.$edit_brand->brand_image)}}" alt="Image Alternative text" title="Image Title" width="50" height="50">
                </div>
            </div>
          
            {{-- <div class="row">
                <label for="exampleSelectGender">Category Description</label>
                <textarea class="ckeditor form-control" id="ck" name="cat_desc">{{$edit_brand['cat_desc']}}</textarea>
            </div> --}}
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>

  {{-- <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
  <script type="text/javascript">
      $(document).ready(function() {
         $('#ck').ckeditor();
      });
  </script> --}}
@endsection