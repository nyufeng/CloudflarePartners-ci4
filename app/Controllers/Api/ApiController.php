<?php namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

abstract class ApiController extends Controller{

	use ResponseTrait;

    public $cf;
    public $session;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        $this->cf = \CodeIgniter\Services::cloudflare();
        $this->session = \CodeIgniter\Services::session();
    }
}