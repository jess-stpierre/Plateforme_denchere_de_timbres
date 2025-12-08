<?php

namespace App\Controllers;

use App\Models\Timbre;
use App\Models\Image;

use App\Providers\View;
use App\Providers\Auth;

class ImageController {

    public function delete($data){

        if(Auth::session()) {

            $image_id = $data['image_id'];
            $timbre_id = $data['timbre_id'];

            $image = new Image;
            $deleted = $image->delete($image_id);

            if($deleted){
                return View::redirect('timbre/show?id='.$timbre_id);
            }
            else {
                return View::render('error', ['msg' => 'Na pas pu supprimer l\'image!']);
            }
        }
    }

}