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
                    <label for="exampleInputName1">Category Name</label>
                    <input type="text" name="subcategory_name" class="form-control" id="exampleInputName1"  value="{{$edit_subcategory['subcategory_name']}}" placeholder=" Category Name">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Subcategory</label>
                    <select name="category_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="1" {{ $edit_subcategory['category_id'] == 1 ? 'selected' : '' }}>PainKiller</option>
                        <option value="2" {{ $edit_subcategory['category_id'] == 2 ? 'selected' : '' }}>Headache</option>
                        <option value="3" {{ $edit_subcategory['category_id'] == 3 ? 'selected' : '' }}>Stomach Pain</option>
                    </select>
                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                   <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                    <input class="form-control" name="subcategory_image" type="file" value="{{$edit_subcategory['subcategory_image']}}" id="formFileMultiple">
                    <img src="{{ asset('public/subcategory_image/'.$edit_subcategory['subcategory_image'])}}" alt="Image Alternative text" title="Image Title" width="50" height="50">
                </div>
            </div>
          
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Category Status</label>
                    <select name="status" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="1" {{$edit_subcategory['status']==1 ? 'selected':''}}>Active</option>
                        <option value="0" {{$edit_subcategory['status']==0 ? 'selected':''}}>Deactive</option>
                    </select>
                    
                </div>
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
</div>
@endsection