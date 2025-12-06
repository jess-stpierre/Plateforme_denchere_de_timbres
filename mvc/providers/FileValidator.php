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
        if ($_FILES[$whichImage]['error'] !== UPLOAD_ERR_OK) {
            return "$name a eu une erreur lors du téléchargement.";
        }

        //check taille
        $maxSize = 5242880;
        if ($_FILES[$whichImage]['size'] > $maxSize) {
            return "La taille de $name est de maximum 5 Mo.";
        }

        //check si bonne estension
        $fileType = $_FILES[$whichImage]['type'];
        $wantedExtensions = ['image/jpeg', 'image/png', 'image/webp'];

        if (in_array($fileType, $wantedExtensions) == false) {
            return "$name doit être entre une image: jpeg, png, webp.";
        }

        //check si image
        if (getimagesize($_FILES[$whichImage]['tmp_name']) == false) {
            return "$name n'est pas une image valide.";
        }

        return "";
    }

}

?>