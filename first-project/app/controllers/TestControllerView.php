<?php
namespace controllers;

 /**
 * Controller TestControllerView
 **/
class TestControllerView extends ControllerBase{
	public function index(){
		$this->loadDefaultView(['folder'=>__DIR__,'class'=>__CLASS__]);
	}




    public function page(string $page = 'Home') {
        $pages = [
            'Home' => ['Présentation du framework', 'Help', 'Recherche'],
            'Help' => ['Accès au guide', 'API'],
            'Not found' => ['Page inexistante']
        ];
        $menu=$this->loadView('TestControllerView/menu.html',['menu'=>\array_keys($pages)],true);
        $this->loadView('TestControllerView/page.html', ['menu'=>$menu,'title' => $page, 'content' => $pages[$page] ?? $pages['Not found']]);
    }

}
