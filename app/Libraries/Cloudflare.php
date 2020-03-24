<?php namespace App\Libraries;

class Cloudflare
{
    static $SERVER_URL = 'https://api.cloudflare.com/host-gw.html';
    public $HOST_KEY = NULL;

    public function __construct(string $apiKey)
    {
        if(empty($apiKey)){
            throw new \Exception("CloudFlare API-KEY is empty");
        }
        $this->HOST_KEY = $apiKey;
    }

    public function login(string $email, string $pass): array{
        $params = [];
        $params['host_key'] = $this->HOST_KEY;
        $params['act'] = 'user_create';
        $params['cloudflare_email'] = $email;
        $params['cloudflare_pass'] = $pass;
        $data = $this->performRequest($params);
        if(empty($data)){
            return ['result' => 'error', 'msg' => 'CloudFlare Server is Lose. Try again later.'];
        }
        return json_decode($data, true);
    }

    public function userInfo($email){
        $params = [];
        $params['host_key'] = $this->HOST_KEY;
        $params['act'] = 'user_lookup';
        $params['cloudflare_email'] = $email;
        $data = $this->performRequest($params);
        if(empty($data)){
            return ['result' => 'error', 'msg' => 'CloudFlare Server is Lose. Try again later.'];
        }
        return json_decode($data, true);
    }

    public function domainList($domain, $userKey){
        $params = [];
        $params['host_key'] = $this->HOST_KEY;
        $params['act'] = 'zone_lookup';
        $params['zone_name'] = $domain;
        $params['user_key'] = $userKey;
        $data = $this->performRequest($params);
        if(empty($data)){
            return ['result' => 'error', 'msg' => 'CloudFlare Server is Lose. Try again later.'];
        }
        return json_decode($data, true);
    }

    public function deleteDomain($domain, $userKey){
		$params = [];
		$params['host_key'] = $this->HOST_KEY;
		$params['act'] = 'zone_delete';
		$params['zone_name'] = $domain;
		$params['user_key'] = $userKey;
		$data = $this->performRequest($params);
		if(empty($data)){
			return ['result' => 'error', 'msg' => 'CloudFlare Server is Lose. Try again later.'];
		}
		return json_decode($data, true);
	}

    public function addSubDomain($sub, $cname, $domain, $userKey){
		$params = [];
		$params['host_key'] = $this->HOST_KEY;
		$params['act'] = 'zone_set';
		$params['zone_name'] = $domain;
		$params['subdomains'] = $sub;
		$params['resolve_to'] = $cname;
		$params['user_key'] = $userKey;
		$data = $this->performRequest($params);
		if(empty($data)){
			return ['result' => 'error', 'msg' => 'CloudFlare Server is Lose. Try again later.'];
		}
		return json_decode($data, true);
	}

    private function performRequest(array & $data, array $headers = []): ?string{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$SERVER_URL);

        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 20); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_AUTOREFERER,    TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        if (($http_result = curl_exec($ch)) === FALSE) {
            return null;
        }

        curl_close($ch);
        return $http_result;
    }

}
