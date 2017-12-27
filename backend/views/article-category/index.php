<?php
/* @var $this yii\web\View */
?>
<h1>分类管理</h1>

<a href="<?=\yii\helpers\Url::to(['add'])?>"class="btn btn-info">添加文章</a>
<table class="table">
    <tr>
        <th>id</th>
        <th>分类名称</th>
        <th>状态</th>
        <th>排序</th>
        <th>是否帮助类</th>

        <th>操作</th>
    </tr>
    <?php foreach ($category as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=Yii::$app->params['status'][$row->status]?></td>
            <td><?=$row->sort?></td>
            <td><?=Yii::$app->params["is_help"][$row->is_help]?></td>



            <td>
                <a href="<?=\yii\helpers\Url::to(['article-category/edit','id'=>$row->id])?>"class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['article-category/del','id'=>$row->id])?>"class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
        'pagination' => $pageObj
])?>



