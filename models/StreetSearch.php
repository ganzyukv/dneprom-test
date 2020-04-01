<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

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
        VarDumper::dump($params);
        $query = StreetModel::find()->joinWith(['city']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['city'] = [
            'asc' => [CityModel::tableName().'.name' => SORT_ASC],
            'desc' => [CityModel::tableName().'.name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', StreetModel::tableName().'.ref', $this->ref]);
        $query->andFilterWhere(['like', StreetModel::tableName().'.city_ref', $this->city_ref]);
        $query->andFilterWhere(['like', StreetModel::tableName().'.name', $this->name]);

        return $dataProvider;
    }
}