<!DOCTYPE html>
<html lang="en">
<head>
  <title>todo list</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Register</h2>
  {{session()->get('Message')}}
  <form action="{{url('users')}}"  method="POST">
    @csrf
  <!-- name -->
  <div class="form-group">
    <label>Name</label>
    <input value="{{old('name')}}"  type="text" class="form-control" name="name" placeholder="Enter Name">
  </div>
  <!-- email -->
  <div class="form-group">
    <label>Email address</label>
    <input value="{{old('email')}}" type="text"   class="form-control"  name="email" placeholder="Enter email">
    </div>
  <!-- password -->
  <div class="form-group">
    <label>Password</label>
    <input value="" type="password"   class="form-control" name="password">
  </div>
  <!-- confirm password -->
  <div class="form-group">
    <label for="con-exampleInputPassword">confirm Password</label>
    <input value="" type="password"   class="form-control" name="password_confirmation">
  </div>

 <!-- Error messages -->
 @if ($errors->any())
 <div class="alert alert-danger">
     <ul>
         @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
         @endforeach
     </ul>
 </div>
@endif
<button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

</body>
</html>