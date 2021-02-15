<?php
namespace controllers;
use Ubiquity\utils\http\USession;
use Ubiquity\utils\http\URequest;
use controllers\auth\files\services.dao.OrgaRepositoryFiles;
use Ubiquity\controllers\auth\AuthFiles;


class Services.dao.OrgaRepository extends \Ubiquity\controllers\auth\AuthController{

	protected function onConnect($connected) {
		$urlParts=$this->getOriginalURL();
		USession::set($this->_getUserSessionKey(), $connected);
		if(isset($urlParts)){
			$this->_forward(implode("/",$urlParts));
		}else{
			//TODO
			//Forwarding to the default controller/action
		}
	}

	protected function _connect() {
		if(URequest::isPost()){
			$email=URequest::post($this->_getLoginInputName());
			$password=URequest::post($this->_getPasswordInputName());
			//TODO
			//Loading from the database the user corresponding to the parameters
			//Checking user creditentials
			//Returning the user
		}
		return;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Ubiquity\controllers\auth\AuthController::isValidUser()
	 */
	public function _isValidUser($action=null) {
		return USession::exists($this->_getUserSessionKey());
	}

	public function _getBaseRoute() {
		return 'service.dao.OrgaRepository';
	}
	
	protected function getFiles(): AuthFiles{
		return new services.dao.OrgaRepositoryFiles();
	}



}
