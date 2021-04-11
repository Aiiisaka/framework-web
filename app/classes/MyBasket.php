<?php

namespace classes;

use Ajax\semantic\widgets\datatable\DataTable;
use models\Orderdetail;
use models\Product;
use ArrayObject;
use models\Basket;
use models\Basketdetail;
use Ubiquity\orm\DAO;

class MyBasket {
    private $basket;
    private $id;
    private $totalPrix;

    public function __construct($basket) {
        $this->basket = $basket;
        $this->id = $basket->getId();
    }

    public function getListProducts() {
        $basketCurrent = DAO::getById(Basket::class, $this->id, ['basketdetails.product']);
        return $basketCurrent->getBasketdetails();
    }

    public function addListProduct($product, $quantity) {
        if (DAO::getOne(Basketdetail::class, 'idProduct=?', false, [$product->getId()])){
            return null;
        } else {
            $basketDetail = new Basketdetail();

            $basketDetail->setBasket($this->basket);
            $basketDetail->setProduct($product);
            $basketDetail->setQuantity($quantity);

            DAO::save($basketDetail);
        }
    }

    public function deleteListProduct() {
        DAO::deleteAll(Basketdetail::class, 'idBasket=?', [$this->id]);
    }

    public function deleteProduct($idProduct) {
        DAO::deleteAll(Basketdetail::class, "idBasket=? and idProduct=?", [$this->id, $idProduct]);
    }

    public function getQuantity() {
        $basketCurrent = DAO::getById(Basket::class, $this->id, ['basketdetails.product']);
        $basketdetail = $basketCurrent->getBasketdetails();

        $quantite = 0;

        foreach ($basketdetail as $basketdetails) {
            $quantite += $basketdetails->getQuantity();
        }

        return $quantite;
    }

    public function setQuantity($idProduct, $quantity) {
        $basketdetail = DAO::getOne(Basketdetail::class, 'idProduct=?', false, [$idProduct->getId()]);
        $basketdetail->setQuantity($quantity);
        DAO::save($basketdetail);
    }

    public function getCalculTotal() {
        $basketCurrent = DAO::getById(Basket::class, $this->id, ['basketdetails.product']);
        $basketdetail = $basketCurrent->getBasketdetails();

        $this->totalPrix = 0;

        foreach ($basketdetail as $basketdetails) {
            $this->totalPrix += $basketdetails->getProduct()->getPrice() * $basketdetails->getQuantity();
        }

        return $this->totalPrix;
    }

    public function getTotalPromo() {
        $basketCurrent = DAO::getById(Basket::class, $this->id, ['basketdetails.product']);
        $basketdetail = $basketCurrent->getBasketdetails();

        $prixPromo = 0;

        foreach ($basketdetail as $basketdetails) {
            $prixPromo += $basketdetails->getProduct()->getPromotion() * $basketdetails->getQuantity();
        }

        $prixPromo += $this->totalPrix;

        return $prixPromo;
    }

    public function setOrder($order){
        $basketCurrent = DAO::getById(Basket::class, $this->id, ['basketdetails.product']);
        $details = $basketCurrent->getBasketdetails();

        foreach ($details as $product){
            $orderDetails = new Orderdetail();
            $orderDetails->setProduct($product->getProduct());
            $orderDetails->setQuantity($product->getQuantity());
            $orderDetails->setOrder($order);

            DAO::save($orderDetails);
        }
    }
}