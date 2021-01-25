<?php
namespace controllers;

 /**
 * Controller TestController
 **/
class TestController extends ControllerBase{
	public function index(){
	    echo "Hello world!";
    }
    public function send(string $message) {
        echo $message;
    }
    public function sendTo(string $message, ?string $to='World') {
        echo "To: {$to}<br>Message: {$message}";
    }
    public function page( string $page='Home') {
        $pages = [
            'Home' => ['Présentation du framework', 'Help', 'Recherche'],
            'Exemples' => ['Routes', 'Contrôleurs', 'Vues','Scripts Front-end'],
            'Help' => ['Accès au guide', 'API']
        ];
        $menu=$this->loadView('TestControllerView/menu.html',['menu'=>\array_keys($pages)],true);
        $this->loadView('TestControllerView/page.html', ['menu'=>$menu,'title' => $page, 'content' => $pages[$page] ?? 'Page inexistante']);
    }

}
