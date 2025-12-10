<?php

namespace App\Controllers;

use App\Models\Timbre;
use App\Models\Image;
use App\Models\Enchere;
use App\Models\Conditions;
use App\Models\Couleur;
use App\Models\PaysOrigine;

use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

use DateTime;

class HomeController {

    public function index(){

        $enchere = new Enchere;
        $enchereSelect = $enchere->select();

        $datas = array();

        for ($i=0; $i < count($enchereSelect); $i++) {

            $enchere_id = $enchereSelect[$i]['id'];
            $encherePrix = $enchereSelect[$i]['prix_courant'];

            $timbre_id = $enchereSelect[$i]['timbre_id'];
            $timbre = new Timbre;
            $timbreSelected = $timbre->selectId($timbre_id);
            $timbreName = $timbreSelected['nom'];

            $image = new Image;
            $imageSelect = $image->selectWhere('timbre_id', $timbre_id, 'ordre_daffichage');
            $url = $imageSelect[0]['image_url'];
            if(!empty($imageSelect[0]['description_courte'])) $description = $imageSelect[0]['description_courte'];
            else $description = "Image du timbre: " . $timbreName;

            $date_de_debut = $enchereSelect[$i]['date_de_debut'];
            $date_de_fin = $enchereSelect[$i]['date_de_fin'];

            $debut = new DateTime();
            $fin = new DateTime($date_de_fin);
            $difference = $debut->diff($fin);
            $temps = $difference->format('%a days, %h hours, %i minutes');

            $datas[$i] = ['id' => $enchere_id, 'nom' => $timbreName, 'prix' => $encherePrix, 'url' => $url, 'description' => $description, 'temps' => $temps];
        }

        return View::render("home", ['datas' => $datas]);
    }
}

?>