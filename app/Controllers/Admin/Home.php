<?php namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Home extends Controller
{   
    public function index()
    {
        $userInfo = \CodeIgniter\Services::cloudflare()->userInfo(\CodeIgniter\Services::user()->user_id());
        if($userInfo['result'] == 'error'){
            return view('error',[
                'code' => 500,
                'title' => 'CloudFlare Server Error',
                'message' => $userInfo['msg'],
                'message1' => '',
                'message2' => '',
                'message3' => '',
            ]);
        }
        echo view('admin/head');
        echo view('admin/index',[
            'hosted_zones' => $userInfo['response']['hosted_zones'] ?? [],
        ]);
        echo view('admin/footer.php');
        return;
    }

    public function edit($domain){
        $domainInfo = \CodeIgniter\Services::cloudflare()->domainList($domain, session('user_key'));
        if($domainInfo['result'] == 'error'){
            return view('error',[
                'code' => 500,
                'title' => 'CloudFlare Server Error',
                'message' => $domainInfo['msg'],
                'message1' => '',
                'message2' => '',
                'message3' => '',
            ]);
        }
        if($domainInfo['response']['zone_exists'] == false){
			return view('error',[
				'code' => 500,
				'title' => 'CloudFlare Domain Exists',
				'message' => $domainInfo['msg'],
				'message1' => '',
				'message2' => '',
				'message3' => '',
			]);
        }
        session()->set('hosted_cnames' . '_' .$domainInfo['response']['zone_name'], $domainInfo['response']['hosted_cnames']);
        echo view('admin/head');
        echo view('admin/edit',[
            'response' => $domainInfo['response'],
        ]);
        echo view('admin/footer.php');
        return;
    }
}