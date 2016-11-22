<?php


class TerrainController

{
    // get one
    // or get all
    public function getAction($request) {
        $pdo = new bdd();
        // un id de terrain passé en paramètre
        if(isset($request->url_elements[2]) && $request->url_elements[2] != '') {
            // get id = $id_terrain
            $id_terrain = (int)$request->url_elements[2];
            // get in BDD
            $data = $pdo->select('SELECT * FROM terrain WHERE id = ' . $id_terrain);
        } else {
            // get all
            $data = $pdo->select('SELECT * FROM terrain');
        }
        
        return $data;
    }
    
    // delete
    public function deleteAction($request) {
        if(isset($request->url_elements[2])) {
            $id_terrain = (int)$request->url_elements[2];
            // delete id = $id_terrain
            $pdo = new bdd();
            $nb = $pdo->exec('DELETE FROM terrain WHERE id = ' . $id_terrain);
            
            if ($nb == 1){
                // http 200
                header("HTTP/1.1 200 Sucessfully terrain deleted");
            } else {
                // header 404
                header("HTTP/1.1 404 terrain not found");
            }
            
            return [];
        }
    }
    
    // update
    public function putAction($request) {
        $parameters = $request->parameters;
        $pdo = new bdd();
         // parse parameters
        // id required !
        if(!isset($parameters["id"]) || $parameters["id"] == '' ) {
            header("HTTP/1.1 404 Missing Parameter Id");
            return [];
        } else {
            $id = $parameters["id"];
        }
        
        $my_terrain = $pdo->select('SELECT * FROM terrain where id='.$id.'');
        
        if(!isset($parameters["available"]) || $parameters["available"] == '' ) {
            $available = $my_terrain[0]["available"];
        } else {
            $available = $parameters["available"];
        }


        $pdo->exec("UPDATE terrain SET available = $available WHERE id = $id");
        // get object terrain updated
        $obj = $pdo->select("SELECT * FROM terrain WHERE id = " . $id);
        
        // http 200
        header("HTTP/1.1 200 Sucessfully terrain updated");
        return $obj;
    }
    
    // create
    public function postAction($request) {
        $data = [];
        $parameters = $request->parameters;
        if(isset($request->parameters['available']) &&  $request->parameters['available'] != null) {
            // parse parameter available
            $available = $parameters["available"];

            $pdo = new bdd();
            $id_inserted = $pdo->create("INSERT INTO terrain (available) VALUES ($available)");

            // get object terrain inserted :
            $obj = $pdo->select("SELECT * FROM terrain WHERE id = " . $id_inserted);

            $data = $obj;
            // http 200
            header("HTTP/1.1 200 Terrain created");
            return $data;
        } else {
            header("HTTP/1.1 404 Missing Parameter Available");
            return [];
        }
    }
}

?>