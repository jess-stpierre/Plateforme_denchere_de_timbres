<?php

namespace App\Providers;

class Validator {

    private $errors = array(); //can have more than 1 error so want an array
    private $key; //name of input
    private $value; //value we got
    private $name; //option for the error msg

    public function field($key, $value, $name = null){

        $this->key = $key;
        $this->value = $value;

        if($name == null){
            $this->name = ucfirst($key);
        }
        else {
            $this->name = ucfirst($name);
        }

        return $this; //return the object itself - for chained methods, to verify many things in form inputs
    }

    //REGLES DE VALIDATION

    public function required(){
        if(empty($this->value)){
            $this->errors[$this->key]="$this->name est obligatoire.";
        }
        return $this;
    }

    public function max($length){
        if(strlen($this->value) > $length){
            $this->errors[$this->key]="$this->name doit etre moins que $length characteres.";
        }
        return $this;
    }

    public function min($length){
        if(strlen($this->value) < $length){
            $this->errors[$this->key]="$this->name doit etre minimum $length characteres.";
        }
        return $this;
    }

    public function int(){
        if(!filter_var($this->value, FILTER_VALIDATE_INT)){
            $this->errors[$this->key]="$this->name doit etre un nombre (non-decimal).";
        }
        return $this;
    }

    public function email(){
        if(!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)){
            $this->errors[$this->key]="Format $this->name invalide.";
        }
        return $this;
    }

    //La méthode unique() fait partie d'une classe chargée de gérer la validation ou de vérifier les contraintes d'unicité dans une application Web. Il instancie dynamiquement un objet modèle en fonction du paramètre qui lui est transmis, appelle la méthode unique de ce modèle pour vérifier l'unicité et, s'il n'est pas unique, ajoute un message d'erreur au tableau d'erreurs. Enfin, il renvoie l'instance d'objet actuelle pour permettre le chaînage de méthodes.
    public function unique($model){

        $model = 'App\\Models\\'.$model;
        $model = new $model;
        $unique = $model->unique($this->key, $this->value);
        if($unique){
            $this->errors[$this->key]="$this->name doit etre unique.";
        }
        return $this;
    }

    public function float(){
        if(!filter_var($this->value, FILTER_VALIDATE_FLOAT)){
            $this->errors[$this->key]="$this->name doit etre une decimal.";
        }
        return $this;
    }

    //REGLES FIN

    public function isSuccess(){
        if(empty($this->errors)) return true;
    }

    public function getErrors(){
        if(!$this->isSuccess()) return $this->errors;
    }
}


?>