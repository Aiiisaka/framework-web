<?php
namespace controllers;
use models\User;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\auth\AuthController;
use Ubiquity\controllers\auth\WithAuthTrait;

 /**
 * Controller MainController
 **/
class MainController extends ControllerBase {
    use WithAuthTrait;

	#[Route(path: "index",name: "index")]
	public function index() {
		 $this->jquery->renderView('MainController/index.html');
	}

	protected function getAuthController(): AuthController {
        return new MyAuth($this);
    }

}
