<?php

namespace app\models;
use yii\base\Model;
class Currency extends Model
{
    public $code; //Currency code like USD or UAH...
    public $rateToEur; //currency rate to EUR by European Central Bank
    
    public function getCode(){
        return $this->code;
    }
    
    public function getRateToEur(){
        return $this->rateToEur;
    }
    
}
