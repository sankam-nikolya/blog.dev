<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\DatePicker;
use vova07\imperavi\Widget;
use kartik\select2\Select2;

// var_dump(substr(Yii::$app->language, 0, 2));die;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categories')->widget(Select2::className(), [
            'data' => $model->getCategoriesList(),
            'options' => [
                'placeholder' => Yii::t('app', 'Select category'),
                'multiple' => true
            ],
        ]) ?>

    <div class="form-group">
        <div class="row">
            <div class="col-lg-6">
                <?= Html::img($model->getUploadUrl('image'), ['class' => 'img-thumbnail img-responsive content-image']) ?>
            </div>
            <div class="col-lg-6">
                <?= Html::img($model->getThumbUploadUrl('image'), ['class' => 'img-thumbnail img-responsive content-image']) ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

    <?= $form->field($model, 'intro')->widget(Widget::className()) ?>

    <?= $form->field($model, 'description')->widget(Widget::className(), [
            'settings' => [
                'minHeight' => 400,
            ]
        ]) ?>

    <?= $form->field($model, 'published_at')->widget(DatePicker::className()) ?>

    <?= $form->field($model, 'status')->checkbox(); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
