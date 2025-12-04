<?php

namespace App\Models;

use App\Models\CRUD;

class PaysOrigine extends CRUD {

    protected $table = "pays_dorigine";
    protected $primaryKey = "id";
    protected $fillable = ['nom'];

}