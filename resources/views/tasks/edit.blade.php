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
  <h2>Edit Task: {{$data['title']}}</h2>
  {{session()->get('Message')}}
  <form action="{{url('tasks').'/'.$data['id']}}"  method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

  <!-- title -->
  <div class="form-group">
    <label>title</label>
    <input value="{{old('title',$data['title'])}}"  type="text" class="form-control" name="title" placeholder="Enter Title">
  </div>
  <!-- description -->
  <div class="form-group">
    <label>description</label>
    <textarea class="form-control"  name="description" placeholder="Enter description">{{old('description',$data['description'])}}
    </textarea>
    </div>
  <!-- start date -->
  <div class="form-group">
    <label>start date</label>
    <input type="date" value="{{old('start_date',$data['start_date'])}}"  class="form-control" name="start_date">
  </div>
  <!-- end date  -->
  <div class="form-group">
    <label for="con-exampleInputPassword">end date</label>
    <input type="date" value="{{old('end_date',$data['end_date'])}}"  class="form-control" name="end_date">
  </div>
 <!-- Image -->
 <div class="form-group">
  <label>Image</label>
  <input type="file" class="form-control" name="image">
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
<button type="submit" class="btn btn-primary">Edit Task</button>
</form>
</div>

</body>
</html>