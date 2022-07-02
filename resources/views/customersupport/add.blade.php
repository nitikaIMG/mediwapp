@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">ADD SLIDER</h4>
       
        <form class="forms-sample" method="POST" action="{{route('slider.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                    <label for="exampleInputName1">Slider Title</label>
                    <input type="text" name="slider_title" class="form-control"  value="{{old('slider_title')}}" id="exampleInputName1"  placeholder=" Category Name">
            </div>
            <div class="row">
                <label for="exampleSelectGender">Slider Description</label>
                <textarea class="ckeditor form-control" id="ck" name="slider_content"></textarea>
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