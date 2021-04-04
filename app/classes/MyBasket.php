<?php

namespace classes;

class MyBasket {
    private $user;
    private $nameBasket;
    private $listProducts;

    public function __construct($name, $user){
        $this->user = $user;
        $this->nameBasket = $name;
        $this->listProducts = array();
    }

    public function getListProducts(){
        return $this->listProducts;
    }

    public function addListProduct($product, $quantity){
        if(!isset ($this->listProducts[$product->getId()])) {
            $this->listProducts[$product->getId()]['quantity'] = $quantity;
            $this->listProducts[$product->getId()]['product'] = $product;
        } else {
            $this->listProducts[$product->getId()]['quantity'] += $quantity;
        }
    }

    public function quantity($article, $quantity){
        $this->listProducts[$article->getId()]['quantity'] = $quantity;
    }
}