<?php
/* @var $this yii\web\View */
?>


<?php
/* @var $this yii\web\View */
?>
<h1>文章展示</h1>
<div class="table-responsive">
<a href="<?=\yii\helpers\Url::to(['article/add'])?>"class="btn btn-info">添加文章</a>
<a href="<?=\yii\helpers\Url::to(['back'])?>"title="回收站"><span class="glyphicon glyphicon-trash "style="color: red;font-size: 30px;float: right"></span></a>
<table class="table">
    <tr>
        <th>id</th>
        <th>文章名称</th>
        <th>分类</th>
        <th>文章介绍</th>
        <th>状态</th>
        <th>排序</th>
        <th>文章内容</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($article as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=$row->category->name?></td>
            <td><?=$row->intro?></td>

            <td style="color: red"><?=Yii::$app->params['status'][$row->status]?></td>

            <td><?=$row->sort?></td>
            <td><a href="<?=\yii\helpers\Url::to(['look','id'=>$row->id])?>">查看内容</a></td>
            <td><?=date('Y-m-d H:i:s',$row->createtime)?></td>

            <td>
                <a href="<?=\yii\helpers\Url::to(['article/edit','id'=>$row->id])?>"title="编辑"><spanp class="glyphicon glyphicon-edit btn-lg"style="color: green"></spanp></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$row->id])?>"title="删除"><spanp class="glyphicon glyphicon-remove btn-lg"style="color: red"></spanp></a>
                <a href="<?=\yii\helpers\Url::to(['chang','id'=>$row->id])?>"title="禁用"><span class="glyphicon glyphicon-eye-close btn-lg"style="color: grey"></span></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
</div>


