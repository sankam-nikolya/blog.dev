<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */

$script = "
$('#menu-type').change(function(){
    var type = $(this).val();
    if(type == '') {
        $('.url-block').hide();
        $('.route-block').hide();
    } else {
        if(type == 0) {
            $('.route-block').show();
            $('.url-block').hide();
        } else {
            $('.url-block').show();
            $('.route-block').hide();
        }
    }
});
";
$this->registerJs($script, yii\web\View::POS_READY);
?>
<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([
            0 => Yii::t('app', 'Route'),
            1 => Yii::t('app', 'Link')
        ], [
            'id' => 'menu-type',
            'prompt' => Yii::t('app', 'Select type')
        ]); ?>

    <div class="route-block">
        <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="url-block">
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    </div>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
