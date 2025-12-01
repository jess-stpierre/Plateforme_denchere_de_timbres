<?php

namespace App\Models;

use App\Models\CRUD;

class Membre extends CRUD {

    protected $table = "membre";
    protected $primaryKey = "id";
    protected $fillable = ['nom', 'nom_dutilisateur', 'courriel', 'mot_de_passe'];

    // hashPassword() est une méthode qui prend un mot de passe comme premier argument et un paramètre de coût facultatif (10 par défaut). Il utilise la fonction password_hash de PHP pour hacher en toute sécurité le mot de passe à l'aide de l'algorithme Bcrypt avec le coût spécifié.
    public function hashPassword($password, $cost = 10){

        $options = ['cost' => $cost];

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    // La méthode checkUser() vérifie si un utilisateur avec le nom d'utilisateur fourni existe et vérifie le nom d'utilisateur fourni. mot de passe par rapport au mot de passe haché stocké dans la base de données. Si les informations d'identification correspondent, les variables de session sont définies et la fonction renvoie vrai. Sinon, il renvoie faux. Cette méthode est couramment utilisée dans les applications Web à des fins d'authentification des utilisateurs.
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