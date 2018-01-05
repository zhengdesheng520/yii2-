<?php
/* @var $this yii\web\View */
?>
<h1>role/index</h1>

<a href="<?=\yii\helpers\Url::to(['add'])?>"class="btn btn-info">添加权限组</a>

<table class="table table-bordered table-striped">
    <tr>
        <th>权限组名</th>
        <th>组描述</th>
        <th>拥有权限</th>
        <th>操作</th>
    </tr>
    <?php foreach ($role as $row):?>
        <tr>
            <td><?=$row->name?></td>
            <td><?=$row->description?></td>
            <td>
                <?php
                $auth=Yii::$app->authManager;
                //获取所又对应对应的组的对应的权限
                $perArr=$auth->getPermissionsByRole($row->name);
                foreach ($perArr as $permission){
                    echo $permission->description."、";
                }

                ?>
             </td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','name'=>$row->name])?>"title="编辑"><spanp class="glyphicon glyphicon-edit btn-lg"style="color: green"></spanp></a>
                <a href="<?=\yii\helpers\Url::to(['del','name'=>$row->name])?>"title="删除"><spanp class="glyphicon glyphicon-remove btn-lg"style="color: red"></spanp></a>

            </td>
        </tr>
    <?php endforeach;?>
</table>
