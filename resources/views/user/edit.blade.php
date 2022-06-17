@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit User</h4>
       
        <form class="forms-sample" method="POST" action="{{route('user.update',$edit_user['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">First Name</label>
                    <input type="text" name="user_firstname" class="form-control"  value="{{$edit_user['user_firstname']}}" id="exampleInputName1"  placeholder=" User Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Last Name</label>
                    <input type="text" name="user_lastname" class="form-control"  value="{{$edit_user['user_lastname']}}" id="exampleInputName1"  placeholder=" User Name">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Email</label>
                    <input type="text" name="user_email" class="form-control"  value="{{$edit_user['user_email']}}" id="exampleInputName1"  placeholder=" User Name"  disabled>
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Phone Number</label>
                    <input type="text" name="user_phonenumber" class="form-control"  value="{{$edit_user['user_phonenumber']}}" id="exampleInputName1"  placeholder=" User Name">
                </div>
            </div>
          
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="formFileMultiple" class="form-label">Image</label>
                    <input class="form-control" name="user_image" type="file" id="formFileMultiple">
                    <img src="{{ asset('public/user_image/'.$edit_user['user_image'])}}" alt="Image Alternative text" title="Image Title" width="50" height="50">

                </div>
                <div class="form-group col-md-6">
                    <label for="formFileMultiple" class="form-label">password</label>
                    <input class="form-control" value="{{$edit_user['user_password']}}" name="user_password" type="password" id="formFileMultiple">
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="exampleSelectGender">Address</label>
                <textarea class="form-control"  name="user_address">{{$edit_user['user_address']}}</textarea>
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>
@endsection