<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class StreetSearch extends StreetModel
{
    public function rules()
    {
        return [
            [['ref'], 'string'],
            [['name', 'string'], 'safe'],
            [['city_ref'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = StreetModel::find()->joinWith(['city']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', StreetModel::tableName().'.ref', $this->ref]);
        $query->andFilterWhere(['like', StreetModel::tableName().'.city_ref', $this->city_ref]);
        $query->andFilterWhere(['like', StreetModel::tableName().'.name', $this->name]);

        return $dataProvider;
    }
}