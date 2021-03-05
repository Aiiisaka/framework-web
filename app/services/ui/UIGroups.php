<?php

namespace services\ui;

use Ajax\php\ubiquity\UIService;
use Ubiquity\controllers\Controller;
use Ubiquity\utils\http\URequest;

class UIGroups extends UIService {
    public function __construct(Controller $controller) {
        parent::__construct($controller);
        if(!URequest::isAjax()) {
            $this->jquery->getHref('a[data-target]', '', ['hasLoader' => 'internal', 'historize' => false,'listenerOn'=>'body']);
        }
    }

    private function addFormBehavior(string $formName,HtmlForm|DataForm $frm,string $responseElement,string $postUrlName) {
        $frm->setValidationParams(["on"=>"blur","inline"=>true]);
        $this->jquery->click("#$formName-div ._validate",'$("#'.$formName.'").form("submit");');
        $this->jquery->click("#$formName-div ._cancel",'$("#'.$formName.'-div").hide();');
        $frm->setSubmitParams(Router::path($postUrlName),'#'.$responseElement,['hasLoader'=>'internal']);
    }

    public function newUsers($formName) {
        $frm=$this->semantic->htmlForm($formName);
        $frm->addTextarea('users','Utilisateurs','',"Entrez chaque utilisateur sur une ligne\nJohn DOE")->addRules(['empty']);
        $this->addFormBehavior($formName,$frm,'new-users','new.usersPost');
    }

    public function newUser($formName) {
        $frm=$this->semantic->dataForm($formName,new User());
        $frm->addClass('inline');
        $frm->setFields(['firstname','lastname']);
        $frm->setCaptions(['Prénom','Nom']);
        $frm->fieldAsLabeledInput('firstname',['rules'=>'empty']);
        $frm->fieldAsLabeledInput('lastname',['rules'=>'empty']);
        $this->addFormBehavior($formName,$frm,'#new-user','new.userPost');
    }

    public function listGroups(array $groups) {
        $dt =$this->semantic->dataTable('dt-groups', Group::class, $groups);
        $dt->setFields(['name']);
    }

    public function orgaForm(\models\Organization $orga) {
        $frm=$this->semantic->dataForm('frmOrga', $orga);
        $frm->setFields(['id', 'name', 'domain', 'submit']);
        $frm->fieldAsHidden('id');
        $frm->fieldAsLabeledInput('name', ['rules'=>'empty']);
        $frm->fieldAsLabeledInput('domain', ['rules'=>['empty','email']]);
        $frm->setValidationParams(["on"=>"blur", "inline"=>true]);
        $frm->fieldAsSubmit('submit','positive', Router::path('addOrga'),"#reponse");
    }
}