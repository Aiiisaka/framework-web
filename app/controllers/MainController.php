<?php
namespace controllers;

use classes\MyBasket;
use models\Basket;
use models\Basketdetail;
use models\Order;
use models\Product;
use models\Section;
use services\ui\StoreUI;
use services\dao\StoreRepository;
use Ubiquity\attributes\items\di\Autowired;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\Router;
use Ubiquity\controllers\auth\AuthController;
use Ubiquity\controllers\auth\WithAuthTrait;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\UResponse;
use Ubiquity\utils\http\USession;

/**
 * Controller MainController
 **/
class MainController extends ControllerBase {
    use WithAuthTrait;

    public function initialize() {
        parent::initialize();
        $this -> ui = new StoreUI($this);
    }

    #[Autowired]
    private StoreRepository $repo;

	#[Route(path: "home", name: "home")]
	public function index() {
        $products = USession::get("recentlyViewedProducts");

        $numOrders = count(DAO::getAll(Order::class, 'idUser=?', false, [USession::get("identifiant")]));
        $numBaskets = count(DAO::getAll(Basket::class, 'idUser=?', false, [USession::get("identifiant")]));
        $produitsPromo = DAO::getAll(Product::class, 'promotion<?', false, [0]);

        $this->loadDefaultView(['numOrders'=>$numOrders, 'numBaskets'=>$numBaskets, 'produitsPromo'=>$produitsPromo, 'recentlyViewedProducts'=>$products]);
	}

    public function getRepo(): StoreRepository {
        return $this->repo;
    }

    public function setRepo(StoreRepository $repo): void {
        $this->repo = $repo;
    }

    #[Route(path:"store/order", name:"order")]
    public function order() {
        $order = DAO::getAll(Order::class, 'idUser=?', false, [USession::get("identifiant")]);
        $this->loadDefaultView(['order'=>$order]);
    }

    #[Route(path:"store/browse", name:"store")]
    public function store() {
        $products = USession::get("recentlyViewedProducts");
        $section = DAO::getAll(Section::class, false, ['products']);
        $produitsPromo = DAO::getAll(Product::class, 'promotion<?', false, [0]);
        $this->loadDefaultView(['section'=>$section, 'produitsPromo'=>$produitsPromo, 'recentlyViewedProducts'=>$products]);
    }

    #[Route(path:"basket/new", name:"basket.new")]
    public function newBasket() {
        if (URequest::post("basketName") != null) {
            $user = DAO::getById(User::class, 'idUser=?', false, [USession::get("identifiant")]);

            $newBasket = new MyBasket(URequest::post("basketName"), $user);
            $newBasket->sauvegarder();

            UResponse::header("location", "/".Router::path("basket"));
        } else {
            $this->loadDefaultView();
        }
    }

    #[Route(path:"basket", name:"basket")]
    public function basket() {
        $basket = USession::get("defaultBasket");

        $productsList = $basket->getListProducts();
        $prixTotal = $basket->getCalculTotal();
        $promoTotal = $basket->getTotalPromo();
        $quantity = $basket->getQuantity();

        $this->loadDefaultView(['products'=>$productsList, 'prixTotal'=> $prixTotal, 'promo'=>$promoTotal, 'quantity'=>$quantity]);
    }

    #[Route(path:"store/section/{id}", name:"section")]
    public function section($id) {
        $sections = DAO::getAll(Section::class, false, ['products']);
        $section = DAO::getById(Section::class, $id, ['products']);
        $this->loadDefaultView(['section'=>$section, 'sections'=>$sections]);
    }

    #[Route(path:"store/product/{idSection}/{idProduct}", name:"product")]
    public function product($idSection, $idProduct) {
        $sections = DAO::getAll(Section::class, false, ['products']);
        $section = DAO::getById(Product::class, $idSection);
        $product = DAO::getById(Product::class, $idProduct);

        $products = USession::get("recentlyViewedProducts");
        $products[] = $product;
        USession::set("recentlyViewedProducts", $products);

        $this->loadDefaultView(['sections'=>$sections, 'product'=>$product, 'section'=>$section]);
    }

    #[Route(path:"basket/add/{idProduct}", name:"addProduct")]
    public function addProduct($idProduct) {
        $product = DAO::getById(Product::class, $idProduct, false);

        $basket = USession::get("defaultBasket");
        $basket->addListProduct($product, 1);

        UResponse::header("location", "/".Router::path("store"));
    }

    #[Route(path:"basket/add/{idBasket}/{idProduct}", name:"addProductTo")]
    public function addProductTo($idBasket, $idProduct) {
        $product = DAO::getById(Product::class, $idProduct, false);
        $basket = DAO::getById(Basket::class, $idBasket, false);

        $detailsBasket = new Basketdetail();

        $detailsBasket->setProduct($product);
        $detailsBasket->setBasket($basket);

        $detailsBasket->setQuantity(1);

        UResponse::header("location", "/".Router::path("store"));
    }

    #[Route(path:"basket/clear/{idProduct}", name:"basket.clearOne")]
    public function clearOne($idProduct) {
        $basketDetails = USession::get("defaultBasket");
        $basketDetails->deleteProduct($idProduct);

        UResponse::header("location", "/".Router::path("basket"));
    }

    #[Route(path:"basket/clear", name:"basket.clear")]
    public function clear() {
        $basketDetails = USession::get("defaultBasket");
        $basketDetails->deleteListProduct();

        UResponse::header("location", "/".Router::path("basket"));
    }

    #[Route(path:"basket/validate", name:"basket.validate")]
    public function basketValidate() {
        $basket = USession::get("defaultBasket");

        $prixTotal = $basket->getCalculTotal();
        $promoTotal = $basket->getTotalPromo();
        $quantity = $basket->getQuantity();

        $this->loadDefaultView(['prixTotal'=> $prixTotal, 'promo'=>$promoTotal, 'quantity'=>$quantity]);
    }

    #[Route(path:"basket/command", name:"basket.command")]
    public function basketCommand() {

    }

	protected function getAuthController(): AuthController {
        return new MyAuth($this);
    }
}
