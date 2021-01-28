<?php
namespace controllers;
use http\Header;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\Router;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;

 /**
  * Controller TodosController
  */
class TodosController extends ControllerBase{
    const CACHE_KEY = 'datas/lists/';
    const EMPTY_LIST_ID = 'not saved';
    const LIST_SESSION_KEY = 'list';
    const ACTIVE_LIST_SESSION_KEY = 'active-list';

	public function initialize(){
		parent::initialize();
		$this->menu();
	}

    #[Route(path:"_default", name:'home' )]
    public function index(){
        if(USession::exists(self::LIST_SESSION_KEY)) {
            $list = USession::get(self::LIST_SESSION_KEY, []);
            return $this->display($list);
        }
        $this->showMessage('Bienvenue !', 'TodoLists permet de gerer des listes...', 'info', 'info circle outline');
    }


	#[Post(path: "todos/add", name: "todos.add")]
    public function addElement(){
        $list=USession::get(self::LIST_SESSION_KEY);

        if(URequest::has('elements')){
            $elements=explode("/n",URequest::post('elements'));
            foreach ($elements as $elm){
                $list[]=$elm;
            }
        }else {
            $list[] = URequest::post('elements');
        }

        USession::set(self::LIST_SESSION_KEY,$list);
        $this->display($list);
    }

    #[Get(path: "todos/delete/{index}", name: "todos.delete")]
    public function deleteElement($index){

    }

    #[Post(path: "todos/edit/{index}", name: "todos.edit")]
    public function editElement($index){

    }

    #[Get(path: "todos/loadList/{uniqid}", name: "todos.loadList")]
    public function loadList($uniqid){

    }

    #[Get(path: "todos/new/{force}", name: "todos.new")]
    public function nexList($force){

    }

    #[Post(path: "todos/loadList/{}", name: "todos.loadListPost")]
    public function loadListFromForm($index){

    }

    #[Get(path: "todos/saveList/{}", name: "todos.save")]
    public function saveList(){

    }

    public function menu() {
        $this->loadView('TodosController/menu.html');
        $this->loadView('TodosController/display.html');
        $this->showMessage();
    }

    public function display(array $list) {
        $this->loadView('TodosController/display.html', ['list'=>$list]);
    }

    public function testJquery(){
        $this->jquery->click('button',"$('.elm').toggle();");
        $this->jquery->renderDefaultView();
    }

    public function showMessage(){
        $this->loadView('TodosController/index.html');
    }

}
