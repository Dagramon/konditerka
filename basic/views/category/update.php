<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = 'Редактировать категорию: ' . $model->id_category;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_category, 'url' => ['view', 'id_category' => $model->id_category]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
