<?php

namespace App\Controllers;

use App\Models\Timbre;
use App\Models\Enchere;
use App\Models\Offre;

use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

use App\Models\Image;
use App\Models\Conditions;
use App\Models\Couleur;
use App\Models\PaysOrigine;
use App\Models\Membre;

use DateTime;

class OffreController {

    public function store($data){

        Auth::session();

        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){

            $membre_id = $_SESSION['user_id'];

            $validator = new Validator;
            $validator->field('montant', $data['montant'], "Montant")->required()->float();
            $validator->field('enchere_id', $data['enchere_id'], "Enchere ID")->required()->positiveInt();

            $enchere = new Enchere;
            $enchereSelectId = $enchere->selectId($data['enchere_id']);

            if($data['montant'] <= $enchereSelectId['prix_courant']){
                $validator->addError('montant', 'Le montant de la mise doit etre plus elevee que le prix courant');
            }

            if($validator->isSuccess()){
                $offre = new Offre;
                $newData = ['montant' => $data['montant'], 'enchere_id' => $data['enchere_id'], 'membre_id' => $membre_id];
                $insert = $offre->insert($newData);

                //updater le prix_courant de l'enchere
                $updateData = ['date_de_debut' => $enchereSelectId['date_de_debut'], 'date_de_fin' => $enchereSelectId['date_de_fin'],'prix_plancher' => $enchereSelectId['prix_plancher'],'prix_courant' => $data['montant'], 'coups_de_coeur', $enchereSelectId['coups_de_coeur'], 'timbre_id' => $enchereSelectId['timbre_id'], 'membre_id' => $enchereSelectId['membre_id']];

                $updateEnchere = $enchere->update($updateData, $data['enchere_id']);
               if($updateEnchere) return View::redirect('enchere/show?id='.$data['enchere_id']);
            }
            else {
                $errors = $validator->getErrors();

                $timbre_id = $enchereSelectId['timbre_id'];

                $timbre = new Timbre;
                $timbreSelectId = $timbre->selectId($timbre_id);

                $date_de_debut = $enchereSelectId['date_de_debut'];
                $date_de_fin = $enchereSelectId['date_de_fin'];
                $debut = new DateTime();
                $fin = new DateTime($date_de_fin);
                $difference = $debut->diff($fin);
                $temps = $difference->format('%a days, %h hours, %i minutes');

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
                $offreSelect = $offre->selectWhere('enchere_id', $data['enchere_id'] , 'id', 'DESC');
                $offreCount = count($offreSelect);

                //Trouver qui a fais la derniere offre
                if($offreSelect != null) $offreSelectId = $offre->selectId($offreSelect[0]['id']);
                $membre = new Membre;
                if($offreSelect != null && empty($offreSelectId) == false){
                    $membreSelectId = $membre->selectId($offreSelectId['membre_id']);
                    $membreName = $membreSelectId['nom'];
                }
                else {
                    $membreName = 'Aucun';
                }

                $estActif = $this->checkActif($debut, $fin);

                return View::render('enchere/show', ['errors' => $errors, 'enchere' => $enchereSelectId, 'temps' => $temps, 'timbre' => $timbreSelectId, 'images' => $imageSelect, 'couleur' => $couleurName, 'pays' => $paysdOrigine, 'condition' => $conditionName, 'nombreDeMises' => $offreCount, 'nomdeMembre' => $membreName, 'estActif' => $estActif]);
            }
        }
        else {
            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

    function checkActif($debut, $fin){
        if($debut > $fin) return false;
        else return true;
    }

    public function index(){

        Auth::session();

        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){

            $membre_id = $_SESSION['user_id'];

            $offre = new Offre;
            $offreSelected = $offre->selectWhere('membre_id', $membre_id, 'id');

            $newDatas = array();

            foreach ($offreSelected  as $key => $value) {

                $enchere = new Enchere;
                $enchereSelectedId = $enchere->selectId($value['enchere_id']);
                $prix_courant = $enchereSelectedId['prix_courant'];

                $timbre = new Timbre;
                $timbreSelectedId = $timbre->selectId($enchereSelectedId['timbre_id']);
                $nom_du_timbre = $timbreSelectedId['nom'];

                $newData = ['enchere_id' => $enchereSelectedId['id'],'montant' => $value['montant'], 'date_de_loffre' => $value['date_de_loffre'], 'prix_courant_denchere' => $prix_courant, 'nom_du_timbre' => $nom_du_timbre];

                array_push($newDatas, $newData);
            }

            return View::render("offre/index", ['datas' => $newDatas]);
        }
        else {
            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

}