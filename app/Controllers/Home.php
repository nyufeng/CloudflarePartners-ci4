<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	public function login()
	{
		if(\CodeIgniter\Services::user()->user_id() !== null)
		{
			return redirect()->to('/admin');
		}
		return view('login');
	}

	//--------------------------------------------------------------------

}
