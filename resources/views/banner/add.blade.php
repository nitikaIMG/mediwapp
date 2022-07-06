@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">ADD BANNER</h4>
       
        <form class="forms-sample" method="POST" action="{{route('banner.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row" >
              <label for="exampleSelectGender">Banner Type</label>
              <select name="banner_type" class="form-control" id="cat">
                  <option disabled selected value> -- select an option -- </option>
                  <option  value="todays deal" >todays deal</option>
                  <option  value="sale" >sale</option>
              </select>
             
            </div>
            <div class="row pt-4">
                    <label for="exampleInputName1">Banner</label>
                    <input type="file" name="banner" class="form-control"  value="{{old('banner')}}" id="exampleInputName1"  placeholder="banner">
            </div>
            <div class="row pt-4">
              <label for="exampleInputName1">Banner Url</label>
              <input type="text" name="banner_url" class="form-control"  value="{{old('banner_url')}}" id="exampleInputName1"  placeholder="Url">
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>
@endsection