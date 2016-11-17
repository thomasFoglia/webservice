<?php

class ReservationController
{
    // get one
    // or get all
    public function getAction($request) {
        $pdo = new bdd();
        if(isset($request->url_elements[2]) && $request->url_elements[2] != '') {
            

            // get id = $id_terrain
            $id_reservation = (int)$request->url_elements[2];
            // get in BDD
            $datas =  $pdo->select('SELECT * FROM reservation WHERE id = ' . $id_reservation);
            $data["message"] = "";
        } else {
            // get all
            $datas =  $pdo->select('SELECT * FROM reservation'); 
            $data["message"] = "";
        }
        return $datas;
    }
    
    // delete
    public function deleteAction($request) {
        if(isset($request->url_elements[2])) {
            $id_reservation = (int)$request->url_elements[2];
            // delete id = $id_terrain
            $pdo = new bdd();
            $nb = $pdo->exec('DELETE FROM reservation WHERE id = ' . $id_reservation);
            
            if ($nb == 1){
                $data["message"] = "La reservation ". $id_reservation .' a été supprimée';
            } else {
                $data["message"] = "Cette réservation n'existe pas";
            }
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
