<?php namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

class Login extends \CodeIgniter\Controller
{
    use ResponseTrait;

    public function __construct()
	{
        session_start();
    }

    public function index()
	{
        $email = $this->request->getPost('email');
        $pass = $this->request->getPost('pass');
        if(empty($email) || empty($pass)){
            return $this->failUnauthorized('用户名或密码为空');
        }
        $cf = new \App\Libraries\Cloudflare(getenv('CF_API_KEY'));
        $result = $cf->login($email, $pass);
        if(empty($result)){
            return $this->failServerError('DNS 服务器返回异常');
        }
        if($result['result'] == 'error'){
            return $this->failServerError($result['msg']);
        }
        $_SESSION['isLogin'] = true;
        $_SESSION['email'] = $result['response']['cloudflare_email'];
        $_SESSION['user_key'] = $result['response']['user_key'];
        $_SESSION['unique_id'] = $result['response']['unique_id'];
        $_SESSION['user_api_key'] = $result['response']['user_api_key'];
        return $this->respond(['result' => 'success',  'redirect' => '/admin']);
    }
}
