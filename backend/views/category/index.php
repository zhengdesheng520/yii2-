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
        <tr class="cate" data-tree="<?=$row->tree?>" data-lft="<?=$row->lft?>" data-rgt="<?=$row->rgt?>">
            <td><?=$row->id?></td>
            <td><span class="glyphicon glyphicon-triangle-right"><?=$row->deep?></span></td>

            <td><?=$row->intro?></td>
            <td><?=$row->parent_id?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$row->id])?>"class=""><p class="glyphicon glyphicon-edit btn-lg"style="color: green"title="编辑"></p></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$row->id])?>"><p class="glyphicon glyphicon-trash btn-lg"style="color: red"title="删除"></p></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>

</div>


<?php
$js=<<<JS
$(".cate").click(function() {
  var tr=$(this);
  //有就删除图标，没有加图标
  tr.find("span").toggleClass("glyphicon-triangle-right");
  tr.find("span").toggleClass("glyphicon-triangle-bottom");
  
  //设置对应选中的那一行的值
  var left_parend=tr.attr('data-lft');
  var right_parent=tr.attr('data-rgt');
  var tree_parent=tr.attr('data-tree');
  console.log(tree_parent);
  console.log(left_parend,right_parent,tree_parent);
  $(".cate").each(function(k,v) {
    var left=$(v).attr("data-lft");//当前的左值
    //console.log(left);
    var right=$(v).attr("data-rgt");//当前的右值
    var tree=$(v).attr("data-tree");//当前的tree
    ////循环判断 当前tr的左值大于选中的那个左值  右值小于选中的那个右值 树等于选中那个树
    if(right-right_parent<0 && left-left_parend>0&& tree == tree_parent){
        //判定父类是不是展开状态
        if(tr.find('span').hasClass("glyphicon-triangle-bottom")){
            
            $(v).find('span').removeClass('glyphicon-triangle-right');
            $(v).find('span').addClass('glyphicon-triangle-bottom');
            $(v).hide();
            
        }else{
            //如果是闭合状态
            $(v).find('span').removeClass('glyphicon-triangle-bottom');
            $(v).find('span').addClass('glyphicon-triangle-right');
            $(v).show();
        }
        
    }
      
      
  })
    
    
})


JS;


$this->registerJs($js);



?>

