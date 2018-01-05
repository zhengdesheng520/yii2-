<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Category;
use backend\models\Goods;
use backend\models\GoodsImg;
use backend\models\GoodsIntro;

use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class GoodsController extends \yii\web\Controller
{
    //配置富文本编辑器上传
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction'
            ]

        ];
    }

    public function actionIndex()
    {
        $query = Goods::find()->orderBy('id');
        $request=\Yii::$app->request;
        //实现关键字搜索
        $minPrice=$request->get('minPrice');
        $maxPrice=$request->get('maxPrice');
        $keyword=$request->get('keyword');
        $status=$request->get('status');


        //判定条件
        if($minPrice){
            $query->andWhere("shop_price>={$minPrice}");
        }
        if($maxPrice){
            $query->andWhere("shop_price<={$maxPrice}");
        }
        if($keyword){
            $query->andWhere("name like '%$keyword%'or sn like '%$keyword%'");
        }
        if(in_array($status,['0','1'])){
            $query->andWhere(["status"=>$status]);
        }




        //设置分页
        //得到数据的总条数
        $count=$query->count();
//        //创建一个分页对象
        $pageObj=new Pagination([
           'totalCount' => $count,
           'pageSize' => 3
        ]);
//        //设置limit 开始位置
        $goods=$query->offset($pageObj->offset)->limit($pageObj->limit)->all();


        return $this->render('index', compact('goods','pageObj'));
    }

    public function actionAdd()
    {
        $model = new Goods();
        //实例化商品详情对象
        $goodIntro = new GoodsIntro();
        //查找出所有商品分类
        $category = Category::find()->orderBy('tree,lft')->all();
        $cateArr = ArrayHelper::map($category, 'id', 'deep');
        //获取所有品牌分类
        $brand = Brand::find()->orderBy('id')->all();
        $brandArr = ArrayHelper::map($brand, 'id', 'name');

        $request = \Yii::$app->request;
        //判定post提交
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                //判定有没有传商品编号
                if (empty($model->sn)) {
                    //自动生成   201712110001   20171211+今天上传商品数量
                    $timeStart = strtotime(date('Ymd'));
                    //查出今天创建的所有商品数量
                    $count = Goods::find()->where("inputtime>={$timeStart}")->count();
                    $count = $count + 1;
                    $count = substr("000". $count, -4);
//                    var_dump($count);exit;
                    $model->sn = date('Ydm') . $count;
//                    var_dump($model->sn);exit;

                }
                $model->save();
                //绑定商品详情内容数据
                $goodIntro->load($request->post());
                $goodIntro->goods_id = $model->id;
                $goodIntro->save();

                //循环遍历保存以数组传过来的多图
                foreach ($model->imgFiles as $img) {
                    //实例化多图上传对象
                    $goodsImg = new GoodsImg();
                    $goodsImg->goods_id = $model->id;
                    $goodsImg->path = $img;
                    $goodsImg->save();


                }

                return $this->redirect(['index']);


            } else {
                var_dump($model->getErrors());
                exit;
            }

        }


        return $this->render('add', compact('model', 'cateArr', 'brandArr', 'goodIntro'));

    }


    public function actionEdit($id)
    {
        $model = Goods::findOne($id);
        //实例化商品详情对象
        $goodIntro =GoodsIntro::findOne(["goods_id"=>$id]);
        $goodsPath=GoodsImg::find()->where(['goods_id'=>$id])->all();
        $model->imgFiles=array_column($goodsPath,'path');

        //var_dump($goodIntro);exit;
        //查找出所有商品分类
        $category = Category::find()->orderBy('tree,lft')->all();
        $cateArr = ArrayHelper::map($category, 'id', 'deep');
        //获取所有品牌分类
        $brand = Brand::find()->orderBy('id')->all();
        $brandArr = ArrayHelper::map($brand, 'id', 'name');

        $request = \Yii::$app->request;
        //判定post提交
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                //判定有没有传商品编号
                if (empty($model->sn)) {
                    //自动生成   201712110001   20171211+今天上传商品数量
                    $timeStart = strtotime(date('Ymd'));
                    //查出今天创建的所有商品数量
                    $count = Goods::find()->where("inputtime>={$timeStart}")->count();
                    $count = $count + 1;
                    $count = substr("000", $count, -4);
                    $model->sn = date('Ydm') . $count;


                }
                $model->save();
                //绑定商品详情内容数据
                $goodIntro->load($request->post());
                $goodIntro->goods_id = $model->id;
                $goodIntro->save();
                //删除数据库原图
                GoodsImg::deleteAll(['goods_id'=>$id]);
                //循环遍历保存以数组传过来的多图
                foreach ($model->imgFiles as $img) {
                    //实例化多图上传对象
                    $goodsImg = new GoodsImg();
                    $goodsImg->goods_id = $model->id;
                    $goodsImg->path = $img;
                    $goodsImg->save();


                }

                return $this->redirect(['index']);


            } else {
                var_dump($model->getErrors());
                exit;
            }

        }


        return $this->render('add', compact('model', 'cateArr', 'brandArr','goodIntro'));

    }


    public function actionDel($id){
        $model=Goods::findOne($id);
        $model->delete();
        $goodsIntro=GoodsIntro::find()->where(['goods_id'=>$id])->one();
        $goodsIntro->delete();
        $goodsImg=GoodsImg::deleteAll(['goods_id'=>$id]);

        return $this->redirect(['index']);

    }


}
