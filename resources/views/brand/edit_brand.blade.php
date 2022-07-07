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
                <label for="exampleSelectGender">Brand Name</label>
                <input type="text" name="brand_name" class="form-control"  value="{{$edit_brand['brand_name']}}" id="exampleInputName1"  placeholder=" Brand Name">
                
            </div>
                <div class="form-group col-md-6">
                    <label for="formFileMultiple" class="form-label">Brand Logo</label>
                     <input class="form-control" name="brand_image" type="file" value="{{$edit_brand->brand_image}}" id="formFileMultiple">
                     <img src="{{ asset('public/brand_image/'.$edit_brand->brand_image)}}" alt="Image Alternative text" title="Image Title" width="50" height="50">
                 </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleSelectGender">Select Category</label>
                <select name="category_id" onchange="select_subcategory();" class="form-control" id="cat">
                    <option disabled selected value> -- select an option -- </option>
                    @foreach($category as $cat)
                    <option value="{{$cat->id}}" {{$edit_brand['category_id']==$cat->id ? 'selected':''}}>{{$cat->category_name}}</option>
                    @endforeach
                </select>
               
            </div>
            <div class="form-group col-md-6">
              <label for="sub_cat_id">Select Subcategory</label>
              <select name="subcategory_id" class="form-control" id="sub_cat_id">
                  <option disabled selected value> -- select an option -- </option>
                  <option value="{{$edit_brand['subcategory_id']}}" {{ $edit_brand['subcategory_id'] == $edit_brand['subcategory_id'] ? 'selected' : '' }}>{{$edit_brand['subcategory_name']}}</option>
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
              if(data.data.length==0){
                $('#sub_cat_id').empty()
              }else{
                $.each(data.data,function(index,subcategory){
                $('#sub_cat_id').empty()
                $('#sub_cat_id').append('<option value="'+subcategory.id+'">'+subcategory.subcategory_name+'</option>');
               })
              }
              
           }
       });
    }

    function select_brand(){
      var cat_val=$('#cat').val();
      var sub_cat_val = $('#sub_cat_id').val();
      $.ajax({
        url:"{{route('brand_name')}}",
        data:{
            'category_id':cat_val,
            'subcategory_id':sub_cat_val,
            "_token": "{{ csrf_token() }}" 
        },
        type:'post',
        datatype:'json',
        success:function(data){
        $.each(data.data,function(index,brandname){
            $('#brand_name_id').append('<option value="'+brandname.id+'">'+brandname.brand_name+'</option>');
        })
        }
      });
    }
</script>
@endsection