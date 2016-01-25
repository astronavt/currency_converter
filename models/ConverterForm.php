<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ConverterForm extends Model
{
    public $fromValue = '1'; //Исходная сумма
    public $toValue = '1'; //Выходная сумма
    public $fromCurrency = 'EUR'; //Исходная валюта
    public $toCurrency = 'EUR'; //Выходная валюта

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['fromCurrency', 'toCurrency','fromValue'], 'required'],
            [['fromValue','toValue'],'number','min'=>0]
        ];
    }
    
    public function scenarios(){
        return [
                'default' => ['fromCurrency','toCurrency', 'fromValue','toValue'],
                ];
    }
    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'fromValue' => 'From amount',
            'fromCurrency' => 'From currency',
            'toValue' => 'To amount',
            'toCurrency' => 'To currency',
        ];
    }
    
    /**
     * converting values 
     */
    public function convert($rate){
        if($rate <= 0) return false;
        if($this->fromValue > 0){
            $this->toValue = $this->fromValue * $rate;
        }elseif($this->toValue > 0){
            $this->fromValue = $this->toValue / $rate;
        }else{
            $this->fromValue = 1;
            $this->toValue = $rate;
        }
        return true;
    }
}
