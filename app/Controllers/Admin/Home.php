<?php namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function __construct(){
        $this->cf = new \App\Libraries\Cloudflare(getenv('CF_API_KEY'));
    }
    
    public function index()
    {
        $userInfo = $this->cf->userInfo($_SESSION['email']);
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
        $domainInfo = $this->cf->domainList($domain, $_SESSION['user_key']);
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
        $_SESSION['hosted_cnames' . '_' .$domainInfo['response']['zone_name']] = $domainInfo['response']['hosted_cnames'];
        echo view('admin/head');
        echo view('admin/edit',[
            'response' => $domainInfo['response'],
        ]);
        echo view('admin/footer.php');
        return;
    }
}
