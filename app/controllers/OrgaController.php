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

    public function initialize() {
        parent::initialize();
        $this->repo=new ViewRepository($this,Organisation::class);
    }

    #[Route(path:"orga", name: "orga.index")]
	public function index(){
        $this->repo->all("", false);
        $this->loadView("OrgaController/index.html");
	}

    #[Route(path: "orga/{idOrga}", name: "orga.getOne")]
    public function getOne($idOrga){
        $this->repo->byId($idOrga, ['users.groupes','groupes.users']);
        $this->loadDefaultView();
    }

    public function base(){
        $this->loadView('OrgaController/base.html');
    }
}
