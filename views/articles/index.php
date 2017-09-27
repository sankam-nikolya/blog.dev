<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Administrative area'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Articles'), ['create'], ['class' => 'btn btn-success']) ?>
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
                    return Html::a(
                        $model->title,
                        ['update', 'id' => $model->id]
                    );
                }
            ],
            [
                'attribute' => 'category',
                'label' => Yii::t('app', 'Category'),
                'value' => function($model) {
                    $categories = $model->getArticleCategories($model);
                    return (!empty($categories)) ? implode(', ', $categories) : null;
                }
            ],
            //'created_by',
            [
                'attribute' => 'published_at',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'published_at',
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
