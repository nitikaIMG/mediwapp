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
                   
                    <label for="formFileMultiple" class="form-label">Brand Logo</label>
                    <input class="form-control" name="brand_image" type="file">
                </div>
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>

@endsection