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
    
<<<<<<< HEAD
    //delete
    //retourne le nombre de row affectés
=======
    // delete
    // retourne nombre de row affectés
>>>>>>> origin/master
    public function exec($sql) {  
        $res = $this->pdo->exec($sql);     
        return $res;
    }

    // insert / update
    // retourne id ajouté
    public function create($sql) {  
        $res = $this->pdo->exec($sql);     
        return $this->pdo->lastInsertId();
    }
    
    //insert
    //retourn id ajouté
     public function create($sql) {  
        $res = $this->pdo->exec($sql);
        return $this->pdo->lastInsertId();
    }

    // execute un select
    // retourne un tableau de data
    function select($sql){
        $req = $this->pdo->query($sql);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    

}