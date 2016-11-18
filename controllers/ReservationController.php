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
            $data =  $pdo->select('SELECT * FROM reservation WHERE id = ' . $id_reservation);
        } else {
            // get all
            $data =  $pdo->select('SELECT * FROM reservation'); 
        }
        return $data;
    }
    
    // delete
    public function deleteAction($request) {
        if(isset($request->url_elements[2])) {
            $id_reservation = (int)$request->url_elements[2];
            // delete id = $id_terrain
            $pdo = new bdd();
            $nb = $pdo->exec('DELETE FROM reservation WHERE id = ' . $id_reservation);
            
            if ($nb == 1){
                $data = "La reservation ". $id_reservation .' a été supprimée';
            } else {
                $data = "Cette réservation n'existe pas";
            }
            return $data;
        }
    }
    
    // update
     public function putAction($request) {
        $data = $request->parameters;
        // parse parameters
        
        $data = "Les données ont été mise à jour";
        return $data;
    }
    
    // create
    public function postAction($request) {
        $data = $request->parameters;
        // parse parameters
        
        $data = "Les données ont été enregistrées";
        return $data;
    }
}

?>
