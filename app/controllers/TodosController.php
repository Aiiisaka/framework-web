<?php
namespace controllers;

use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Route;

use Ubiquity\controllers\Router;

use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;

use Ubiquity\cache\CacheManager;

 /**
  * Controller TodosController
  */
class TodosController extends ControllerBase {
    const CACHE_KEY = 'datas/lists/';
    const EMPTY_LIST_ID = 'not saved';
    const LIST_SESSION_KEY = 'list';
    const ACTIVE_LIST_SESSION_KEY = 'active-list';

	public function initialize(){
		parent::initialize();
		$this->menu();
	}

    #[Route(path: "todos/home", name: "todos.home")]
    public function index(){
        if (USession::exists(self::LIST_SESSION_KEY)) {
            $list = USession::get(self::LIST_SESSION_KEY, []);
            return $this->display($list);
        } else {
            return $this->showMessage('Bienvenue !', 'TodoLists permet de gérer des listes...', 'info', 'info circle outline'
            [['url' =>Router::path('todos.new'),'caption'=>'Créer une nouvelle liste','style'=>'basic inverted']]);
        }
    }


	#[Post(path: 'todos/add', name: 'todos.add')]
    public function addElement(){
        $list = USession::get(self::LIST_SESSION_KEY);

        if (URequest::has('elements')) {
            if (preg_match("[\r\n]", URequest::post('elements'))) {
                $elements = explode("\n", URequest::post('elements'));

                foreach ($elements as $elm){
                    $list[] = $elm;
                }
            } else {
                $list[] = URequest::post('element');
            }
        } else {
            $list[] = URequest::post('element');
        }

        $this->showMessage('Élément ajouté !', "L'élément a été correctement ajouté à la liste ...", 'info', 'check square');
        USession::set(self::LIST_SESSION_KEY,$list);
        $this->display($list);
    }

    #[Get(path: 'todos/delete/{index}', name: 'todos.delete')]
    public function deleteElement($index){
        $list=USession::get(self::LIST_SESSION_KEY);

        if (isset($list[$index])) {
            array_splice($list, $index, 1);
            USession::set(self::LIST_SESSION_KEY, $list);
            $this->showMessage('Élément supprimé !', "L'élément a été correctement retiré ...", 'info', 'check square');
        }

        $this->display($list);
    }

    #[Post(path: 'todos/edit/{index}', name: 'todos.edit')]
    public function editElement($index){
        $list=USession::get(self::LIST_SESSION_KEY);

        if (isset($list[$index])) {
            $list[$index] = URequest::post('editElement');
            USession::set(self::LIST_SESSION_KEY, $list);
            $this->showMessage('Élément modifié !', "L'élément a bien été modifié ...", 'info', 'check square');
        }

        $this->display($list);
    }

    #[Get(path: 'todos/loadList/{uniqid}', name: 'todos.loadList')]
    public function loadList($uniqid){
        if (CacheManager::$cache->exists(self::CACHE_KEY . $uniqid)) {
            $list = CacheManager::$cache->fetch(self::CACHE_KEY . $uniqid);
            USession::set(self::LIST_SESSION_KEY, $list);
            $this->showMessage("Chargement de la Liste", $uniqid);
        }

        $this->display($list);
    }

    #[Get(path: 'todos/new/{force}', name: 'todos.new')]
    public function newList($force = false){
        if ($force != false || !USession::exists(self::LIST_SESSION_KEY)){
            USession::set(self::LIST_SESSION_KEY, []);
            $this->showMessage('Nouvelle Liste', "La liste a été correctement créé", 'info', 'check square');
            $this->display(USession::get(self::LIST_SESSION_KEY));
        } else if (USession::exists(self::LIST_SESSION_KEY)) {

            $this->showMessage("Nouvelle Liste", "Une liste existe déjà. Voulez-vous la supprimer ?", "", "",
                [['url' =>Router::path('todos.new', array(true)),'caption'=>'Créer une nouvelle liste','style'=>'basic inverted'],
                    ['url' =>Router::path('todos.home'),'caption'=>'Annuler','style'=>'basic inverted']]);

            $this->display(USession::get(self::LIST_SESSION_KEY));
        }
    }

    #[Post(path: 'todos/loadList', name: 'todos.loadListPost')]
    public function loadListFromForm(){
        $id = URequest::post('id'); // Retrouver l'ID

        if (CacheManager::$cache->exists(self::CACHE_KEY . $id)) {
            $list = CacheManager::$cache->fetch(self::CACHE_KEY . $id);
            $this->showMessage("Chargement de la liste ", $id);
            $this->display($list);
        } else {
            $this->showMessage("Pas de liste disponible !", "Veuillez créer une liste ...");
        }
    }

    #[Get(path: 'todos/saveList', name: 'todos.save')]
    public function saveList(){
        $id = uniqid(); // Création d'un identifiant
        $list=USession::get(self::LIST_SESSION_KEY);
        CacheManager::$cache->store(self::CACHE_KEY . $id, $list);

        $this->showMessage('Sauvegarde de la liste !', "La liste a été sauvegardée sous l'id $id.\n", 'info', 'check square');
        $this->display($list);
    }

    public function menu() {
        $this->loadView('TodosController/menu.html');
    }

    public function display(array $list) {
        if (count($list)>0) {
            $this->jquery->show('_saveList','','',false);
        }

        $this->jquery->change('#multiple', '$("._form").toggle();');
        $this->jquery->click(".buttonEdit", '$(".item" + this.id).toggle();');


        $id = URequest::post('id'); // Retrouver l'ID

        if (CacheManager::$cache->exists(self::CACHE_KEY . $id)) {
            $ident[] = $id;
        } else {
            $ident[] = "Pas enregistré !";
        }


        $this->jquery->renderView('TodosController/display.html', ['id'=>$ident, 'list'=>$list]);
    }

    /*
    public function testJquery(){
        $this->jquery->click('button',"$('.elm').toggle();");
        $this->jquery->renderDefaultView();
    }
    */

    #[Route(path: "todos/createAccount", name: "todos.createAccount")]
    public function createAccount(){
        $this->loadView('TodosController/createAccount.html');
    }

    public function showMessage(string $header,string $message,string $type = 'info',string $icon = 'info circle',array $buttons = []){
        $this->loadView('TodosController/index.html',
            compact('header', 'message','type', 'icon', 'buttons'));
    }
}