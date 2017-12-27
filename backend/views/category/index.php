<?php
/* @var $this yii\web\View */
?>
<h1>物品分类展示</h1>

<a href="<?=\yii\helpers\Url::to(['add'])?>"class="btn btn-info">添加分类</a>
<div>
<table class="table">
    <tr>
        <th>id</th>
        <th>分类名称</th>
        <th>简介</th>
        <th>父类ID</th>
        <th>操作</th>


    </tr>
    <?php foreach ($category as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>

            <td><?=$row->intro?></td>
            <td><?=$row->parent_id?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$row->id])?>"class=""><p class="glyphicon glyphicon-edit btn-lg"style="color: green"title="编辑"></p></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$row->id])?>"><p class="glyphicon glyphicon-trash btn-lg"style="color: red"title="删除"></p></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
    <?=\yii\widgets\LinkPager::widget([
            'pagination' => $pagobj
    ])?>
</div>

