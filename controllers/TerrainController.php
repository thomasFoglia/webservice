<?php

<<<<<<< HEAD
class TerrainController 
=======
class TerrainController
>>>>>>> origin/master
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
            
            $data["message"] = "Données supprimées";
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