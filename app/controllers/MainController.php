<?php
namespace controllers;
use models\User;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\auth\AuthController;
use Ubiquity\controllers\auth\WithAuthTrait;
use Ubiquity\orm\DAO;

/**
 * Controller MainController
 **/
class MainController extends ControllerBase {
    use WithAuthTrait;

	#[Route(path: "home", name: "home")]
	public function index() {
		 $this->jquery->renderView('MainController/index.html');
	}

    #[Route(path:"store/order", name:"order")]
    public function order() {
        $this->loadView('MainController/order.html');
    }

    #[Route(path:"store/browse", name:"browse")]
    public function browse() {
        $this->loadView('MainController/store.html');
    }

    #[Route(path:"basket/new", name:"basket.new")]
    public function newBasket() {
        $this->loadView('MainController/newBasket.html');
    }

    #[Route(path:"basket", name:"basket")]
    public function basket() {
        $this->loadView('MainController/basket.html');
    }

	protected function getAuthController(): AuthController {
        return new MyAuth($this);
    }

}
