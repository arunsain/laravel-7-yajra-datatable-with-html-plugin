<!DOCTYPE html>
<html lang="en">
<head>
  <title>Task</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>User Form</h2>
  <form action="{{ route('add.userData') }}" method="post">
    @csrf
     <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="{{ old('name') }}">
    <span style="color:red">  {{ $errors->first('name')}}<span>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ old('email') }}">
       <span style="color:red">  {{ $errors->first('email')}}<span>
    </div>
    <div class="form-group">
      <label for="phone">Phone:</label>
      <input type="text" class="form-control" id="phone" placeholder="Enter Phone Numer" name="phone_no" value="{{ old('phone_no') }}">
       <span style="color:red">  {{ $errors->first('phone_no')}}<span>
    </div>


    <div class="form-group">
  <label for="class_id">Class</label>
  <select class="form-control" id="class_id" name="className">
     <option value="">Select Class</option>
     @foreach($classList as $classLists)
    <option value="{{ $classLists->id }}">{{ $classLists->class_name }}</option>
   @endforeach
  </select>
   <span style="color:red">  {{ $errors->first('className')}}<span>
</div>




   
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>
