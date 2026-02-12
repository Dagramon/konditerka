<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'id_product')->dropDownList($products) ?>

    <?= $form->field($model, 'user_adress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->input('number') ?>

    <?= $form->field($model, 'description_order')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сделать заказ', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
