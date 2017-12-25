<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleCategory */
/* @var $form ActiveForm */
?>
<div class="article-category-add">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'status') ->radioList(Yii::$app->params['status'],['value'=>1])?>
        <?= $form->field($model, 'sort')->textInput(['value'=>50])?>
        <?= $form->field($model, 'is_help')->radioList(Yii::$app->params['is_help'],['value'=>0]) ?>

    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- article-category-add -->
