@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">EDIT PRODUCT</h4>
       
        <form class="forms-sample" method="POST" action="{{route('product.update',$edit_data['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Product Name</label>
                    <input type="text" name="product_name" class="form-control" id="exampleInputName1"  value="{{$edit_data['product_name']}}" placeholder=" Category Name">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Category</label>
                    <select name="category_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="1" {{ $edit_data['category_id'] == 1 ? 'selected' : '' }}>PainKiller</option>
                        <option value="2" {{ $edit_data['category_id'] == 2 ? 'selected' : '' }}>Headache</option>
                        <option value="3" {{ $edit_data['category_id'] == 3 ? 'selected' : '' }}>Stomach Pain</option>
                    </select>
                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Subcategory</label>
                    <select name="subcategory_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="1" {{ $edit_data['subcategory_id'] == 1 ? 'selected' : '' }}>FOOD</option>
                        <option value="2" {{ $edit_data['subcategory_id'] == 2 ? 'selected' : '' }}>Health</option>
                        <option value="3" {{ $edit_data['subcategory_id'] == 3 ? 'selected' : '' }}>Study</option>
                    </select>
                    
                </div>
                <div class="form-group col-md-6">
                   <label for="formFileMultiple" class="form-label">Product Image</label>
                    <input class="form-control" name="product_image[]" type="file" value="{{$edit_data['product_image']}}" id="formFileMultiple" multiple>
                    @php
                        if(!empty($file)){
                            $data = $file[0];
                            $images=explode(",",$data);
                        }
                    @endphp
                    @foreach ($images as  $img )
                    <img src="{{ asset('public/product_image/'.$img)}}" alt="Image Alternative text" title="Image Title" width="50" height="50">
                    @endforeach
                </div>
            </div>
          
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Category Name</label>
                    <select name="category_id" class="form-control" id="exampleSelectGender">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="1" {{$edit_data['category_id']==1 ? 'selected':''}}>Active</option>
                        <option value="0" {{$edit_data['category_id']==0 ? 'selected':''}}>Deactive</option>
                    </select>
                    
                </div>
                <label for="exampleSelectGender">Category Description</label>
                <textarea class="ckeditor form-control" id="ck" name="prod_desc">{{$edit_data['prod_desc']}}</textarea>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Purchase Price</label>
                    <input type="text" name="purchase_price" class="form-control"  value="{{$edit_data['purchase_price']}}" id="exampleInputName1"  placeholder=" Product Price">
                </div>
                    
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Sale Price</label>
                    <input type="text" name="sale_price" class="form-control"  value="{{$edit_data['sale_price']}}" id="exampleInputName1"  placeholder=" Sale Price">
                </div>
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