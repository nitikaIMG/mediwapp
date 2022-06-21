
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
    <h2 class="header-title mb-0">Attroney</h2>        
  <table class="table table-bordered">
    <thead >
        <tr>
            <th class="all">First Name</th>
            <th>Last Name</th>
            <th>User Email</th>
            <th>Phone Number</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        @foreach($user_data as $d)
        <tr >
            <td >{{$d['user_firstname']}}</td>
            <td >{{$d['user_lastname']}}</td>
            <td >{{$d['user_email']}}</td>
            <td >{{$d['user_phonenumber']}}</td>
            <td >{{$d['user_address']}}</td>
        </tr> 
        @endforeach
    </tbody>
</div>

</body>
</html>
