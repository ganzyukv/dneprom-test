<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Street Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="street-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'ref',
            'city_ref',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
