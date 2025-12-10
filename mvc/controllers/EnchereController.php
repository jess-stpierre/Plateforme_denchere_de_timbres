<?php

namespace App\Controllers;

use App\Models\Timbre;
use App\Models\Image;
use App\Models\Enchere;
use App\Models\Conditions;
use App\Models\Couleur;
use App\Models\PaysOrigine;

use App\Providers\View;
use App\Providers\Auth;
use DateTime;

class EnchereController {

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

        return View::render("enchere/index", ['datas' => $datas]);
    }

    public function show($data = []){

        Auth::session();

        if(isset($data['id']) && $data['id'] != null){

            $enchere_id = $data['id'];
            $enchere = new Enchere;
            $enchereSelectId = $enchere->selectId($enchere_id);

            $timbre_id = $enchereSelectId['timbre_id'];

            $timbre = new Timbre;
            $timbreSelectId = $timbre->selectId($timbre_id);

            $date_de_debut = $enchereSelectId['date_de_debut'];
            $date_de_fin = $enchereSelectId['date_de_fin'];
            $debut = new DateTime();
            $fin = new DateTime($date_de_fin);
            $difference = $debut->diff($fin);
            $temps = $difference->format('%a days, %h hours, %i minutes');

            if($timbreSelectId) {

                $image = new Image;
                $imageSelect = $image->selectWhere('timbre_id', $timbre_id, 'ordre_daffichage');

                $couleur_id = $timbreSelectId['couleur_id'];
                $couleur = new Couleur;
                $selectCouleur = $couleur->selectId($couleur_id);
                $couleurName = $selectCouleur['nom'];

                $pays_id = $timbreSelectId['pays_dorigine_id'];
                $pays = new PaysOrigine;
                $selectPays = $pays->selectId($pays_id);
                $paysdOrigine = $selectPays['nom'];

                $cond_id = $timbreSelectId['conditions_id'];
                $condition = new Conditions;
                $selectCond = $condition->selectId($cond_id);
                $conditionName = $selectCond['nom'];

                return View::render('enchere/show', ['enchere' => $enchereSelectId, 'temps' => $temps, 'timbre' => $timbreSelectId, 'images' => $imageSelect, 'couleur' => $couleurName, 'pays' => $paysdOrigine, 'condition' => $conditionName]);
            }
            else {

                return View::render('error', ['msg' => 'Enchere pas trouvee!']);
            }
        }
        else {

            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }
}