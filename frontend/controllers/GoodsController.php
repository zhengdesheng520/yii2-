<?php

namespace frontend\controllers;

use backend\models\Category;
use backend\models\Goods;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList($id){
        //1.找出当前分类
        $cate=Category::findOne($id);
//        var_dump($cate);exit;
        //2.找出当前分类的所有子类，左值大于当前分类左值，右值小于当前分类右值
        $cateSon=Category::find()->where(['tree'=>$cate->tree])->andWhere("lft>={$cate->lft}")->andWhere("rgt<={$cate->rgt}")->asArray()->all();
//        var_dump($cateSon);exit;
        //使用函数array_colunm提取出二维数组中的ID值
        $cateId=array_column($cateSon,'id');
//        var_dump($cateId);exit;

        //3.根据提取出来的分类ID，查找出所有符合条件的商品
        $goods=Goods::find()->where(['in' ,'good_category_id',$cateId])->andWhere(['status'=>1])->all();
//        var_dump($goods);exit;


        return $this->render('list',compact('goods'));
    }


    //商品详情
    public function actionDetail($id){
        //找到当前对应的商品

        $goods=Goods::findOne($id);
//        var_dump($goods->imgs[0]);exit;

        return $this->render('detail',compact('goods'));


    }







}
