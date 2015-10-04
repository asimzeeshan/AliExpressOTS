<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Package;

/**
 * PackageSearch represents the model behind the search form about `app\models\Package`.
 */
class PackageSearch extends Package
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ae_order_id', 'arrived_in', 'is_disputed', 'created_by', 'updated_by'], 'integer'],
            [['price', 'order_date', 'description', 'delivery_date', 'paid_with', 'refund_status', 'notes', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Package::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'ae_order_id' => $this->ae_order_id,
            'order_date' => $this->order_date,
            'delivery_date' => $this->delivery_date,
            'arrived_in' => $this->arrived_in,
            'is_disputed' => $this->is_disputed,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'paid_with', $this->paid_with])
            ->andFilterWhere(['like', 'refund_status', $this->refund_status])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
