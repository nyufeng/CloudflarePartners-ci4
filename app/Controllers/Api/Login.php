<?php namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

class Login extends \CodeIgniter\Controller
{
    use ResponseTrait;

    public function index()
	{
        $email = $this->request->getPost('email');
        $pass = $this->request->getPost('pass');
        if(empty($email) || empty($pass)){
            return $this->failUnauthorized('用户名或密码为空');
        }
        $result = \CodeIgniter\Services::cloudflare()->login($email, $pass);
        if(empty($result)){
            return $this->failServerError('DNS 服务器返回异常');
        }
        if($result['result'] == 'error'){
            return $this->failServerError($result['msg']);
        }
        \CodeIgniter\Services::user()->userLogin( $result['response']);
        return $this->respond(['result' => 'success',  'redirect' => '/admin']);
    }
}
