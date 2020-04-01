<?php

use app\models\StreetSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use \app\models\CityModel;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel StreetSearch */

$this->title = 'Street Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="street-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'ref',
            [
                'attribute' => 'city',
                'value' => 'city.name',
                'filter'    => Html::activeDropDownList($searchModel,
                    'city_ref',
                    ArrayHelper::map(CityModel::find()->asArray()->all(), 'ref', 'name'),
                    [
                        'class'  => 'form-control',
                        'prompt' => 'All'
                    ]),
            ]
        ],
    ]); ?>


</div>
