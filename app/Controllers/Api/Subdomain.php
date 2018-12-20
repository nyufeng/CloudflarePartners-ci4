<?php namespace App\Controllers\Api;


class Subdomain extends \App\Controllers\ApiController{

	public function add()
	{
		$subDomain = $this->request->getPost('sub');
		$cname = $this->request->getPost('cname');
		$domain = $this->request->getPost('domain');
		if(empty($subDomain) || empty($cname) || empty($domain)){
			return $this->fail('请输入 子域名 或 CNAME 地址');
		}
		$domainList = $_SESSION['hosted_cnames' . '_' .$domain];
		$domainList[$subDomain . '.'  .$domain] = $cname;
		return $this->process($domain, $domainList);
	}

	public function edit(){
		$subDomain = $this->request->getPost('sub');
		$cname = $this->request->getPost('cname');
		$domain = $this->request->getPost('domain');
		if(empty($subDomain) || empty($cname) || empty($domain)){
			return $this->fail('请输入 子域名 或 CNAME 地址');
		}
		$domainList = $_SESSION['hosted_cnames' . '_' .$domain];
		$domainList[$subDomain] = $cname;
		return $this->process($domain, $domainList);
	}

	public function delete(){
		$subDomain = $this->request->getPost('sub');
		$domain = $this->request->getPost('domain');
		if(empty($subDomain) || empty($domain)){
			return $this->fail('请输入 子域名');
		}
		$domainList = $_SESSION['hosted_cnames' . '_' .$domain];
		unset($domainList[$subDomain]);
		return $this->process($domain, $domainList);
	}

	private function process($domain, $domainList){
		$subStr = '';
		$cname = 'cname.' . $domain;
		foreach($domainList as $k => $v){
			if($k == $domain)
			{
				$cname = $v;
				continue;
			}
			$subStr .= $k . ':' . $v . ',';
		}
		$subStr = rtrim($subStr, ',');
		$result = $this->cf->addSubDomain($subStr, $cname, $domain, $_SESSION['user_key']);
		if(empty($result)){
			return $this->failServerError('DNS 服务器返回异常');
		}
		if($result['result'] == 'error'){
			return $this->failServerError($result['msg']);
		}
		return $this->respond(['result' => 'success']);
	}
}
