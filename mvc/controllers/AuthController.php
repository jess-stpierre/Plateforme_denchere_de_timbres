<?php

namespace App\Controllers;

use App\Providers\Validator;
use App\Providers\View;
use App\Models\Membre;

class AuthController {

    public function create(){

        return View::render('auth/create');
    }

    public function store($data){

        $validator = new Validator;
        $validator->field('nom_dutilisateur', $data['nom_dutilisateur'], "Nom d'Utilisateur")->required()->max(55)->email();
        $validator->field('mot_de_passe', $data['mot_de_passe'], 'Mot de Passe')->min(6)->max(20);

        if($validator->isSuccess()) {

            $membre = new Membre;
            $checkmembre = $membre->checkmembre($data['nom_dutilisateur'], $data['mot_de_passe']);

            if($checkmembre){
                return view::redirect('home'); //va sur la page accueil ou portail d'encheres?!!!
            }
            else {
                $errors['message'] = "S.V.P. verifier votre nom d'utilisateur et mot de passe.";

                return view::render('auth/create', ['errors' => $errors, 'membre' => $data]);
            }
        }
        else {
            $errors = $validator->getErrors();
            return view::render('auth/create', ['errors' => $errors, 'membre' => $data]);
        }
    }

    public function delete(){

        session_destroy();

        return view::redirect("login");
    }
}