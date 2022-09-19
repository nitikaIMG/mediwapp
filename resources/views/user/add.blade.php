@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Add Users</h4>
       
        <form class="forms-sample" method="POST" action="{{route('user.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">First Name</label>
                    <input type="text" name="user_firstname" class="form-control"  value="{{old('user_firstname')}}" id="exampleInputName1"  placeholder=" First Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Last Name</label>
                    <input type="text" name="user_lastname" class="form-control"  value="{{old('user_lastname')}}" id="exampleInputName1"  placeholder=" Last Name">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <div class="form-check">
                        <input class="form-check-input ml-2" type="radio" name="gender" id="gender1"  value="male" checked>
                        <label class="form-check-label" for="gender1">
                          Male
                        </label>
                        <input class="form-check-input ml-2" type="radio" name="gender" value="female"  id="gender2" >
                        <label class="form-check-label" for="gender2">
                          Female
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Dob</label>
                    <input type="date" name="dob" class="form-control"  value="{{old('dob')}}" id="exampleInputName1"  placeholder="Dob">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Email</label>
                    <input type="text" name="user_email" class="form-control"  value="{{old('user_email')}}" id="exampleInputName1"  placeholder=" User Email" automcomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Phone Number</label>
                    <input type="text" name="user_phonenumber" class="form-control"  value="{{old('user_phonenumber')}}" id="exampleInputName1"  placeholder=" User Phonenumber">
                </div>
            </div>
          
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="formFileMultiple" class="form-label">Image</label>
                    <input class="form-control" name="user_image" type="file" id="formFileMultiple">
                </div>
                <div class="form-group col-md-6">
                    <label for="formFileMultiple" class="form-label">password</label>
                    <input class="form-control" name="user_password" type="password" id="formFileMultiple">
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="exampleSelectGender">Address</label>
                <textarea class="form-control"  name="user_address" placeholder="Address"></textarea>
            </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>
@endsection