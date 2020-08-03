<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Vertical (basic) form</h2>
  <form action="{{ route('update.user') }}" method="post">
    @csrf
     <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" value="{{ $user->name }}" name="name">
    <span style="color:red">  {{ $errors->first('name')}}<span>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" value="{{ $user->email }}"  name="email">
       <span style="color:red">  {{ $errors->first('email')}}<span>
    </div>
    <div class="form-group">
      <label for="phone">Phone:</label>
      <input type="text" class="form-control" id="phone" value="{{ $user->phone_no }}" name="phone_no">
       <span style="color:red">  {{ $errors->first('phone_no')}}<span>
    </div>
      <input type="hidden" value="{{ $user->id }}" name="userId">
  


    <div class="form-group">
  <label for="class_id">Class</label>
  <select class="form-control" id="class_id" name="className">
     
     @foreach($classList as $classLists)
    <option @php if($classLists->id ==$user->class_id){
      echo "selected";
    } @endphp  value="{{ $classLists->id }}" >{{ $classLists->class_name }}</option>
   @endforeach
  </select>
   <span style="color:red">  {{ $errors->first('className')}}<span>
</div>




   
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>
