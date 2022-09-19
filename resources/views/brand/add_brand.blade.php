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
            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleSelectGender">Select Category</label>
                <select name="category_id" onchange="select_subcategory();" class="form-control" id="cat">
                    <option disabled selected value> -- select an option -- </option>
                    @foreach($category as $cat)
                    <option {{ old('category_id') == $cat->id ? "selected" : "" }} value="{{$cat->id}}" >{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
              <label for="exampleSelectGender">Subcategory</label>
              <select name="subcategory_id" class="form-control" id="sub_cat_id">
                  <option disabled selected value> -- select an option -- </option>
                  {{-- @foreach($subcategory as $subcat)
                  <option {{ old('subcategory_id') == $subcat->id ? "selected" : "" }} value="{{$subcat->id}}" >{{$subcat->subcategory_name}}</option>
                  @endforeach --}}
              </select>
              
          </div>
          </div>
        <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>
  <script>
    function select_subcategory(){
       var cat_val=$('#cat').val();
       $.ajax({
           url:"{{route('get_subcat')}}",
           data:{
             'id': cat_val,
             "_token": "{{ csrf_token() }}"  
           },
           type:'post',
           datatype:'json',
           success:function(data){
              $('#sub_cat_id').html("");
              $.each(data.data,function(index,subcategory){
                $('#sub_cat_id').html("");
                  $('#sub_cat_id').append('<option value="'+subcategory.id+'">'+subcategory.subcategory_name+'</option>');
              })
           }
       });
    }
</script>
@endsection