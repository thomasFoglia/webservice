<?php


class TerrainController

{
    // get one
    // or get all
    public function getAction($request) {
        if(isset($request->url_elements[2])) {
            // get id = $id_terrain
            $id_terrain = (int)$request->url_elements[2];
            // get in BDD
            $data["message"] = "";
        } else {
            // get all
            $data["message"] = "";
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
                $data["message"] = "Le terrain ". $id_terrain .' a été supprimé';
            } else {
                $data["message"] = "Ce terrain n'existe pas";
            }
            return $data;
        }
    }
    
    // update
     public function putAction($request) {
        $data = $request->parameters;
        // parse parameters
        
        $data['message'] = "Les données ont été mise à jour";
        return $data;
    }
    
    // create
    public function postAction($request) {
        $data = $request->parameters;
        // parse parameters
        
        $data['message'] = "Les données ont été enregistrées";
        return $data;
    }
}

?>