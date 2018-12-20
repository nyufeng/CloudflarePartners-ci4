<?php namespace App\Controllers\Api;

class Domain extends \App\Controllers\ApiController
{
	public function delete()
	{
		$domain = $this->request->getPost('domain');
		if(empty($domain)){
			return $this->fail('请输入域名');
		}
		$result = $this->cf->deleteDomain($domain, $_SESSION['user_key']);
		if(empty($result)){
			return $this->failServerError('DNS 服务器返回异常');
		}
		if($result['result'] == 'error'){
			return $this->failServerError($result['msg']);
		}
		return $this->respond(['result' => 'success']);
	}

	public function add(){
		$domain = $this->request->getPost('domain');
		if(empty($domain)) {
			return $this->fail('请输入域名');
		}
		$subStr = 'www';
		$result = $this->cf->addSubDomain($subStr, 'cname.' . $domain, $domain, $_SESSION['user_key']);
		if(empty($result)){
			return $this->failServerError('DNS 服务器返回异常');
		}
		if($result['result'] == 'error'){
			return $this->failServerError($result['msg']);
		}
		return $this->respond(['result' => 'success']);
	}
}
