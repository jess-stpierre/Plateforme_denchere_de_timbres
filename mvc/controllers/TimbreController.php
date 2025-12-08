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

            if(isset($_POST['certifie']))  $data['certifie'] = 1;
            else  $data['certifie'] = 0;

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

        $returnBoolean = array();

        $imagesUploaded = array();

        if(isset($_FILES['image_un']) && $_FILES['image_un']['error'] !== UPLOAD_ERR_NO_FILE) $imagesUploaded['image_un'] = ['est_principale' => 1, 'ordre_daffichage' => 0];
        if(isset($_FILES['image_deux']) && $_FILES['image_deux']['error'] !== UPLOAD_ERR_NO_FILE) $imagesUploaded['image_deux'] = ['est_principale' => 0, 'ordre_daffichage' => 1];
        if(isset($_FILES['image_trois']) && $_FILES['image_trois']['error'] !== UPLOAD_ERR_NO_FILE) $imagesUploaded['image_trois'] = ['est_principale' => 0, 'ordre_daffichage' => 2];
        if(isset($_FILES['image_quatre']) && $_FILES['image_quatre']['error'] !== UPLOAD_ERR_NO_FILE) $imagesUploaded['image_quatre'] = ['est_principale' => 0, 'ordre_daffichage' => 3];


        if( count($imagesUploaded) > 0){

            $image = new Image;
            $imageSelect = $image->selectWhere('timbre_id', $timbre_id, 'ordre_daffichage');

            foreach ($imagesUploaded as $key => $newValue) {

                if(empty($key) == false) {

                    if(count($imageSelect) == 0){
                        $this->uploadOneImage($key, $newValue['est_principale'], $newValue['ordre_daffichage'], $descriptionShort, $timbre_id);
                    }
                    else {
                        $counter = 0;

                        for ($i=0; $i < count($imageSelect); $i++) {

                            if($newValue['ordre_daffichage'] == $imageSelect[$i]['ordre_daffichage']){

                                $description = "";

                                if($descriptionShort != $imageSelect[$i]['description_courte']) $description = $descriptionShort;
                                else $description = $imageSelect[$i]['description_courte'];

                                array_push($returnBoolean, $this->uploadOneImage($key, $newValue['est_principale'], $newValue['ordre_daffichage'], $description, $timbre_id, $imageSelect[$i]['id']));
                            }
                            else {
                                $counter = $counter +1;
                            }
                        }

                        if($counter == count($imageSelect)){
                            $this->uploadOneImage($key, $newValue['est_principale'], $newValue['ordre_daffichage'], $descriptionShort, $timbre_id);
                        }
                    }
                }
            }
        }




        if(empty($returnBoolean) == false){
           return !(in_array(false, $returnBoolean, true));
        }
        else {
            return true;
        }
    }

    private function uploadOneImage($imageName, $isPrincipal, $order, $descriptionShort, $timbre_id, $image_id = 0){

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

            if($image_id == 0){
                $insert = $image->insert($data);
            }
            else {
                $update = $image->update($data, $image_id);

                if($update) return true;
                else return false;
            }
        }
    }

    public function show($data = []){

        Auth::session();

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

    public function edit($data = []){

        Auth::session();

        if(isset($data['id']) && $data['id'] != null){

            $timbre_id = $data['id'];

            $timbre = new Timbre;
            $timbreSelect = $timbre->selectId($timbre_id);

            if($timbreSelect && isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){

                $id = $_SESSION['user_id'];

                $image = new Image;
                $imageSelect = $image->selectWhere('timbre_id', $timbre_id, 'ordre_daffichage');

                $conditions = new Conditions;
                $conditionsSelect = $conditions->select('nom');

                $couleur = new Couleur;
                $couleurSelect = $couleur->select('nom');

                $paysOrigine = new PaysOrigine;
                $paysOrigineSelect = $paysOrigine->select('nom');

                return View::render('timbre/edit', ['timbre' => $timbreSelect, 'condition'=>$conditionsSelect, 'couleurs'=>$couleurSelect, 'paysOrigines'=>$paysOrigineSelect, 'membre_id'=>$id, 'images' => $imageSelect]);
            }
            else {
                return View::render('error', ['msg' => 'Timbre pas trouvee!']);
            }
        }
        else {
            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

    public function update($data=[], $get=[]){

        Auth::session();

        if(isset($get['id']) && $get['id'] != null && isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){

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

            if(isset($_POST['certifie']))  $data['certifie'] = 1;
            else  $data['certifie'] = 0;

            $fileErrors = array();
            if(isset($_FILES['image_un']) && $_FILES['image_un']['error'] !== UPLOAD_ERR_NO_FILE) $fileErrors['image_un'] = FileValidator::verify('image_un', 'Image principale', false);
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
                $updateTimbre = $timbre->update($data, $get['id']);

                $timbre_id = $get['id'];
                $descriptionShort = "timbre qui s'appelle : " . $data['nom'];
                $updateImages = $this->uploadAllImages($timbre_id, $descriptionShort);

                if($updateTimbre && $updateImages){
                    return View::redirect('timbre/show?id='.$timbre_id);
                }
                else if($updateTimbre == false) return View::render('error', ['msg' => 'Na pas pu faire le changement! Probleme avec le timbre']);
                else if($updateImages == false) return View::render('error', ['msg' => 'Na pas pu faire le changement! Probleme avec les images']);
                else {
                    return View::render('error', ['msg' => 'Na pas pu faire le changement!']);
                }
            }
            else {
                $errors = $validator->getErrors();

                $conditions = new Conditions;
                $conditionsSelect = $conditions->select('nom');

                $couleur = new Couleur;
                $couleurSelect = $couleur->select('nom');

                $paysOrigine = new PaysOrigine;
                $paysOrigineSelect = $paysOrigine->select('nom');

                return View::render('timbre/edit', ['errors' => $errors, 'condition'=>$conditionsSelect, 'couleurs'=>$couleurSelect, 'paysOrigines'=>$paysOrigineSelect, 'timbre'=>$data, 'membre_id'=>$id]);
            }
        }
        else {
            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

    public function delete($data){

        if(Auth::session()) {

            $timbre_id = $data['id'];

            $timbre = new Timbre;
            $image = new Image;

            $imageSelect = $image->selectWhere('timbre_id', $timbre_id, 'ordre_daffichage');

            $booleanArray = array();
            for ($i=0; $i < count($imageSelect); $i++) {
                array_push($booleanArray, $image->delete($imageSelect[$i]['id']));
            }
            $imagesDeleted = true;
            if(empty($booleanArray) == false){
                $imagesDeleted = !(in_array(false, $booleanArray, true));
            }

            $deleteTimbre = $timbre->delete($timbre_id);

            if($deleteTimbre && $imagesDeleted){
                return View::redirect('membre/show');
            }
            else {
                return View::render('error', ['msg' => 'Na pas pu supprimer le timbre!']);
            }
        }
     }

}


?>