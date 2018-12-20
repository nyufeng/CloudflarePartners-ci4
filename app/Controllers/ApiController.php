<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

abstract class ApiController extends Controller{

	use ResponseTrait;

	public $cf = null;

	public function __construct()
	{
		session_start();
		if(!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] == false || empty($_SESSION['email']) || empty($_SESSION['user_key'])){
			header('Content-type: application/json');
			echo json_encode(array(
				'result' => 'error',
				'message' => '登陆状态失效',
			));
			exit;
		}

		$this->cf = new \App\Libraries\Cloudflare(getenv('CF_API_KEY'));
	}
}

