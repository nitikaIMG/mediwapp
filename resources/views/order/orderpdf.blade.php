
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
    <h2 class="header-title mb-0">Orders</h2>        
  <table class="table table-bordered">
    <thead >
        <tr>
            <th class="all">Order ID</th>
            <th>Product</th>
            <th>Payment Status</th>
            <th>Attroney ID</th>
            <th>User ID</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order_data as $d)
        <tr >
            <td >{{$d['order_id']}}</td>
            <td >{{$d['product']}}</td>
            <td >{{$d['payment_status']}}</td>
            <td >{{$d['user_id']}}</td>
            <td >{{$d['address']}}</td>
            {{-- <td > <img src="{{ asset('public/category_image/'.$d['category_image'])}}" width="50" height="50"></td> --}}
      
            {{-- <td style="border: 1px solid #100c09">{{$d['status']}}</td> --}}
        </tr> 
        @endforeach
    </tbody>
</div>

</body>
</html>
