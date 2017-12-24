<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleDetail;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $article = Article::find()->orderBy('id')->all();
        return $this->render('index', compact('article'));
    }

    public function actionAdd()
    {

        $model = new Article();

        $request=\Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->save();
//                return $this->redirect(['index']);
            }else{
                var_dump($model->getErrors());
            }

        }
        $content=new ArticleDetail();
        $request=\Yii::$app->request;
        if ($request->isPost) {
            $content->load($request->post());
            if ($content->validate()) {
                $content->article_id=$model->id;

                $content->save();
                return $this->redirect(['index']);
            }else{
                var_dump($content->getErrors());
            }

        }


        return $this->render('add', compact('model','content'));
    }



    //修改文章
public function actionEdit($id){

    $model = Article::findOne($id);

    $request=\Yii::$app->request;
    if ($request->isPost) {
        $model->load($request->post());
        if ($model->validate()) {
            $model->save();
//                return $this->redirect(['index']);
        }else{
            var_dump($model->getErrors());
        }

    }
    $content=ArticleDetail::findOne($id);
    $request=\Yii::$app->request;
    if ($request->isPost) {
        $content->load($request->post());
        if ($content->validate()) {
            $content->article_id=$model->id;

            $content->save();
            return $this->redirect(['index']);
        }else{
            var_dump($content->getErrors());
        }

    }


    return $this->render('add', compact('model','content'));


}

//删除
public function actionDel($id){
    if (Article::findOne($id)->delete()) {
        return $this->redirect(['index']);
    }
}
public function actionLook($id){
//    var_dump($id);exit;>
    $article=ArticleDetail::find()->where(['article_id'=>$id])->one();
//    var_dump($article);exit;
    return $this->render('/article-detail/index', ['article' => $article]);
}


}
