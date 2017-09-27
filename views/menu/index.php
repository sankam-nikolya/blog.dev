<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Administrative area'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Menu'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'type',
                'value' => function($model) {
                    $statuses = [
                        0 => Yii::t('app', 'Route'),
                        1 => Yii::t('app', 'Link')
                    ];

                    return $statuses[$model->status];
                },
                'filter' => [
                    0 => Yii::t('app', 'Route'),
                    1 => Yii::t('app', 'Link')
                ]
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    $statuses = [
                        0 => Yii::t('app', 'Not Published'),
                        1 => Yii::t('app', 'Published')
                    ];

                    return $statuses[$model->status];
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
