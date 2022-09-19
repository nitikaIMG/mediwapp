@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Category</h4>
       
        <form class="forms-sample" method="POST" action="{{route('subcategory.update',$edit_subcategory['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Subcategory Name</label>
                    <input type="text" name="subcategory_name" class="form-control" id="exampleInputName1"  value="{{$edit_subcategory['subcategory_name']}}" placeholder=" Category Name">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Category</label>
                    <select name="category_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($category as $cat)
                        <option value="{{$cat->id}}" {{ $edit_subcategory['category_id'] == $cat->id ? 'selected' : '' }}>{{$cat->category_name}}</option>
                        @endforeach
                    </select>
                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                   <label for="formFileMultiple" class="form-label">Subcategory Image</label>
                    <input class="form-control" name="subcategory_image" type="file" value="{{$edit_subcategory['subcategory_image']}}" id="formFileMultiple">
                    <img src="{{ asset('public/subcategory_image/'.$edit_subcategory['subcategory_image'])}}" alt="Image Alternative text" title="Image Title" width="50" height="50">
                </div>
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
</div>
@endsection