<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
	public function index()
	{
		return view('welcome_message');
	}

	public function login()
	{
		session_start();
		if(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true){
            return redirect()->to('/Admin');
        }
		return view('login');
	}
}
