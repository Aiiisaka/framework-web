<?php
namespace controllers;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Post;
 /**
 * Controller TestControllerRouter
 **/
#[Route('test')]
class TestControllerRouter extends ControllerBase{
	public function index(){}


	#[Route(path: "message")]
	public function message(){
        echo 'Affiché via la route /message';
	}
    #[Route(path: "msg/{title}/{content}/{icon}")]
    public function msg(string $title,string $content,string $icon){
        $this->loadView('TestControllerRouter/message.html', ['title' => $title, 'content' => $content,'icon' => $icon ?? 'Page inexistante']);
    }
    #[Route(path: "send/{message}")]
    public function send(string $message) {
        echo 'Affiché via la route /send :'.$message;
    }
    #[Get(path: "methods/get")]
    public function testGet() {
        echo 'Test de GET';
    }

    #[Post(path: "methods/post")]
    public function testPost() {
        echo "Test de post avec datas :";
        var_dump($_POST);
    }
    #[Route(path: "methods/multi", methods: ['get','post'])]
    public function testMulti() {
        echo 'Test avec GET ou POST';
    }
    #[Get(path: "methods/get", name: 'methods.get')]
    public function testGet2() {}

    #[Get(path: "bar", name: 'bar')]
    public function barMethod() {}
    /*#[Route(path: "sendTo/{message}/{to}")]
    public function send(string $message, string $to='nobody') {
        echo "To : {$to} : {$message}";
    }*/
}
