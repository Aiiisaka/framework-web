<?php
namespace controllers;
use controllers\crud\datas\CrudOrgaDatas;
use Ubiquity\controllers\crud\CRUDDatas;
use controllers\crud\viewers\CrudOrgaViewer;
use Ubiquity\controllers\crud\viewers\ModelViewer;
use controllers\crud\events\CrudOrgaEvents;
use Ubiquity\controllers\crud\CRUDEvents;
use controllers\crud\files\CrudOrgaFiles;
use Ubiquity\controllers\crud\CRUDFiles;
use Ubiquity\attributes\items\router\Route;

/**
* Controller CrudOrga
**/

#[Route(path: "/Orga",inherited: true,automated: true)]
class CrudOrga extends \Ubiquity\controllers\crud\CRUDController {

	public function __construct() {
		parent::__construct();
		\Ubiquity\orm\DAO::start();
		$this->model='models\\Organization';
		$this->style='';
	}

	public function _getBaseRoute() {
		return '/Orga';
	}

	protected function getAdminData(): CRUDDatas {
		return new CrudOrgaDatas($this);
	}

	protected function getModelViewer(): ModelViewer {
		return new CrudOrgaViewer($this,$this->style);
	}

	protected function getEvents(): CRUDEvents {
		return new CrudOrgaEvents($this);
	}

	protected function getFiles(): CRUDFiles {
		return new CrudOrgaFiles();
	}
}
