<?php

namespace App\Controllers;

use App\Providers\View;
use App\Models\Membre;
use App\Providers\Validator;
use App\Providers\Auth;
use App\Controllers\AuthController;

class MembreController {

    public function create(){

        return View::render('membre/create');
    }

    public function store($data){

        $validator = new Validator;
        $validator->field('nom', $data['nom'], "Nom")->min(2)->max(45);
        $validator->field('nom_dutilisateur', $data['nom_dutilisateur'], "Nom d'Utilisateur")->required()->max(55)->email()->unique('Membre');
        $validator->field('mot_de_passe', $data['mot_de_passe'], 'Mot de Passe')->min(6)->max(255);
        $validator->field('courriel', $data['courriel'], 'Courriel')->required()->max(55)->email();

        if($validator->isSuccess()) {
            $membre = new Membre;

            $data['mot_de_passe'] = $membre->hashPassword($data['mot_de_passe']);

            $insert = $membre->insert($data);

            if($insert){
                return view::redirect('login');
            }
            else {
                return view::render('error');
            }
        }
        else {
            $errors = $validator->getErrors();

            return view::render('membre/create', ['errors' => $errors, 'membre' => $data]);
        }
    }

    public function show($data = []){

        Auth::session();

        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){
            $id = $_SESSION['user_id'];

            $membre = new Membre;
            $selectId = $membre->selectId($id);

            if($selectId) {
                return View::render('membre/show', ['membre' => $selectId]);
            }
            else {
                return View::render('error', ['msg' => 'Membre pas trouvee!']);
            }
        }
        else {
            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

    public function edit($data = []){

        Auth::session();

        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){
            $id = $_SESSION['user_id'];

            $membre = new Membre;
            $selectId = $membre->selectId($id);

            if($selectId) {
                return View::render('membre/edit', ['membre' => $selectId]);
            }
            else {
                return View::render('error', ['msg' => 'Membre pas trouvee!']);
            }
        }
        else {
            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

    public function update($data=[], $get=[]){

        Auth::session();

        if(isset($_SESSION['user_id']) && $_SESSION['user_id']!= null){

            $validator = new Validator;
            $validator->field('nom', $data['nom'], "Nom")->min(2)->max(45);
            $validator->field('courriel', $data['courriel'], 'Courriel')->max(55)->email();

            if($validator->isSuccess()){

                $membre = new Membre;
                $update = $membre->update($data, $_SESSION['user_id']);

                if($update){
                    return View::redirect('membre/show');
                }
                else {
                    return View::render('error', ['msg' => 'Na pas pu faire le changement!']);
                }
            }
            else {
                $errors = $validator->getErrors();

                return View::render('membre/edit', ['errors' => $errors, 'membre'=>$data]);
            }
        }
        else {
            return View::render('error', ['msg' => '404 page pas trouvee!']);
        }
    }

    public function delete($data){

        if(Auth::session()) {
            $membre = new Membre;
            $delete = $membre->delete($data['id']);

            if($delete){
                return View::redirect('logout');
            }
            else {
                return View::render('error', ['msg' => 'Na pas pu supprimer!']);
            }
        }
    }
}

?>