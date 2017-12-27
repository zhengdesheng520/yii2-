<?php
/* @var $this yii\web\View */
?>
<h1>品牌展示</h1><a href="<?=\yii\helpers\Url::to(['brand/add'])?>"class="btn btn-info">添加品牌</a>
<a href="<?=\yii\helpers\Url::to(['back'])?>"title="回收站"><span class="glyphicon glyphicon-trash "style="color: red;font-size: 30px;float: right"></span></a>
<table class="table table-bordered table-striped">
    <tr>
        <th>id</th>
        <th>品牌名称</th>
        <th>品牌图标</th>
        <th>状态</th>
        <th>排序</th>
        <th>介绍</th>
        <th>操作</th>
    </tr>
<?php foreach ($brand as $row):?>
    <tr>
        <td><?=$row->id?></td>
        <td><?=$row->name?></td>
        <td><?=\yii\bootstrap\Html::img($row->logo,["height"=>50])?></td>
        <td><?=Yii::$app->params["status"][$row->status]?></td>
        <td><?=$row->sort?></td>
        <td><?=$row->intro?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['edit','id'=>$row->id])?>"title="编辑"><spanp class="glyphicon glyphicon-edit btn-lg"style="color: green"></spanp></a>
            <a href="<?=\yii\helpers\Url::to(['del','id'=>$row->id])?>"title="删除"><spanp class="glyphicon glyphicon-remove btn-lg"style="color: red"></spanp></a>
            <a href="<?=\yii\helpers\Url::to(['chang','id'=>$row->id])?>"title="禁用"><span class="glyphicon glyphicon-eye-close btn-lg"style="color: grey"></span></a>
        </td>
    </tr>
<?php endforeach;?>
</table>

