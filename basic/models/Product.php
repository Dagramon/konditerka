<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id_product
 * @property string $name_product
 * @property string $description_product
 * @property string $timestamp_arrival
 * @property int $amount
 * @property int $id_category
 * @property string $photo
 *
 * @property Category $category
 * @property Order[] $orders
 */
class Product extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_product', 'description_product', 'amount', 'id_category', 'photo'], 'required'],
            [['description_product'], 'string'],
            [['timestamp_arrival'], 'safe'],
            [['amount', 'id_category'], 'integer'],
            [['name_product', 'photo'], 'string', 'max' => 255],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['id_category' => 'id_category']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_product' => 'Id Product',
            'name_product' => 'Name Product',
            'description_product' => 'Description Product',
            'timestamp_arrival' => 'Timestamp Arrival',
            'amount' => 'Amount',
            'id_category' => 'Id Category',
            'photo' => 'Photo',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id_category' => 'id_category']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['id_product' => 'id_product']);
    }

}
