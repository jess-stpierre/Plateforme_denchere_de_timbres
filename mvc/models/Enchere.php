<?php

namespace App\Models;

use App\Models\CRUD;

class Enchere extends CRUD {

    protected $table = "enchere";
    protected $primaryKey = "id";
    protected $fillable = ['date_de_debut', 'date_de_fin', 'prix_plancher', 'prix_courant', 'coups_de_coeur', 'timbre_id', 'membre_id'];

}