<?php

namespace App\Controllers;

use App\Models\Timbre;
use App\Models\Conditions;
use App\Models\Couleur;
use App\Models\PaysOrigine;
use App\Models\Image;

use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;
use App\Providers\FileValidator;

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

            $id = $_SESSION['user_id'];

            $validator = new Validator;
            $validator->field('nom', $data['nom'], "Nom")->min(2)->max(45);
            $validator->field('date_de_creation', $data['date_de_creation'], "Date de Creation")->required()->validateDate();
            $validator->field('description', $data['description'], "Description")->min(6)->max(600);
            $validator->field('tirage', $data['tirage'], "Tirage")->required()->positiveInt();
            $validator->field('dimensions', $data['dimensions'], "Dimensions")->min(3)->max(45);
            $validator->field('couleur_id', $data['couleur_id'], "Couleur")->required()->positiveInt();
            $validator->field('pays_dorigine_id', $data['pays_dorigine_id'], "Pays d'Origine")->required()->positiveInt();
            $validator->field('conditions_id', $data['conditions_id'], "Condition")->required()->positiveInt();

            $fileErrors = array();
            $fileErrors['image_un'] = FileValidator::verify('image_un', 'Image principale', true);
            if(isset($_FILES['image_deux']) && $_FILES['image_deux']['error'] !== UPLOAD_ERR_NO_FILE) $fileErrors['image_deux'] = FileValidator::verify('image_deux', 'Image secondaire', false);
            if(isset($_FILES['image_trois']) && $_FILES['image_trois']['error'] !== UPLOAD_ERR_NO_FILE) $fileErrors['image_trois'] = FileValidator::verify('image_trois', 'Image trois', false);
            if(isset($_FILES['image_quatre']) && $_FILES['image_quatre']['error'] !== UPLOAD_ERR_NO_FILE) $fileErrors['image_quatre'] = FileValidator::verify('image_quatre', 'Image quatre', false);

            //array_filter removes the "" empty string - when theres no errors in FileValidator.php
            $fileErrors = array_filter($fileErrors);

            if(empty($fileErrors) == false){
                foreach ($fileErrors as $key => $value) {
                    $validator->addError($key, $value);
                }
            }

            if($validator->isSuccess()){
                $timbre = new Timbre;
                $insert = $timbre->insert($data);

                $timbre_id = $insert;
                $descriptionShort = "timbre qui s'appelle : " . $data['nom'];
                $this->uploadAllImages($timbre_id, $descriptionShort);

                return View::redirect('timbre/show?id='.$timbre_id);
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

    private function uploadAllImages($timbre_id, $descriptionShort){
        $images = array();

        $images['image_un'] = ['est_principale' => 1, 'ordre_daffichage' => 0];
        if(isset($_FILES['image_deux']) && $_FILES['image_deux']['error'] !== UPLOAD_ERR_NO_FILE) $images['image_deux'] = ['est_principale' => 0, 'ordre_daffichage' => 1];
        if(isset($_FILES['image_trois']) && $_FILES['image_trois']['error'] !== UPLOAD_ERR_NO_FILE) $images['image_trois'] = ['est_principale' => 0, 'ordre_daffichage' => 2];
        if(isset($_FILES['image_quatre']) && $_FILES['image_quatre']['error'] !== UPLOAD_ERR_NO_FILE) $images['image_quatre'] = ['est_principale' => 0, 'ordre_daffichage' => 3];


        foreach ($images as $key => $value) {
            $this->uploadOneImage($key, $value['est_principale'], $value['ordre_daffichage'], $descriptionShort, $timbre_id);
        }
    }

    private function uploadOneImage($imageName, $isPrincipal, $order, $descriptionShort, $timbre_id){

        $wholePath = $_SERVER['DOCUMENT_ROOT'] . ASSET . 'uploads/';
        $folder = 'uploads/';
        $currentImageName = $_FILES[$imageName]['name'];
        $fileType = strtolower(pathinfo($currentImageName, PATHINFO_EXTENSION));

        //Need unique number that will change each time, in case same user wants to change the photos on same stamp
        $newImageName = 'timbre'.$timbre_id.'_ordreDaffichage'.$order.'_idUnique_'.uniqid().'.'.$fileType;
        $tempName = $_FILES[$imageName]["tmp_name"];
        $moveToURL = $wholePath . $newImageName;
        $descriptionShort = 'Image numero '.($order+1).' du '.$descriptionShort;
        $url = $folder . $newImageName;

        if(move_uploaded_file($tempName, $moveToURL)){

            $data = ['image_url' => $url, 'est_principale' => $isPrincipal, 'ordre_daffichage' => $order, 'description_courte' => $descriptionShort, 'timbre_id' => $timbre_id];

            $image = new Image;
            $insert = $image->insert($data);
        }
    }

    public function show($data = []){

        if(isset($data['id']) && $data['id'] != null){

            $timbre_id = $data['id'];

            $timbre = new Timbre;
            $timbreSelectId = $timbre->selectId($timbre_id);

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

                return View::render('timbre/show', ['timbre' => $timbreSelectId, 'images' => $imageSelect,
            'couleur' => $couleurName, 'pays' => $paysdOrigine, 'condition' => $conditionName]);
            }
            else {

                return View::render('error', ['msg' => 'Timbre pas trouvee!']);
            }
        }
        else {

            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

}


?>