<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */
/* @var $form ActiveForm */
?>
<div class="goods-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'sn') ?>

        <?= $form->field($model, 'good_category_id')->dropDownList($cateArr,['prompt'=>'请选择所属分类']) ?>
        <?= $form->field($model, 'brand_id')->dropDownList($brandArr,['prompt'=>'请选择所属品牌']) ?>
        <?= $form->field($model, 'status')->radioList([0=>'下架',1=>'上架'],['value'=>1]) ?>
        <?= $form->field($model, 'market_price') ?>
        <?= $form->field($model, 'shop_price') ?>
        <?= $form->field($model, 'stock') ?>
        <?= $form->field($model, 'sort') ?>

        <?= $form->field($model, 'logo') ->widget(\manks\FileInput::className(),['clientOptions' => [ 'server' => \yii\helpers\Url::to(['brand/upload'])]])?>


        <?= $form->field($goodIntro, 'content')->widget('kucha\ueditor\UEditor',[]) ?>
        <?= $form->field($model, 'imgFiles')->widget('manks\FileInput', [
            'clientOptions' => [
                'pick' => [
                    'multiple' => true,
                ],
                 'server' => \yii\helpers\Url::to(['brand/upload']),
                // 'accept' => [
                // 	'extensions' => 'png',
                // ],
            ],
        ]); ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- goods-add -->
