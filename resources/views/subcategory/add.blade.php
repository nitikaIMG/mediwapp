@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">ADD SUBCATEGORY</h4>
       
        <form class="forms-sample" method="POST" action="{{route('subcategory.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Subcategory Name</label>
                    <input type="text" name="subcategory_name" class="form-control"  value="{{old('subcategory_name')}}" id="exampleInputName1"  placeholder=" Category Name">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Category</label>
                    <select name="category_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($category as $cat)
                        <option value="{{$cat->id}}" >{{$cat->category_name}}</option>
                        @endforeach
                    </select>
                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                   
                    <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                    <input class="form-control" name="subcategory_image" type="file" id="formFileMultiple" multiple>
                    
                </div>
            </div>
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