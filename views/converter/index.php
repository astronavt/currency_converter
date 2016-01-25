<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<h1>Currency Converter</h1>
<h2>By European Central Bank</h2>
<div class="row">
        <div class="col-md-8 col-xs-12  ">
            <?php $form = ActiveForm::begin(['id' => 'converter-form','method'=>'get']); ?>
            <div class="col-xs-6">
    
                <?= $form->field($cfModel, 'fromValue') ?>
    
    
                <?= $form->field($cfModel, 'fromCurrency')
                        ->dropDownList(
                            array_combine($currencies,$currencies),           // Flat array ('id'=>'label')
                            ['prompt'=>'']    // options
                        ); 
                ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($cfModel, 'toValue')->textInput(['readonly' => true]); ?>
                <?= $form->field($cfModel, 'toCurrency')
                        ->dropDownList(
                            array_combine($currencies,$currencies),           // Flat array ('id'=>'label')
                            ['prompt'=>'']    // options
                        ); 
                ?>
            </div>
                <div class="form-group ">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary center-block', 'name' => 'convert-button']) ?>
                </div>
    
            <?php ActiveForm::end(); ?>
        </div>
</div>

