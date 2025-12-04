<?php

namespace App\Models;

use App\Models\CRUD;

class Membre extends CRUD {

    protected $table = "membre";
    protected $primaryKey = "id";
    protected $fillable = ['nom', 'nom_dutilisateur', 'courriel', 'mot_de_passe'];

    public function hashPassword($password, $cost = 10){

        $options = ['cost' => $cost];

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function checkmembre($username, $password){

        $membre = $this->unique('nom_dutilisateur', $username);

        if($membre){

            if(password_verify($password, $membre['mot_de_passe'])){

                session_regenerate_id();
                $_SESSION['user_id'] = $membre['id'];
                $_SESSION['user_name'] = $membre['nom'];
                $_SESSION['nom_dutilisateur'] = $membre['nom_dutilisateur'];
                $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);

                return true;
            }
            else {
                echo false;
            }
        }
        else {
            echo false;
        }
    }
}

?>