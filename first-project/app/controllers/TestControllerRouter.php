<?php
namespace controllers;

use Ubiquity\attributes\items\router\Route;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Post;

 /**
 * Controller TestControllerRouter
 **/
#[Route('test', automated: true)]
class TestControllerRouter extends ControllerBase{
	public function index(){}

	#[Route(path: "message")]
	public function message(){
        echo 'Affiché via la route /message';
	}

    #[Route(path: "send/{message}")]
    public function send(string $message) {
        echo 'Affiché via la route /send :'.$message;
    }

    #[Route(path: "sendTo/{message}/{to}")]
    public function sendTo(string $message, string $to='nobody') {
        echo "To : {$to} : {$message}";
    }

    #[Get(path: "methods/get", name: 'methods.get')]
    public function testGet() {
        echo 'Test de GET';
    }

    #[Post(path: "methods/post", name: "methods.get")]
    public function testPost() {
        echo "Test de post avec datas :";
        var_dump($_POST);
    }

    #[Route(path: "methods/multi", methods: ['get','post'])]
    public function testMulti() {
        echo 'Test avec GET ou POST';
    }

    #[Get(path: "bar", name: 'bar')]
    public function barMethod() {}

    public function display() {}

    public function move(int $position) {}
	
	public function sendMessage($message){
		$this->loadView('TestControllerRouter/sendMessage.html');
	}

    public function test() {
        echo 'Test de GET';
    }

}
