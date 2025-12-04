<?php

namespace App\Models;

use App\Models\CRUD;

class Timbre extends CRUD {

    protected $table = "timbre";
    protected $primaryKey = "id";
    protected $fillable = ['nom', 'date_de_creation', 'description', 'tirage', 'dimensions', 'certifie', 'membre_id', 'couleur_id', 'pays_dorigine_id', 'conditions_id'];

}