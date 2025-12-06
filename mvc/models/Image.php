<?php

namespace App\Models;

use App\Models\CRUD;

class Image extends CRUD {

    protected $table = "image";
    protected $primaryKey = "id";
    protected $fillable = ['image_url', 'est_principale', 'ordre_daffichage', 'description_courte', 'timbre_id'];

}