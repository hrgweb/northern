<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->only(['index', 'destroy']);
	}

	public function index()
	{
		return view('sessions.home');
	}

	public function create()
	{
		return view('sessions.create');
	}

	public function store()
	{
		// validate
		$this->validate(request(), [
			'username' => 'required',
			'password' => 'required'
		]);

		$credentials = request(['username', 'password']);

		if (! auth()->attempt($credentials)) {
			return back()
				->withErrors(['message' => 'Invalid username or password.'])
				->withInput(request(['username']));
		}

		return redirect()->home();
	}

	public function destroy()
	{
		auth()->logout();

		return redirect('/');
	}
}
