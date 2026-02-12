<?php

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Сделать заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_order',
            'timestamp_order',
            'user_adress',
            //'id_product',
            [
                'attribute' => 'id_product',
                'value' => 'product.name_product',
            ],
            'amount',
            //'id_user',
            [
                'attribute' => 'id_user',
                'value' => 'user.fio_user',
            ],
            //'description_order',
            'order_status',
            [
                'class' => ActionColumn::className(),
                'template' => '{cancel} {send} {finish}',
                'buttons' => [
                    'cancel' => function($url, $model) {
                        if ($model->order_status == 'Новый') {
                          return Html::a('Отклонить', ['/order/cancel', 'id_order' => $model->id_order]); 
                        }
                    },
                    'send' => function($url, $model) {
                        if ($model->order_status == 'Новый') {
                          return Html::a('Отправить', ['/order/send', 'id_order' => $model->id_order]);  
                        }
                    },
                    'finish' => function($url, $model) {
                        if ($model->order_status == 'В пути') {
                          return Html::a('Завершить', ['/order/finish', 'id_order' => $model->id_order]);  
                        }
                    },
                ],
                'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_order' => $model->id_order]);
                 }
            ],
        ],
    ]); ?>


</div>
