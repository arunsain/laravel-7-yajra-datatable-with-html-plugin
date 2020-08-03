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
