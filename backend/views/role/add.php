<a href="/role/index"><p class="fa fa-reply-all"style="font-size: 20px;color: blue">返回列表</p></a>
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/3
 * Time: 14:40
 */

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->label('组名');
echo $form->field($model,'description')->label('组描述');
echo $form->field($model,'permission')->checkboxList($perArr);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);

\yii\bootstrap\ActiveForm::end();