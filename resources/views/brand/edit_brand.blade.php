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
                    <input type="text" name="brand_name" class="form-control" id="exampleInputName1"  value="{{$edit_brand['brand_name']}}" placeholder="Brand Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="formFileMultiple" class="form-label">Brand Logo</label>
                     <input class="form-control" name="brand_image" type="file" value="{{$edit_brand->brand_image}}" id="formFileMultiple">
                     <img src="{{ asset('public/brand_image/'.$edit_brand->brand_image)}}" alt="Image Alternative text" title="Image Title" width="50" height="50">
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