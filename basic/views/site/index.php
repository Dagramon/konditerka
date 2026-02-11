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
        <div class="row">
            <?php
                foreach($products as $product) {
                    echo '
                    <div class="col-lg-4 mb-3">
                        <h2>' . $product->name_product . '</h2>
                        <p>' . Category::findOne(['id_category' => $product->id_category])->name_category . '</p>
                        <p>В наличии: ' . $product->amount . '</p>

                        <img src="uploads/' . $product->photo . '" width=300px alt="image>
                    </div>
                    ';
                }
                ?>
        </div>

    </div>
</div>
