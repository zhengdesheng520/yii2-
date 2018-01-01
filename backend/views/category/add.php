<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form ActiveForm */
?>
<div class="category-add">
    <a href="/category/index"><p class="glyphicon glyphicon-share-alt btn-lg"style="color: blue">返回</p></a>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'parent_id') ?>
    <?= \liyuze\ztree\ZTree::widget([
        'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id"
				},
			},
			callback: {
				onClick: function(e,treeId, treeNode){
				//1.找到父类Id那个框框
				$("#category-parent_id").val(treeNode.id);
				console.dir(treeNode.id);
				}
			}
			
			
		}',
        'nodes' =>
			$cateArr

    ]);
    ?>


        <?= $form->field($model, 'intro') ?>
    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- category-add -->
<?php
//全部分类自动展开
$js=<<<js
var treeObj = $.fn.zTree.getZTreeObj("w1");
treeObj.expandAll(true);
  var node = treeObj.getNodeByParam("id", "{$model->parent_id}", null);//得到节点
    treeObj.selectNode(node);//选择节点

js;
$this->registerJs($js);




?>