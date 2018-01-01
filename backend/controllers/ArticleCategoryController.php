<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use yii\data\Pagination;

class ArticleCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
//        $category=ArticleCategory::find()->all();
        $query=ArticleCategory::find()->orderBy('id');
        //设置分页
        //得到数据的总条数
        $count=$query->count();
        //得到分页对象
        $pageObj=new Pagination([
            'totalCount' => $count,
            'pageSize' => 3
        ]);
        $category=$query->offset($pageObj->offset)->limit($pageObj->limit)->all();


        return $this->render('index',compact('category','pageObj'));
    }


    public function actionAdd(){

        $model=new ArticleCategory();
        //判定post提交
        $request=\Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('danger','添加成功');
                return $this->redirect(['index']);

            }else{
                var_dump($model->getErrors());exit;
            }


        }


        return $this->render('add', ['model' => $model]);

    }



    public function actionEdit($id){
        $model=ArticleCategory::findOne($id);
        //判定post提交
        $request=\Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('danger','修改成功');
                return $this->redirect(['index']);

            }else{
                var_dump($model->getErrors());exit;
            }


        }


        return $this->render('add', ['model' => $model]);
    }

    public function actionDel($id){
        $model=ArticleCategory::findOne($id);
        $article=Article::find()->where(['article_category_id'=>$model->id])->one();

//        echo "<pre>";
//        var_dump($article);exit;
        if (!$article==null){
            \Yii::$app->session->setFlash('danger','该分类下有文章，请先删除文章');
            return $this->redirect(['index']);
        }else{
            $model->delete();
            return $this->redirect(['index']);
        }





    }



}
