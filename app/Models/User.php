<?php namespace App\Models;

class User
{
    public function user_id()
    {
        return session('user_id') ?? null;
    }

    public function userLogin($userInfo)
    {
        $session = session();
        $session->set('user_id', $userInfo['cloudflare_email']);
        $session->set('email', $userInfo['cloudflare_email']);
        $session->set('user_key', $userInfo['user_key']);
        $session->set('unique_id', $userInfo['unique_id']);
        $session->set('user_api_key', $userInfo['user_api_key']);
        \Codeigniter\Events\Events::trigger('login');
    }
}
