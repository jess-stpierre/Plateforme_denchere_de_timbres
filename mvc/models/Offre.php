<?php

namespace App\Models;

use App\Models\CRUD;

class Offre extends CRUD {

    protected $table = "offre";
    protected $primaryKey = "id";
    protected $fillable = ['montant', 'date_de_loffre', 'enchere_id', 'membre_id'];

}