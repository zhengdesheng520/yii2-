<?php
/* @var $this yii\web\View */
?>
<h1>品牌展示</h1><a href="<?=\yii\helpers\Url::to(['brand/add'])?>"class="btn btn-info">添加品牌</a>
<table class="table">
    <tr>
        <th>id</th>
        <th>品牌名称</th>
        <th>品牌图标</th>
        <th>状态</th>
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
            <a href="<?=\yii\helpers\Url::to(['brand/edit','id'=>$row->id])?>"class="btn btn-success">编辑</a>
            <a href="<?=\yii\helpers\Url::to(['del','id'=>$row->id])?>"class="btn btn-danger">删除</a>
        </td>
    </tr>
<?php endforeach;?>
</table>

