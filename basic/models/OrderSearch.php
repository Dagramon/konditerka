<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_order', 'id_product', 'amount', 'id_user'], 'integer'],
            [['timestamp_order', 'user_adress', 'description_order', 'order_status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_order' => $this->id_order,
            'timestamp_order' => $this->timestamp_order,
            'id_product' => $this->id_product,
            'amount' => $this->amount,
            'id_user' => $this->id_user,
        ]);

        $query->andFilterWhere(['like', 'user_adress', $this->user_adress])
            ->andFilterWhere(['like', 'description_order', $this->description_order])
            ->andFilterWhere(['like', 'order_status', $this->order_status]);

        return $dataProvider;
    }
    public function searchForUser($params, $id_user)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['id_user' => $id_user]);
        $query->orderBy(['timestamp_order' => SORT_DESC]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id_order' => $this->id_order,
            'timestamp_order' => $this->timestamp_order,
        ]);

        $query->andFilterWhere(['like', 'user_adress', $this->user_adress])
            ->andFilterWhere(['like', 'description_order', $this->description_order])
            ->andFilterWhere(['like', 'order_status', $this->order_status]);

        return $dataProvider;
    }
}
