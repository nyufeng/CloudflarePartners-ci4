<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Admin implements FilterInterface
{
    public function before(RequestInterface $request){
        session_start();
        if(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true){
            return $request;
        }
        return redirect()->to('/Home/Login');
    }

    public function after(RequestInterface $request,ResponseInterface $response){}
}