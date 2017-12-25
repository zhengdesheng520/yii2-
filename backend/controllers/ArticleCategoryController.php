<?php

namespace backend\controllers;

use backend\models\ArticleCategory;

class ArticleCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $category=ArticleCategory::find()->all();
        return $this->render('index',compact('category'));
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
        if (ArticleCategory::findOne($id)->delete()) {
            return $this->redirect(['index']);
        }
    }



}
