<?php
namespace controllers;

use models\Organisation;

use Ubiquity\attributes\items\router\Post;
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

    #[Route(path: "orga/getOne/{idOrga}", name: "orga.getOne")]
    public function getOne($idOrga){
        $this->repo->byId($idOrga, ['users.groupes','groupes.users']);
        $this->loadDefaultView();
    }

    public function base(){
        $this->loadView('OrgaController/base.html');
    }

    #[Route(path: "orga/add", name: "orga.add")]
	public function add(){
        $this->repo->all("", false);
		$this->loadView('OrgaController/add.html');
	}

    #[Route(path: "orga/update/{idOrga}", name: "orga.update")]
	public function update($idOrga){
        $this->repo->byId($idOrga);
		$this->loadView('OrgaController/update.html');
	}

    #[Route(path: "orga/delete/{idOrga}", name: "orga.delete")]
	public function delete($idOrga){
        $this->repo->byId($idOrga);
		$this->loadView('OrgaController/delete.html');
	}

    #[Route(path: "orga/addGroup", name: "orga.addGroup")]
    public function addGroup(){
        $this->repo->all("", ['users']);
		$this->loadView('OrgaController/addGroup.html');
	}

}
