<?php
namespace controllers\auth\files;

use Ubiquity\controllers\auth\AuthFiles;
 /**
  * Class service.dao.OrgaRepositoryFiles
  */
class services.dao.OrgaRepositoryFiles extends AuthFiles{
	public function getViewIndex(){
		return "service.dao.OrgaRepository/index.html";
	}

	public function getViewInfo(){
		return "service.dao.OrgaRepository/info.html";
	}

	public function getViewNoAccess(){
		return "service.dao.OrgaRepository/noAccess.html";
	}

	public function getViewDisconnected(){
		return "service.dao.OrgaRepository/disconnected.html";
	}

	public function getViewMessage(){
		return "service.dao.OrgaRepository/message.html";
	}

	public function getViewBaseTemplate(){
		return "service.dao.OrgaRepository/baseTemplate.html";
	}


}
