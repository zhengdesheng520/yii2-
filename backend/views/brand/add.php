<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\brand */
/* @var $form ActiveForm */
?>
<div class="brand-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'status')->radioList(Yii::$app->params["status"],["value"=>1]) ?>
    <?= $form->field($model, 'sort')->textInput(['value'=>10])?>
        <?= $form->field($model, 'intro')->textarea() ?>

        <?=$form->field($model, 'logo')->widget('manks\FileInput'); ?>
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- brand-add -->
