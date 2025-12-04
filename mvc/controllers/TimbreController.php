<?php

namespace App\Controllers;

use App\Models\Timbre;
use App\Models\Conditions;
use App\Models\Couleur;
use App\Models\PaysOrigine;

use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

class TimbreController {

    public function create(){

        Auth::session();

        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){

            $id = $_SESSION['user_id'];

            $conditions = new Conditions;
            $conditionsSelect = $conditions->select('nom');

            $couleur = new Couleur;
            $couleurSelect = $couleur->select('nom');

            $paysOrigine = new PaysOrigine;
            $paysOrigineSelect = $paysOrigine->select('nom');

            return View::render('timbre/create', ['condition'=>$conditionsSelect, 'couleurs'=>$couleurSelect, 'paysOrigines'=>$paysOrigineSelect, 'membre_id'=>$id]);
        }
        else {
            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

    public function store($data){

        Auth::session();

        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){

            $validator = new Validator;
            $validator->field('nom', $data['nom'], "Nom")->min(2)->max(45);
            $validator->field('date_de_creation', $data['date_de_creation'], "Date de Creation")->required()->validateDate();
            $validator->field('description', $data['description'], "Description")->min(6)->max(600);
            $validator->field('tirage', $data['tirage'], "Tirage")->required()->positiveInt();
            $validator->field('dimensions', $data['dimensions'], "Dimensions")->min(3)->max(45);
            $validator->field('couleur_id', $data['couleur_id'], "Couleur")->required()->positiveInt();
            $validator->field('pays_dorigine_id', $data['pays_dorigine_id'], "Pays d'Origine")->required()->positiveInt();
            $validator->field('conditions_id', $data['conditions_id'], "Condition")->required()->positiveInt();

            $id = $_SESSION['user_id'];

            if($validator->isSuccess()){
                $timbre = new Timbre;
                $insert = $timbre->insert($data);
                return View::redirect('timbre/show?id='.$insert);
            }
            else {
                $errors = $validator->getErrors();

                $conditions = new Conditions;
                $conditionsSelect = $conditions->select('nom');

                $couleur = new Couleur;
                $couleurSelect = $couleur->select('nom');

                $paysOrigine = new PaysOrigine;
                $paysOrigineSelect = $paysOrigine->select('nom');

                return View::render('timbre/create', ['errors' => $errors, 'condition'=>$conditionsSelect, 'couleurs'=>$couleurSelect, 'paysOrigines'=>$paysOrigineSelect, 'timbre'=>$data, 'membre_id'=>$id]);
            }
        }
        else {
            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

}


?>