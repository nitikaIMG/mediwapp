@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Slider</h4>
       
        <form class="forms-sample" method="POST" action="{{route('slider.update',$edit_slider['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                    <label for="exampleInputName1">Slider Name</label>
                    <input type="text" name="slider_title" class="form-control" id="exampleInputName1"  value="{{$edit_slider['slider_title']}}" placeholder=" Slider Name">
            </div>
            <div class="row mt-4">
                    <label for="exampleSelectGender">Slider Description</label>
                    <textarea class="ckeditor form-control" id="ck" name="slider_content"><?php echo $edit_slider['slider_content']?></textarea>
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
</div>
@endsection