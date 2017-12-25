<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form ActiveForm */
?>
<h1>添加文章</h1>
<div class="article-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'article_category_id')->dropDownList($cateArr) ?>
        <?= $form->field($model, 'intro') ?>
        <?= $form->field($content, 'content')->widget('kucha\ueditor\UEditor',[]); ?>
        <?= $form->field($model, 'status')->radioList(Yii::$app->params['status'],['value'=>'1']) ?>

        <?= $form->field($model, 'sort')->textInput(["value"=>50]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- article-add -->
