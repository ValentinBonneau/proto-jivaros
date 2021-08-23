<?php


class db
{
    private $SERVER;
    private $BDD;
    private $USER;
    private $MDP;
    private $pdo;

    function __construct($url,$bdd,$user,$mdp)
    {
        $this->SERVER=$url;
        $this->BDD=$bdd;
        $this->USER=$user;
        $this->MDP=$mdp;
    }
    function connect(){
        $this->pdo = new PDO("mysql:host=" . $this->SERVER . ";dbname=" . $this->BDD, $this->USER, $this->MDP);
    }

}