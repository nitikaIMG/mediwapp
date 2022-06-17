@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Category</h4>
       
        <form class="forms-sample" method="POST" action="{{route('category.update',$edit_data['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Category Name</label>
                    <input type="text" name="category_name" class="form-control" id="exampleInputName1"  value="{{$edit_data['category_name']}}" placeholder=" Category Name">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Subcategory</label>
                    <select name="subcategory_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="1" {{ $edit_data['subcategory_id'] == 1 ? 'selected' : '' }}>PainKiller</option>
                        <option value="2" {{ $edit_data['subcategory_id'] == 2 ? 'selected' : '' }}>Headache</option>
                        <option value="3" {{ $edit_data['subcategory_id'] == 3 ? 'selected' : '' }}>Stomach Pain</option>
                    </select>
                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Category Type</label>
                    <select name="category_type" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="1" {{ $edit_data['category_type'] == 1 ? 'selected' : '' }}>FOOD</option>
                        <option value="2" {{ $edit_data['category_type'] == 2 ? 'selected' : '' }}>Health</option>
                        <option value="3" {{ $edit_data['category_type'] == 3 ? 'selected' : '' }}>Study</option>
                    </select>
                    
                </div>
                <div class="form-group col-md-6">
                   <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                    <input class="form-control" name="category_image[]" type="file" value="{{$edit_data['category_image']}}" id="formFileMultiple" multiple>
                    @php
                        if(!empty($file)){
                            $data = $file[0];
                            $images=explode(",",$data);
                        }
                    @endphp
                    @foreach ($images as  $img )
                    <img src="{{ asset('public/category_image/'.$img)}}" alt="Image Alternative text" title="Image Title" width="50" height="50">
                    @endforeach
                </div>
            </div>
          
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Category Status</label>
                    <select name="cat_status" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="1" {{$edit_data['cat_status']==1 ? 'selected':''}}>Active</option>
                        <option value="0" {{$edit_data['cat_status']==0 ? 'selected':''}}>Deactive</option>
                    </select>
                    
                </div>
                <label for="exampleSelectGender">Category Description</label>
                <textarea class="ckeditor form-control" id="ck" name="cat_desc">{{$edit_data['cat_desc']}}</textarea>
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