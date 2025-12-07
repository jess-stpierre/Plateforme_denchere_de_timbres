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

        return $this;
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

    public function validateDate($format = 'Y-m-d' ) {
        $date = \DateTime::createFromFormat($format, $this->value);
        if (!$date || $date->format($format) !== $this->value) {
            $this->errors[$this->key]="Format $this->name invalid. SVP utiliser le $format format.";
        }
        return $this;
    }

    public function positiveInt() {
        if(!filter_var($this->value, FILTER_VALIDATE_INT) || (int)$this->value <= 0) {
            $this->errors[$this->key] = "$this->name doit etre un nombre positif.";
        }
        return $this;
    }

    public function bool(){
        if(!filter_var($this->value, FILTER_VALIDATE_BOOLEAN)){
            $this->errors[$this->key]="$this->name doit etre une valuer boolean: oui ou non.";
        }
        return $this;
    }

    //REGLES FIN

    public function isSuccess(){
        if(empty($this->errors)) return true;
        else return false;
    }

    public function getErrors(){
        return $this->errors;
    }

    public function addError($key, $value) {
        $this->errors[$key] = $value;
    }
}


?>