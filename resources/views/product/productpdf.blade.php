
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
</head>
<style>
    table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<body>

<div class="container">
    <h2 class="header-title mb-0">Product</h2>        
  <table class="table table-bordered">
    <thead >
        <tr>
            <th class="all">Product Name</th>
            <th>Product Image</th>
            <th>category Name</th>
            <th>Package Type</th>
            <th>Opening Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($product as $d)
        <tr >
            <td >{{$d['product_name']}}</td>
            <td > <img src="{{ asset('public/category_image/'.$d['product_image'])}}" width="50" height="50"></td>
            <td >{{$d['category_name']}}</td>
            <td >{{$d['package_type']}}</td>
            <td >{{$d['opening_quantity']}}</td>
            <td >{{$d['price']}}</td>
        </tr> 
        @endforeach
    </tbody>
</div>

</body>
</html>
