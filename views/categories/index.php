<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Categories'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function($model) {
                    return  Html::a(
                        $model->title,
                        ['update', 'id' => $model->id]
                    );
                }
            ],
            'title',
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'type' => DatePicker::TYPE_INPUT
                ])
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'type' => DatePicker::TYPE_INPUT
                ])
            ],
            [
                'class' => 'app\widgets\EnumColumn',
                'attribute' => 'status',
                'enum' => [
                    0 => Yii::t('app', 'Not Published'),
                    1 => Yii::t('app', 'Published')
                ]
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
