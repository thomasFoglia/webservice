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
                header("HTTP/1.1 200 Sucessfully deleted");
            } else {
                header("HTTP/1.1 404 Reservation not found");
            }
            return [];
        }
    }
    
    // update
     public function putAction($request) {
        $parameters = $request->parameters;
        $pdo = new bdd();

        $id = $parameters["id"];
        
        $my_resa = $pdo->select('SELECT * FROM reservation where id='.$id.'');
        
        if(isset($parameters["heure_reservation"]) && $parameters["heure_reservation"] != '' ) {
            $heure = $parameters["heure_reservation"];
        } else {
            $heure = $my_resa[0]["heure_reservation"];
        }

        if(isset($parameters["id_terrain"]) && $parameters["id_terrain"] != '') {
             $terrainId = $parameters["id_terrain"];
        } else {
            $terrainId = $my_resa[0]["id_terrain"];
        }   

        $heure = strtotime($heure);
        $heure = date('Y-m-d H',$heure);
        // Si heure valide
        if ($this->validateDate($heure)) {
            /*Vérifier si changement possible*/
            $exist = $pdo->select('SELECT * FROM reservation where id_terrain= '.$terrainId.' and heure_reservation = "'.$heure.'"');
            if(empty($exist)) {
                $pdo->exec("UPDATE reservation SET id_terrain = $terrainId ,heure_reservation = '$heure'  WHERE id = $id");

                $obj = $pdo->select("SELECT * FROM reservation WHERE id = " .$id);
                $data = $obj;
                header("HTTP/1.1 200 Sucessfully updated");
            } else {
                $data = [];
                header("HTTP/1.1 404 Terrain is already taken ");
            }
        } else {
            $data = [];
             header("HTTP/1.1 404 Bad Parameter Date");
        }
        return $data;
    }
    
    // create
    public function postAction($request) {
        $pdo = new bdd();
        if(isset($request->parameters['heure_reservation']) &&  $request->parameters['heure_reservation'] != null) {

            $data = strtotime($request->parameters['heure_reservation']);
            $data = date('Y-m-d H',$data);

            $dateCompare = new DateTime($data.":00:00");
            $now = new DateTime("now");
            
            if ($this->validateDate($data)) {
                if ($dateCompare > $now) {
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
                    header("HTTP/1.1 404 Past Date");
                }
            } else {
                 $data = [];
                 header("HTTP/1.1 404 Bad Parameter Date");
            }

        } else {
            $data = [];
            header("HTTP/1.1 404 No Date Input");
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
