<?php
namespace controllers\auth\files;

use Ubiquity\controllers\auth\AuthFiles;
 /**
  * Class service.ui.UIGroupsFiles
  */
class services.ui.UIGroupsFiles extends AuthFiles{
	public function getViewIndex(){
		return "service.ui.UIGroups/index.html";
	}

	public function getViewInfo(){
		return "service.ui.UIGroups/info.html";
	}

	public function getViewNoAccess(){
		return "service.ui.UIGroups/noAccess.html";
	}

	public function getViewDisconnected(){
		return "service.ui.UIGroups/disconnected.html";
	}

	public function getViewMessage(){
		return "service.ui.UIGroups/message.html";
	}

	public function getViewBaseTemplate(){
		return "service.ui.UIGroups/baseTemplate.html";
	}


}
