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
        $section = DAO::getAll(Section::class, false, ['products']);
        $produitsPromo = DAO::getAll(Product::class, 'promotion<?', false, [0]);
        $this->loadDefaultView(['section'=>$section, 'produitsPromo'=>$produitsPromo]);
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

    #[Route(path:"store/section/{id}", name:"section")]
    public function section($id) {
        $sections = DAO::getAll(Section::class, false, ['products']);
        $section = DAO::getById(Section::class, $id, ['products']);
        $this->loadDefaultView(['section'=>$section, 'sections'=>$sections]);
    }

    #[Route(path:"store/product/{idProduct}", name:"product")]
    public function product($idProduct){
        $sections = DAO::getAll(Section::class, false, ['products']);
        $product = DAO::getById(Product::class, $idProduct);
        $this->loadDefaultView(['sections'=>$sections, 'product'=>$product]);
    }

	protected function getAuthController(): AuthController {
        return new MyAuth($this);
    }

}
