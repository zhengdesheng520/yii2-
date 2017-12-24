<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form ActiveForm */
?>
<div class="article-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'article_category_id') ?>
        <?= $form->field($model, 'intro') ?>
        <?= $form->field($content, 'content')->textarea() ?>
        <?= $form->field($model, 'status')->radioList([0=>'是',1=>'否'],['value'=>0]) ?>

        <?= $form->field($model, 'sort')->textInput(["value"=>50]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- article-add -->
