@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">ADD CATEGORY</h4>
       
        <form class="forms-sample" method="POST" action="{{route('category.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Category Name</label>
                    <input type="text" name="category_name" class="form-control"  value="{{old('category_name')}}" id="exampleInputName1"  placeholder=" Category Name">
                </div>
                {{-- <div class="form-group col-md-6">
                    <label for="formFileMultiple" class="form-label">Banner</label>
                    <input class="form-control" name="banner" type="file" id="formFileMultiple">
                </div> --}}
                <div class="form-group col-md-6">
                    <label for="formFileMultiple" class="form-label">Category Image</label>
                    <input class="form-control" name="category_image" type="file" id="formFileMultiple">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Meta Keyword</label>
                    <input type="text" name="meta_keyword" class="form-control"  value="{{old('meta_keyword')}}" id="exampleInputName1"  placeholder=" Meta Keyword">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control"  value="{{old('meta_title')}}" id="exampleInputName1"  placeholder=" Meta Title">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Meta Description</label>
                    <input type="text" name="meta_description" class="form-control"  value="{{old('meta_description')}}" id="exampleInputName1"  placeholder=" Meta Description">
                </div>
                <div class="row">
                    <label for="exampleSelectGender">Category Description</label>
                    <textarea class="ckeditor form-control" id="ck" name="cat_desc"></textarea>
                </div>
            </div>
            
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
       $('#ck').ckeditor();
    });
</script>
@endsection