<?php namespace App\Filters;

use \CodeIgniter\Filters\FilterInterface;
use \CodeIgniter\HTTP\RequestInterface;
use \CodeIgniter\HTTP\ResponseInterface;


class Auth implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        if(\CodeIgniter\Services::user()->user_id() == null)
        {
            return \CodeIgniter\Services::response()->setStatusCode(400);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {

    }
}
