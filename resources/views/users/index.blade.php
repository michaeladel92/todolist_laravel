
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Todo List</title>
  </head>
  <body>

  <div class="container col-md-10 mt-5">
    {{session()->get('Message')}}
   <div class="bg-light w-25">logged by: {{auth()->user()->email}}</div> 
  <a href="{{url('tasks/create')}}" class="btn btn-primary m-1">Add Todo</a>
  <a href="{{url('users') ."/".auth()->user()->id."/"."edit" }}" class="btn btn-dark m-1">Edit Profile</a>
  <a href="{{url('/logout')}}" class="btn btn-danger m-1">logout</a>
  @if (count($data) > 0)
  <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">id</th>
      <th scope="col">title</th>
      <th scope="col">description</th>
      <th scope="col">start</th>
      <th scope="col">end</th>
      <th scope="col">Img</th>
      <th scope="col">options</th>
    </tr>
  </thead>
  <tbody>
  
        
   
    @foreach ($data as $row)
      <tr>
        <th scope="row">{{$row['id']}}</th>
        <td>{{$row['title']}}</td>
        <td>{{$row['description']}}</td>
        <td>{{$row['start_date']}}</td>
        <td>{{$row['end_date']}}</td>
        <td>  
          <img style="object-fit: cover;max-width:90px;max-height:90px;" src="{{asset('images/'.$row['image'])}}">
        </td>
        <td>
          @if ($row['end_date'] > date('Y-m-d'))
            <form action="{{url('tasks').'/'.$row['id']}}" method="POST">
              @csrf
              @method('delete')
              <button type="submit" class="btn btn-danger btn-sm">delete</button>
            </form>
            <a href="{{url('tasks').'/'.$row['id'].'/'.'edit'}}" class="btn btn-warning btn-sm">Edit</a>
          @endif
        </td>
      </tr>
    @endforeach 
      </tbody>
    </table>
    @else
    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                               No lists yet!
                                   <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                     <span aria-hidden='true'>&times;</span>
                                   </button>
           </div>
       @endif
  </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
  </body>
</html>