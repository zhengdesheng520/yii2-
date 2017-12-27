<?php

namespace backend\controllers;

use backend\models\Category;
use yii\data\Pagination;
use yii\helpers\Json;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
//        $category = Category::find()->all();

        $query = Category::find()->orderBy("id");
        //设置分页
        //得到数据总条数
        $count = $query->count();
        //得到分页对象
        $pagobj = new Pagination([
            "totalCount" => $count,
            //每页显示条数
            "pageSize" => 4
        ]);
        //设置起始位置Limite
        $category = $query->offset($pagobj->offset)->limit($pagobj->limit)->all();


        return $this->render("index", compact("category", "pagobj"));


    }

    public function actionAdd()
    {
        //创建模型对象
        $model = new Category();
        //找出所有的分类
        $cateArr = Category::find()->asArray()->all();
        $cateArr[] = ['id' => 0, 'name' => '顶级目录', 'parent_id' => 0];
        //转成JSON格式
        $cateArr = Json::encode($cateArr);

        $request = \Yii::$app->request;
        //判定post提交
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //后端验证
            if ($model->validate()) {
                //如果parent_id等于零的情况下，判定为创建顶级分类
                if ($model->parent_id == 0) {
                    $model->makeRoot();
                    \Yii::$app->session->setFlash('danger', '添加顶级分类' . $model->name . '成功');


                } else {
                    //追加到对应的父分类里面
                    //找到父节点
                    $parent = Category::findOne($model->parent_id);
                    //var_dump($parent);exit;
                    $model->prependTo($parent);
                    \Yii::$app->session->setFlash('danger', '把' . $model->name . '追加到' . $parent->name . '里面成功');


                }
                //刷新
                return $this->refresh();



            }

        }


        return $this->render('add', ['model' => $model, 'cateArr' => $cateArr]);
    }
    public function actionEdit($id){
        //创建模型对象
        $model = Category::findOne($id);
        //找出所有的分类
        $cateArr = Category::find()->asArray()->all();
        $cateArr[] = ['id' => 0, 'name' => '顶级目录', 'parent_id' => 0];
        //转成JSON格式
        $cateArr = Json::encode($cateArr);

        $request = \Yii::$app->request;
        //判定post提交
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //后端验证
            if ($model->validate()) {
                //如果parent_id等于零的情况下，判定为创建顶级分类
                if ($model->parent_id == 0) {
                    $model->makeRoot();
                    \Yii::$app->session->setFlash('danger', '添加顶级分类' . $model->name . '成功');


                } else {
                    //追加到对应的父分类里面
                    //找到父节点
                    $parent = Category::findOne($model->parent_id);
                    //var_dump($parent);exit;
                    $model->prependTo($parent);
                    \Yii::$app->session->setFlash('danger', '把' . $model->name . '追加到' . $parent->name . '里面成功');


                }
                //跳转

                return $this->redirect(['index']);
                \Yii::$app->session->setFlash('success','修改成功');

            }

        }


        return $this->render('add', ['model' => $model, 'cateArr' => $cateArr]);
    }
    public function actionDel($id){
        if (Category::findOne($id)->deleteWithChildren()) {
            return $this->redirect(['index']);
        }
    }



}
