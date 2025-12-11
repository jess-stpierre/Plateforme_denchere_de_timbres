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
                $offre = new offre;
                $newData = ['montant' => $data['montant'], 'enchere_id' => $data['enchere_id'], 'membre_id' => $membre_id];
                $insert = $offre->insert($newData);

                return View::redirect('enchere/show?id='.$data['enchere_id']);
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

                return View::render('enchere/show', ['errors' => $errors, 'enchere' => $enchereSelectId, 'temps' => $temps, 'timbre' => $timbreSelectId, 'images' => $imageSelect, 'couleur' => $couleurName, 'pays' => $paysdOrigine, 'condition' => $conditionName]);
            }
        }
        else {
            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

}