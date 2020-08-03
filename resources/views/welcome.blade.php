<!DOCTYPE html>
<html lang="en">
<head>
  <title>Task</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> 
   <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script> <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
     <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
      <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
       <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-12">
  <br>
  <br>
  @if(session()->has('success'))

            <div class="alert alert-success">
                <strong>Success!</strong> {{ session()->get('success') }}.
            </div>

            @endif
  <h2>User List</h2> <a href="{{ route('add.user') }}" class="btn btn-primary">Add User</a>
            
  {!! $dataTable->table([],true) !!} {!! $dataTable->scripts() !!} 
</div>
</div>
</div>

<script>

 $(document).on('click','.deleteData',function(){
    var id = $(this).data('id');
      //alert(id);

  if (confirm("Are you want to delete User") == true) {
    
 


       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        $.ajax({
           type:'post',
           url:"{{ route('delete.user') }}",
           data:{id:id},
           success:function(data){
           //  alert(data+"arun");
            window.LaravelDataTables["user-table"].draw();
             //location.reload();

             // $("#dynamicTimeTable").html(data);
           }
        });

         } else {
    return false;
  }
       
    });

 </script>

</body>
</html>
