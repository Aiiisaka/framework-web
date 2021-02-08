<?php
namespace models;

use Ubiquity\attributes\items\Id;
use Ubiquity\attributes\items\Column;
use Ubiquity\attributes\items\Validator;
use Ubiquity\attributes\items\Table;
use Ubiquity\attributes\items\OneToMany;

#[Table(name: "organisation")]
class Organisation {

    #[Id()]
    #[Column(name: "id",dbType: "int(11)")]
    #[Validator(type: "id",constraints: ["autoinc"=>true])]
    private $id;


    #[Column(name: "name",dbType: "varchar(100)")]
    #[Validator(type: "length",constraints: ["max"=>100,"notNull"=>true])]
    private $name;


    #[Column(name: "domain",dbType: "varchar(255)")]
    #[Validator(type: "length",constraints: ["max"=>255,"notNull"=>true])]
    private $domain;


    #[Column(name: "aliases",nullable: true,dbType: "text")]
    private $aliases;


    #[OneToMany(mappedBy: "organisation",className: "models\\Groupe")]
    private $groupes;


    #[OneToMany(mappedBy: "organisation",className: "models\\OrganisationSettings")]
    private $organisationsettingss;


    #[OneToMany(mappedBy: "organisation",className: "models\\User")]
    private $users;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name=$name;
    }

    public function getDomain(){
        return $this->domain;
    }

    public function setDomain($domain){
        $this->domain=$domain;
    }

    public function getAliases(){
        return $this->aliases;
    }

    public function setAliases($aliases){
        $this->aliases=$aliases;
    }

    public function getGroupes(){
        return $this->groupes;
    }

    public function setGroupes($groupes){
        $this->groupes=$groupes;
    }

    public function addGroupe($groupe){
        $this->groupes[]=$groupe;
    }

    public function getOrganisationSettingss(){
        return $this->organisationsettingss;
    }

    public function setOrganisationSettingss($organisationsettingss){
        $this->organisationsettingss=$organisationsettingss;
    }

    public function addOrganisationSettings($organisationsettingss){
        $this->organisationsettingss[]=$organisationsettingss;
    }

    public function getUsers(){
        return $this->users;
    }

    public function setUsers($users){
        $this->users=$users;
    }

    public function addUser($user){
        $this->users[]=$user;
    }

    public function __toString(){
        return $this->name.'';
    }

}