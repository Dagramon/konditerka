<?php

use yii\helpers\Html;
use Y

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = 'Добавить Продукт';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
