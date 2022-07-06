@extends('layouts.home')
@section('content')
<div class="col-10 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">ADD PRODUCT</h4>
       
        <form class="forms-sample" method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Product Name</label>
                    <input type="text" name="product_name" class="form-control"  value="{{old('product_name')}}" id="exampleInputName1"  placeholder=" Category Name">
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Select Category</label>
                    <select name="category_id" onchange="select_subcategory();" class="form-control" id="cat">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($category as $cat)
                        <option {{ old('category_id') == $cat->id ? "selected" : "" }} value="{{$cat->id}}" >{{$cat->category_name}}</option>
                        @endforeach
                    </select>
                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Subcategory</label>
                    <select name="subcategory_id" class="form-control" onchange="select_brand();"id="sub_cat_id">
                        <option disabled selected value> -- select an option -- </option>
                        {{-- @foreach($subcategory as $subcat)
                        <option {{ old('subcategory_id') == $subcat->id ? "selected" : "" }} value="{{$subcat->id}}" >{{$subcat->subcategory_name}}</option>
                        @endforeach --}}
                    </select>
                    
                </div>
                <div class="form-group col-md-6">
                   
                    <label for="formFileMultiple" class="form-label">Product Image</label>
                    <input class="form-control" name="product_image[]" type="file" id="formFileMultiple" multiple>
                    
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Price</label>
                    <input type="text" name="price" class="form-control"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  value="{{old('price')}}" id="exampleInputName1"  placeholder=" Product Price">
                </div>
                    
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Opening Quantity</label>
                    <input type="text" name="opening_quantity" class="form-control"  value="{{old('opening_quantity')}}" id="exampleInputName1"  placeholder="Opening Quantity">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Min quantity</label>
                    <input type="text" name="min_quantity" class="form-control"  value="{{old('min_quantity')}}" id="exampleInputName1"  placeholder=" Min Quantity">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Package Type</label>
                    <input type="text" name="package_type" class="form-control"  value="{{old('package_type')}}" id="exampleInputName1"  placeholder=" Package Type">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Brand Name</label>
                    <select name="brand_image" class="form-control" id="brand_name_id">
                        <option disabled selected value> -- select an option -- </option>
                        {{-- @foreach($brand_name as $brand)
                        <option {{ old('brand_name') == $brand->id ? "selected" : "" }} value="{{$brand->id}}" >{{$brand->brand_name}}</option>
                        @endforeach --}}
                    </select>
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Validate Date</label>
                    <input type="date" name="validate_date" class="form-control"  value="{{old('validate_date')}}" id="exampleInputName1"  placeholder=" Validate Date">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Offer</label>
                    <input type="text" name="offer" class="form-control"  value="{{old('offer')}}" id="exampleInputName1"  placeholder="Offer">
                </div>
                    
                <div class="form-group col-md-6">
                    <label for="exampleInputName1">Offer Type</label>
                    <input type="text" name="offer_type" class="form-control"  value="{{old('offer_type')}}" id="exampleInputName1"  placeholder=" Offer Type">
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleSelectGender">Health Goal</label>
                    <select name="health_goal"  class="form-control" id="cat">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($health_goal as $health)
                        <option {{ old('health_goal') == $health->id ? "selected" : "" }} value="{{$health->id}}" >{{$health->health_goals}}</option>
                        @endforeach
                    </select>
                   
                </div>

            </div>
            <div class="row">
                <label for="exampleSelectGender">Product Description</label>
                <textarea class="ckeditor form-control" id="ck" name="prod_desc"></textarea>
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
                    $.each(data.data,function(index,subcategory){
                        $('#sub_cat_id').append('<option value="'+subcategory.id+'">'+subcategory.subcategory_name+'</option>');
                    })
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