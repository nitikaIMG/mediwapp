@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">EDIT BANNER</h4>
       
        <form class="forms-sample" method="POST" action="{{route('banner.update',$edit_data['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row" >
              <label for="exampleSelectGender">Banner Type</label>
              <select name="banner_type" class="form-control" id="cat">
                  <option disabled selected value> -- select an option -- </option>
                  <option {{$edit_data['banner_type']=='todays deal'?'selected':''}} value="todays deal" >todays deal</option>
                  <option  {{$edit_data['banner_type']=='sale'?'selected':''}} value="sale" >sale</option>
              </select>
            </div>
            <div class="row">
                    <label for="exampleInputName1">Banner</label>
                    <input type="file" name="banner" class="form-control" id="exampleInputName1"  value="{{$edit_data['banner_url']}}" placeholder=" Slider Name">
            </div>
            <img src="{{asset('public/banner/'.$edit_data['banner'])}}" height="50px" width="50px">

            <div class="row pt-4">
              <label for="exampleInputName1">Slider Title</label>
              <input type="text" name="banner_url" class="form-control"  value="{{$edit_data['banner_url']}}" id="exampleInputName1"  placeholder="Url">
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
</div>
@endsection