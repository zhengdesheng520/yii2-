<?php
/* @var $this yii\web\View */
?>


<?php
/* @var $this yii\web\View */
?>
<h1>文章展示</h1>
<a href="<?=\yii\helpers\Url::to(['article/index'])?>"class="btn btn-info">返回</a>

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
    <?php foreach ($model as $row):?>
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
                <a href="<?=\yii\helpers\Url::to(['chang','id'=>$row->id])?>"title="启用"><span class="glyphicon glyphicon-eye-open btn-lg"style="color: red"></span></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>


