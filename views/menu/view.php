<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Administrative area'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'attribute' => 'type',
                'value' => function($model) {
                    $statuses = [
                        0 => Yii::t('app', 'Route'),
                        1 => Yii::t('app', 'Link')
                    ];

                    return $statuses[$model->status];
                }
            ],
            'route',
            'url:url',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    $statuses = [
                        0 => Yii::t('app', 'Not Published'),
                        1 => Yii::t('app', 'Published')
                    ];

                    return $statuses[$model->status];
                }
            ]
        ],
    ]) ?>

</div>
