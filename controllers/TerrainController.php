<?php


class TerrainController

{
    // get one
    // or get all
    public function getAction($request) {
        $pdo = new bdd();
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
                header("HTTP/1.1 200 terrain deleted");
            } else {
                // header 404
                header("HTTP/1.1 404 terrain unkonow");
            }
            
            return [];
        }
    }
    
    // update
    public function putAction($request) {
        $parameters = $request->parameters;
        // parse parameters
        $id = $parameters["id"];
        $available = $parameters["available"];

        $pdo = new bdd();
        $pdo->exec("UPDATE terrain SET available = $available WHERE id = $id");
        // get object terrain by id :
        $obj = $pdo->select("SELECT * FROM terrain WHERE id = " . $id);
        
        // http 200
        header("HTTP/1.1 200 terrain updated");
        $data = $obj;
        return $obj;
    }
    
    // create
    public function postAction($request) {
        $data = [];
        $parameters = $request->parameters;
        if ($parameters != null) {
            // parse parameter available
            $available = $parameters["available"];
            
            $pdo = new bdd();
            $id_inserted = $pdo->create("INSERT INTO terrain (available) VALUES ($available)");
            
            // get object terrain by id :
            $obj = $pdo->select("SELECT * FROM terrain WHERE id = " . $id_inserted);
            
            $data = $obj;
            // http 200
            header("HTTP/1.1 200 Terrain created");
            return $data;
        }
        // http 404
        header("HTTP/1.1 404 Missing parameters");
        return $data;
    }
}

?>