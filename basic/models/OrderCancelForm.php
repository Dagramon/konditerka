<?php

namespace app\models;

use Yii;

class OrderCancelForm extends Order
{


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cancel_reason'], 'default', 'value' => ""],
        ];
    }

}