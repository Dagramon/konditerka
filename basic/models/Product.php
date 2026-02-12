<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id_product
 * @property string $name_product
 * @property int $price_product
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
            [['name_product', 'description_product', 'amount', 'id_category', 'photo', 'price_product'], 'required'],
            [['description_product'], 'string'],
            [['timestamp_arrival'], 'safe'],
            [['amount', 'id_category', 'price_product'], 'integer'],
            [['name_product', 'photo'], 'string', 'max' => 255],
            [['photo'], 'file', 'extensions' => 'png, jpg, jpeg, bmp', 'maxSize' => 10*1024*1024],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['id_category' => 'id_category']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_product' => 'Id Продукта',
            'name_product' => 'Название продукта',
            'price_product' => 'Цена',
            'description_product' => 'Описание продукта',
            'timestamp_arrival' => 'Дата прибытия',
            'amount' => 'Количество',
            'id_category' => 'Id Категории',
            'photo' => 'Фото',
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
