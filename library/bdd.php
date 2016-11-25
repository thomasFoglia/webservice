<?php
/**
* Classe permettant de gérer les accès à la BDD
**/
class bdd {
    public $pdo;
    public $db = 'u627327885_sq';
    
    public function __construct() {
        $this->connect();
    }
    
    public function connect(){
        $this->pdo = new PDO('mysql:host=localhost;dbname='.$this->db, 'u627327885_user', 'root38');      
    }
    

    // delete
    // retourne nombre de row affectés
    public function exec($sql) {  
        $res = $this->pdo->exec($sql);     
        return $res;
    }
    
    // insert / update
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