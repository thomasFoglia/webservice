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
        $pdo = new bdd();
        $data = strtotime($request->parameters['heure_reservation']);
        $data = date('Y-m-d H',$data);
        if ($this->validateDate($data)) {
            // check si un terrain est dispo avec une requête
            $terrain_libre = $pdo->select('SELECT * FROM terrain t WHERE t.available = 1 and NOT EXISTS( SELECT t.id FROM reservation r WHERE  t.id = r.id_terrain AND r.heure_reservation = "'.$data.'")');
            
            if (!empty($terrain_libre)) {
                $terrainId = $terrain_libre[0]["id"];
                $lastId = $pdo->create("INSERT INTO reservation (heure_reservation,id_terrain) values('$data',$terrainId)");
                $my_resa = $pdo->select('SELECT * FROM reservation WHERE id = '.$lastId);
                $data = $my_resa;
                header("HTTP/1.1 200 Sucessfully created");
            } else {
                $data = [];
                header("HTTP/1.1 404 No terrains available");
            }
            
        } else {
             $data = [];
             header("HTTP/1.1 404 Bad Parameter Date");
        }

        
        // parse parameters
        return $data;
    }

    public function validateDate($date, $format = 'Y-m-d H')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }   
}

?>
