<?php
namespace controllers;

use models\Basket;
use models\Order;
use models\Product;
use models\Section;
use Ubiquity\attributes\items\di\Autowired;
use services\dao\StoreRepository;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\auth\AuthController;
use Ubiquity\controllers\auth\WithAuthTrait;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\USession;

/**
 * Controller MainController
 **/
class MainController extends ControllerBase {
    use WithAuthTrait;

    #[Autowired]
    private StoreRepository $repo;

	#[Route(path: "home", name: "home")]
	public function index() {
        $numOrders = count(DAO::getAll(Order::class, 'idUser=?', false, [USession::get("idUser")]));
        $numBaskets = count(DAO::getAll(Basket::class, 'idUser=?', false, [USession::get("idUser")]));
        $produitsPromo = DAO::getAll(Product::class, 'promotion<?', false, [0]);
        $this->loadDefaultView(['numOrders'=>$numOrders, 'numBaskets'=>$numBaskets, 'produitsPromo'=>$produitsPromo]);
	}

    public function getRepo(): StoreRepository {
        return $this->repo;
    }

    public function setRepo(StoreRepository $repo): void {
        $this->repo = $repo;
    }

    #[Route(path:"store/order", name:"order")]
    public function order() {
        $order = DAO::getAll(Order::class, 'idUser=?', false, [USession::get("idUser")]);
        $this->loadDefaultView(['order'=>$order]);
    }

    #[Route(path:"store/browse", name:"store")]
    public function store() {
        $numSection = count(DAO::getAll(Product::class, 'idSection=?', false, [2]));
        $section = DAO::getAll(Section::class, false, false);
        $produitsPromo = DAO::getAll(Product::class, 'promotion<?', false, [0]);
        $this->loadDefaultView(['section'=>$section, 'produitsPromo'=>$produitsPromo, 'numSection'=>$numSection]);
    }

    #[Route(path:"basket/new", name:"basket.new")]
    public function newBasket() {
        $newBasket = DAO::getAll(Order::class, 'idUser=?', false, [USession::get("idUser")]);
        $this->loadDefaultView(['newBasket'=>$newBasket]);
    }

    #[Route(path:"basket", name:"basket")]
    public function basket() {
        $basket = DAO::getAll(Basket::class, 'idUser=?', false, [USession::get("idUser")]);
        $this->loadDefaultView(['baskets'=>$basket]);
    }

	protected function getAuthController(): AuthController {
        return new MyAuth($this);
    }
}
