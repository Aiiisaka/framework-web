<?php
namespace controllers;

use models\Organisation;

use Ubiquity\attributes\items\router\Route;

use Ubiquity\orm\repositories\ViewRepository;

/**
 * Controller OrgaController
 **/
class OrgaController extends ControllerBase{
    private ViewRepository $repo;

    #[Route("orga")]
	public function index(){
        $this->repo->all("", false);
        $this->loadView("OrgaController/index.html");
	}

    public function initialize() {
        parent::initialize();
        $this->repo??=new ViewRepository($this,Organisation::class);
    }

	public function base(){
		$this->loadView('OrgaController/base.html');
	}

    #[Route(path: "orga/{idOrga}",name: "orga.getOne")]
    public function getOne($idOrga){
        $this->repo->byId($idOrga,['users.groupes','groupes.users']);
        $this->loadDefaultView();
    }
}
