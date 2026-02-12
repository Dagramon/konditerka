<?php

use app\models\Category;
/** @var yii\web\View $this */

$this->title = 'Кондитерская';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Каталог наших товаров</h1>
    </div>

    <div class="body-content">
        <style>
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-content: center;
            gap: 20px;
        }
        
        .product-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 300px;
            padding: 15px;
            border: 1px solid #dbcfcf;
            border-radius: 8px;
        }
        
        .buttonOrder {
            text-decoration: none;
            align-content: center;
            background-color: green;
            color: white;
            height: 50px;
            width: 250px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .btnnnn:hover {
            background-color: darkgreen;
        }
        
        img {
            width: 250px;
            height: 250px;
            margin: 10px 0;
        }
    </style>
        <div class="row">
            <style>
                .btnnnn {
                    background-color: green;
                    color: white;
                    height: 50px;
                    width: 250px;
                }
            </style>
            <?php
                foreach($products as $product) {
                    if (!Yii::$app->user->isGuest) {
                        $url = "myorders/create";
                    }
                    else {
                        $url = "#";
                    }
                    if ($product->amount <= 0) {
                        continue;
                    }
                    echo '
                    <div class="product-card">
                        <h2>' . $product->name_product . '</h2>
                        <p>' . Category::findOne(['id_category' => $product->id_category])->name_category . '</p>
                        <p>Цена: ' . $product->price_product . '</p>
                        <p>В наличии: ' . $product->amount . '</p>
                        <img src="uploads/' . $product->photo . '" width=300px alt="image">
                        <a class="buttonOrder" href="' . $url . '">Заказать</a>
                    </div>
                    ';
                }
                ?>
        </div>

    </div>
</div>
