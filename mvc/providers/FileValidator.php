<?php

namespace App\Providers;

class FileValidator {

    public static function verify($whichImage, $name, $isRequired){

        //Check pour probleme avec le formulaire
        if (isset($_FILES[$whichImage]) == false){
            if($isRequired) return "$name est obligatoire.";
        }

        //Check si un le fichier est vide
        if (empty($_FILES[$whichImage]['name'])) {
            if($isRequired) return "$name est obligatoire.";
        }

        //Check pour erreur
        if ($_FILES[$whichImage]['name'] !== UPLOAD_ERR_OK) {
            return "$name a eu une erreur lors du téléchargement.";
        }

        //check taille
        $maxSize = 5242880;
        if ($_FILES[$whichImage]['size'] > $maxSize) {
            return "La taille de $name est de maximum 5 Mo.";
        }

        $extensionUsed = pathinfo($_FILES[$whichImage]['name'], PATHINFO_EXTENSION);
        $wantedExtensions = ['jpeg', 'png', 'webp'];

        if (in_array(strtolower($extensionUsed), $wantedExtensions) == false) {
            return "Le fichier $name doit être entre une image: jpeg, png, webp.";
        }

        if (getimagesize($_FILES[$whichImage]['tmp_name']) == false) {
            return "Le fichier $name n'est pas une image valide.";
        }

        return "";
    }

}

?>