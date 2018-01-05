<?php
/* @var $this yii\web\View */
?>

<h1>商品展示</h1>
<div>
    <div class="pull-left">
        <a href="<?=\yii\helpers\Url::to(['add'])?>"class="btn btn-info">添加商品</a>
    </div>
    <div class="pull-right">
        <form class="form-inline">
            <select class="form-control"name="status">
                <option>请选择商品状态</option>
                <option value="1"<?=Yii::$app->request->get('status')==="1"?"selected":""?>>上架</option>
                <option value="0"<?=Yii::$app->request->get('status')==="0"?"selected":""?>>下架</option>

            </select>

            <div class="form-group">

                <input type="text" class="form-control" size="4" name="minPrice" placeholder="最低价"value="<?=Yii::$app->request->get('minPrice')?>">
            </div>
            -
            <div class="form-group">

                <input type="text" class="form-control" size="4" name="maxPrice" placeholder="最高价"value="<?=Yii::$app->request->get('maxPrice')?>">
            </div>
            <div class="form-group">

                <input type="text" class="form-control"  name="keyword" placeholder="请输入商品名称或货号"value="<?=Yii::$app->request->get('keyword')?>">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
        </form>
    </div>


</div>

<table class="table table-bordered table-striped">
    <tr>
        <th>id</th>
        <th>商品名称</th>
        <th>商品编号</th>
        <th>商品图标</th>
        <th>所属分类</th>
        <th>所属品牌</th>
        <th>商品状态</th>
        <th>本店价格</th>
        <th>商品库存</th>
        <th>商品排序</th>
        <th>添加时间</th>
        <th>操作</th>

    </tr>
    <?php foreach ($goods as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=$row->sn?></td>
            <td><?=\yii\helpers\Html::img($row->logo,['height'=>50])?></td>
            <td><?=$row->cates->name?></td>
            <td><?=$row->brand->name?></td>
            <td><?=Yii::$app->params['is_on'][$row->status]?></td>
            <td><?=$row->shop_price?></td>
            <td><?=$row->stock?></td>
            <td><?=$row->sort?></td>
            <td><?=date('Y-m-d H:i:s',$row->inputtime)?></td>

            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$row->id])?>"title="编辑"><spanp class="glyphicon glyphicon-edit btn-lg"style="color: green"></spanp></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$row->id])?>"title="删除"><spanp class="glyphicon glyphicon-remove btn-lg"style="color: red"></spanp></a>

            </td>
        </tr>
    <?php endforeach;?>
</table>

<?=\yii\widgets\LinkPager::widget([
        'pagination' => $pageObj,
])?>


