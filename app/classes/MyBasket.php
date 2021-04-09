<?php

namespace classes;

use ArrayObject;
use models\Basket;
use models\Basketdetail;
use Ubiquity\orm\DAO;

class MyBasket {
    private $user;
    private $nameBasket;
    private $listProducts;
    private $totalPrix;

    public function __construct($name, $user) {
        $this->user = $user;
        $this->nameBasket = $name;
        $this->listProducts = array();
        $this->totalPrix = 0;
    }

    public function getListProducts() {
        return $this->listProducts;
    }

    public function addListProduct($product, $quantity) {
        if(!isset ($this->listProducts[$product->getId()])) {
            $this->listProducts[$product->getId()]['quantity'] = $quantity;
            $this->listProducts[$product->getId()]['product'] = $product;
        } else {
            $this->listProducts[$product->getId()]['quantity'] += $quantity;
        }
    }

    public function deleteListProduct() {
        foreach ($this->listProducts as $key=>$list) {
            unset($this->listProducts[$key]);
        }
    }

    public function deleteProduct($idProduct) {
        foreach ($this->listProducts as $key=>$list) {
            if ($list['product']->getId() == $idProduct) {
                unset($this->listProducts[$key]);
            }
        }
    }

    public function sauvegarder() {
        try {
            DAO::beginTransaction();

            $basket = new Basket();

            $basket->setName($this->nameBasket);
            $basket->setUser($this->user);

            if (DAO::save($basket)) {
                foreach ($this->listProducts as $value) {

                    $detailsBasket = new Basketdetail();
                    $detailsBasket->setBasket($basket);

                    if(isset($value['product']) && isset($value['quantity'])){
                        $detailsBasket->setProduct($value['product']);
                        $detailsBasket->setQuantity($value['quantity']);
                    }

                    DAO::save($detailsBasket);
                }
            }

            return DAO::commit();
        }
        catch(\Exception $e){
            DAO::rollBack();
            return false;
        }
    }

    public function getQuantity() {
        $quantite = 0;

        foreach ($this->listProducts as $key=>$list) {
            $quantite += $list['quantity'];
        }

        return $quantite;
    }

    public function setQuantity($idProduct, $quantity) {
        $this->listProducts[$idProduct]['quantity'] = $quantity;
    }

    public function getCalculTotal() {
        $this->totalPrix = 0;

        foreach ($this->listProducts as $key=>$list) {
            $this->totalPrix += $list['product']->getPrice() * $list['quantity'];
        }

        return $this->totalPrix;
    }

    public function getTotalPromo() {
        $prixPromo = 0;

        foreach ($this->listProducts as $key=>$list){
            $prixPromo += $list['product']->getPromotion();
        }

        $prixPromo += $this->totalPrix;

        return $prixPromo;
    }
}