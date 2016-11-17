<?php

class bdd {
    public $pdo;
    public $db = 'webservice';
    
    public function __construct() {
        $this->connect();
    }
    
    public function connect(){
        $this->pdo = new PDO('mysql:host=localhost;dbname='.$this->db, 'root', '');       
    }
    
    // insert or delete
    public function exec($sql) {  
        $res = $this->pdo->exec($sql);     
        return $res;
    }
    
    // execute un select
    // retourne un tableau de data
    function select($sql){
        $req = $this->pdo->query($sql);
        $req->execute($req);
        return $req->fetchAll();
    }
    

}