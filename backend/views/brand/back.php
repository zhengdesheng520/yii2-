<?php
/* @var $this yii\web\View */
?>
<h1>品牌展示</h1><a href="<?=\yii\helpers\Url::to(['brand/index'])?>"class="btn btn-info">返回</a>

<table class="table">
    <tr>
        <th>id</th>
        <th>品牌名称</th>
        <th>品牌图标</th>
        <th>状态</th>
        <th>排序</th>
        <th>介绍</th>
        <th>操作</th>
    </tr>
    <?php foreach ($model as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=\yii\bootstrap\Html::img($row->logo,["height"=>50])?></td>
            <td><?=Yii::$app->params["status"][$row->status]?></td>
            <td><?=$row->sort?></td>
            <td><?=$row->intro?></td>

            <td>
                <a href="<?=\yii\helpers\Url::to(['chang','id'=>$row->id])?>"title="启用"><span class="glyphicon glyphicon-eye-close btn-lg"style="color: blue"></span></a>
        </td>
        </tr>
    <?php endforeach;?>
</table>

