    				 html plugin Datatables

1. Run this command   

  		composer require yajra/laravel-datatables:^1.5 

2. run this command

  		php artisan vendor:publish --tag=datatables

  		php artisan vendor:publish --tag=datatables-html //for html bulider

  		php artisan vendor:publish --tag=datatables-buttons // for button builder


3. Run this command

		php artisan datatable:make User --model


		this command point out to user model and create query automatically for users table

		add new file in app\DataTables\UserDataTable.php



		<?php

		namespace App\DataTables;

		use App\User;
		use Yajra\DataTables\Html\Button;
		use Yajra\DataTables\Html\Column;
		use Yajra\DataTables\Html\Editor\Editor;
		use Yajra\DataTables\Html\Editor\Fields;
		use Yajra\DataTables\Services\DataTable;

		class UserDataTable extends DataTable
		{
		    /**
		     * Build DataTable class.
		     *
		     * @param mixed $query Results from query() method.
		     * @return \Yajra\DataTables\DataTableAbstract
		     */
		    public function dataTable($query)
		    {
		        return datatables()
		        ->eloquent($query)
		        ->addColumn('action',function($data){

		            $view ='<a href="'.route('edit.user',$data->id).'" class="btn btn-success btn-sm">edit</a> <button type="button" data-id="'.$data->id.'" class="btn btn-danger btn-sm deleteData">delete</button>';

		            return $view;
		        })
		        ->setRowClass(function ($user) {
		            return $user->id % 2 == 0 ? 'alert-success' : 'alert-warning';
		        })->setRowId(function ($user) {
		            return $user->id;
		        })->editColumn('created_at', function(User $user) {
		                    return $user->created_at->diffforHumans();
		                })->editColumn('class_id', function(User $user) {
		                    return $user->classData->class_name;
		                })->addColumn('intro', 'Hi {{$name}}!')
		                ->addColumn('test', 'test.test')->rawColumns(['action']);
		    }

		    /**
		     * Get query source of dataTable.
		     *
		     * @param \App\User $model
		     * @return \Illuminate\Database\Eloquent\Builder
		     */
		    public function query(User $model)
		    {
		        return $model->newQuery();
		    }

		    /**
		     * Optional method if you want to use html builder.
		     *
		     * @return \Yajra\DataTables\Html\Builder
		     */
		    public function html()
		    {
		        return $this->builder()
		        ->setTableId('user-table')
		        ->columns($this->getColumns())
		        ->minifiedAjax()
		        ->dom('Bfrtip')
		        ->orderBy(1)
		        ->buttons(
		           Button::make('create')->action("window.location = '".route('add.user')."';"),
		            Button::make('export'),
		            Button::make('print'),
		            Button::make('reset'),
		            Button::make('reload')
		        )->parameters([
		            // 'dom'          => 'Bfrtip',
		            // 'buttons'      => ['export', 'print', 'reset', 'reload'],
		            'initComplete' => "function () {
		                this.api().columns().every(function () {
		                    var column = this;
		                    var input = document.createElement(\"input\");
		                    $(input).appendTo($(column.footer()).empty())
		                    .on('keyup', function () {
		                        column.search($(this).val(), false, false, true).draw();
		                        });
		                        });
		                    }",
		                ]);
		    }

		    /**
		     * Get columns.
		     *
		     * @return array
		     */
		    protected function getColumns()
		    {
		        return [

		            Column::make('id')->title('sno'),
		            Column::make('name'),
		            Column::make('email'),
		            Column::make('intro'),
		            Column::make('test'),
		            Column::make('class_id')->title('Class Name')->searchable(false),
		            Column::make('created_at'),
		            Column::computed('action')
		            ->exportable(false)
		            ->printable(false)
		            ->width(60)
		            ->orderable(true)
		            ->addClass('text-center'),
		        ];
		    }

		    /**
		     * Get filename for export.
		     *
		     * @return string
		     */
		    protected function filename()
		    {
		        return 'User_' . date('YmdHis');
		    }
		}



4. Add link in html 

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> 
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script> <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
		<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
		<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>


5. for table html in blade use this line

	
		{!! $dataTable->table() !!} {!! $dataTable->scripts() !!} 



6. For add table footer search add true in table() function


		{!! $dataTable->table([],true) !!} {!! $dataTable->scripts() !!} 


		Note:- add this code in app\DataTable\UserDataTable.php

		->parameters([
            // 'dom'          => 'Bfrtip',
            // 'buttons'      => ['export', 'print', 'reset', 'reload'],
            'initComplete' => "function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement(\"input\");
                    $(input).appendTo($(column.footer()).empty())
                    .on('keyup', function () {
                        column.search($(this).val(), false, false, true).draw();
                        });
                        });
                    }",
                ]);


7.  add this code in app\Http\Controller\UserController.php file



		<?php

		namespace App\Http\Controllers;

		use Illuminate\Http\Request;
		use App\User;
		use App\Class_name;
		use App\DataTables\UserDataTable;

		class UserController extends Controller
		{
		    //
			public function index(UserDataTable $userDataTable){

				//$user = User::all();
				//return view('welcome',compact('user'));
				return $userDataTable->render('welcome');
			}

			public function addUserForm(){

				$classList = Class_name::all();
				return view('addUser',compact('classList'));
			}

			public function addUserData(Request $request){

				$request->validate([
					'name' =>['required','string'],
					'email' => ['required', 'string', 'email', 'max:255','unique:users'],
					'phone_no' =>['required','integer','unique:users'],
					'className' => 'required'
				]);
		  
				User::create([

					'name' =>$request->name,
					'email' => $request->email ,
					'phone_no' => $request->phone_no,
					'class_id' => $request->className
				]);
				return redirect('/')->with('success','User Add Successfully !');
			}



			public function deleteUser(Request $request){

				$user = User::find($request->id);

				$user->delete();
			}


			public function editUserForm($id){

				$user = User::where('id',$id)->first();
				$classList = Class_name::all();
				return view('editUser',compact('user','classList'));
			}


			public function updateUser(Request $request){

				$request->validate([
					'name' =>['required','string'],
					'email' => ['required', 'string', 'email', 'max:255','unique:users,email,'.$request->userId],
					'phone_no' =>['required','integer','unique:users,phone_no,'.$request->userId],
					'className' => 'required'
				]);


				$user = User::find($request->userId);
				$user->name = $request->name;
				$user->email = $request->email;
				$user->phone_no = $request->phone_no;
				$user->class_id = $request->className;
				$user->save();
				return redirect('/')->with('success','User Data Update Successfully !');
			}

		}




 note:- with the help of this code html is render in welcome.blade.php in UserController.php

 		use App\DataTables\UserDataTable;
 		public function index(UserDataTable $userDataTable){

				//$user = User::all();
				//return view('welcome',compact('user'));
				return $userDataTable->render('welcome');
			}




8. for run this code use this command

		composer Update

9. make .env file 

		copy .env.example and make new file .env 

10. for run this command 

		php artisan server

