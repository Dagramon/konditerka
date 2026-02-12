<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id_order
 * @property string $timestamp_order
 * @property string $user_adress
 * @property int $id_product
 * @property int $amount
 * @property int $id_user
 * @property string $description_order
 * @property string $order_status
 * @property string $cancel_reason
 *
 * @property Product $product
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_status'], 'default', 'value' => 'Новый'],
            [['timestamp_order'], 'safe'],
            [['user_adress', 'id_product', 'amount', 'id_user', 'description_order'], 'required'],
            [['id_product', 'amount', 'id_user'], 'integer'],
            [['order_status'], 'string'],
            [['user_adress', 'description_order'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id_user']],
            [['id_product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['id_product' => 'id_product']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_order' => 'Id Order',
            'timestamp_order' => 'Время заказа',
            'user_adress' => 'Адрес заказчика',
            'id_product' => 'Продукт',
            'amount' => 'Количество',
            'id_user' => 'Id User',
            'description_order' => 'Описание заказа',
            'order_status' => 'Статус',
            'cancel_reason' => 'Причина отклонения',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id_product' => 'id_product']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id_user' => 'id_user']);
    }

}
