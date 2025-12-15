<?php

namespace App\Controllers;

use App\Models\Timbre;
use App\Models\Image;
use App\Models\Enchere;
use App\Models\Conditions;
use App\Models\Couleur;
use App\Models\PaysOrigine;
use App\Models\Offre;
use App\Models\Membre;

use App\Providers\View;
use App\Providers\Auth;
use DateTime;

class EnchereController {

    public function index(){

        $enchere = new Enchere;
        $enchereSelect = $enchere->select();

        $datas = array();

        $annees = ["1800 - 1850", "1851 - 1900", "1901 - 1950", "1951 - 2000", "2001 - 2050"];
        $certifies = ["Oui", "Non"];
        $prixList = ["0 - 25", "26 - 50", "51 - 100", "101 - 300", "301 - 700", "701 et +"];

        for ($i=0; $i < count($enchereSelect); $i++) {

            $enchere_id = $enchereSelect[$i]['id'];
            $encherePrix = $enchereSelect[$i]['prix_courant'];

            $timbre_id = $enchereSelect[$i]['timbre_id'];
            $timbre = new Timbre;
            $timbreSelected = $timbre->selectId($timbre_id);
            $timbreName = $timbreSelected['nom'];

            //filtre couleur
            $couleur_id = $timbreSelected['couleur_id'];
            $couleur = new Couleur;
            $couleurSelected = $couleur->selectId($couleur_id);
            $couleurName = $couleurSelected['nom'];

            //filtre annee
            $date_de_creation = $timbreSelected['date_de_creation'];
            $date = new DateTime($date_de_creation);
            $annee = (int)$date->format('Y');
            $anneeSelected = "";

            if($annee >= 1800 && $annee <= 1850){
                $anneeSelected = $annees[0];
            }
            else if($annee >= 1851 && $annee <= 1900){
                $anneeSelected = $annees[1];
            }
            else if($annee >= 1901 && $annee <= 1950){
                $anneeSelected = $annees[2];
            }
            else if($annee >= 1951 && $annee <= 2000){
                $anneeSelected = $annees[3];
            }
            else {
                $anneeSelected = $annees[4];
            }

            //filtre certifie
            $certifieSelect = "";
            $certifier = $timbreSelected['certifie'];
            if($certifier == 1){
                $certifieSelect = "Oui";
            }
            else {
                $certifieSelect = "Non";
            }

            //filtre pays
            $pays_id = $timbreSelected['pays_dorigine_id'];
            $pays = new PaysOrigine;
            $paysSelected = $pays->selectId($pays_id);
            $paysName = $paysSelected['nom'];

            //filtre conditions
            $cond_id = $timbreSelected['conditions_id'];
            $condition = new Conditions;
            $condSelected = $condition->selectId($cond_id);
            $condName = $condSelected['nom'];

            //filtre prix
            $prix_courant = $encherePrix;
            $prixSelected = $this->checkPrice($prix_courant, $prixList);

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

            $offre = new Offre;
            $offreSelect = $offre->selectWhere('enchere_id', $enchere_id , 'id');
            $offreCount = count($offreSelect);

            $datas[$i] = ['id' => $enchere_id, 'nom' => $timbreName, 'prix' => $encherePrix, 'url' => $url, 'description' => $description, 'temps' => $temps, 'nombreDeMises' => $offreCount, 'couleur' => $couleurName, 'annee' => $anneeSelected, 'pays' => $paysName, 'condition' => $condName, 'certifie' => $certifieSelect, 'prixx' => $prixSelected];
        }

        $couleur = new Couleur;
        $selectCouleur = $couleur->select();

        $pays = new PaysOrigine;
        $selectPays = $pays->select();

        $condi = new Conditions;
        $selectCond = $condi->select();

        return View::render("enchere/index", ['datas' => $datas, 'couleurs' => $selectCouleur, 'annees' => $annees, 'paysdorigines' => $selectPays, 'conditions' => $selectCond, 'certifies' => $certifies, 'prixx' => $prixList]);
    }

    function checkPrice($prix_courant, $prixList){
        if($prix_courant >= 0 && $prix_courant <= 25){
            return $prixList[0];
        }
        else if($prix_courant >= 26 && $prix_courant <= 50){
            return $prixList[1];
        }
        else if($prix_courant >= 51 && $prix_courant <= 100){
            return $prixList[2];
        }
        else if($prix_courant >= 101 && $prix_courant <= 300){
            return $prixList[3];
        }
        else if($prix_courant >= 301 && $prix_courant <= 700){
            return $prixList[4];
        }
        else {
            return $prixList[5];
        }
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

                $offre = new Offre;
                $offreSelect = $offre->selectWhere('enchere_id', $enchere_id , 'id', 'DESC');
                $offreCount = count($offreSelect);

                //Trouver qui a fais la derniere offre
                $recentOffre = $offreSelect[0] ?? null;
                if($recentOffre != null) $offreSelectId = $offre->selectId($recentOffre['id']);
                $membre = new Membre;
                if(empty($offreSelectId) == false){
                    $membreSelectId = $membre->selectId($offreSelectId['membre_id']);
                    $membreName = $membreSelectId['nom'];
                }
                else {
                    $membreName = 'Aucun';
                }

                return View::render('enchere/show', ['enchere' => $enchereSelectId, 'temps' => $temps, 'timbre' => $timbreSelectId, 'images' => $imageSelect, 'couleur' => $couleurName, 'pays' => $paysdOrigine, 'condition' => $conditionName, 'nombreDeMises' => $offreCount, 'nomdeMembre' => $membreName]);
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