<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\helpers\ArrayHelper;

class ArticleController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'upload'=>[
                'class'=>'kucha\ueditor\UEditorAction'
            ]
        ];
    }


    public function actionIndex()
    {
//        $article=Article::find()->all();
        $article = Article::find()->where(['status'=>1])->orderBy('id')->all();
        return $this->render('index', compact('article'));
    }

    //设置禁用启用
    public function actionChang($id){
        $model=Article::findOne($id);
        if($model->status===1){
            $model->status=2;
            $model->save();
            return $this->redirect(['index']);
        }else{
            $model->status=1;
            $model->save();
            return $this->redirect(['back']);
        }

    }

    public function actionBack(){

        $model=Article::find()->where(['status'=>2])->orderBy('id')->all();

        return $this->render('back',compact('model'));

    }






    public function actionAdd()
    {

        $model = new Article();
        $content=new ArticleDetail();
        //得到所有的文章分类
        $category=ArticleCategory::find()->asArray()->all();
        //转换成键值对
        $cateArr=ArrayHelper::map($category,'id','name');

        $request=\Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->save();
//                return $this->redirect(['index']);
                $content->load($request->post());
                $content->article_id=$model->id;
                $content->save();
                return $this->redirect(['index']);

            }

        }





        return $this->render('add', compact('model','content','cateArr'));
    }



    //修改文章
public function actionEdit($id){
    $model = Article::findOne($id);
    $content=ArticleDetail::find()->where(['article_id'=>$id])->one();
    //得到所有的文章分类
    $category=ArticleCategory::find()->asArray()->all();
    //转换成键值对
    $cateArr=ArrayHelper::map($category,'id','name');

    $request=\Yii::$app->request;
    if ($request->isPost) {
        $model->load($request->post());
        if ($model->validate()) {
            $model->save();
//                return $this->redirect(['index']);
            $content->load($request->post());
            $content->article_id=$model->id;
            $content->save();
            return $this->redirect(['index']);

        }

    }





    return $this->render('add', compact('model','content','cateArr'));

}

//删除
public function actionDel($id){
    $model=Article::findOne($id);
    //找到该文章下的内容并一起删除
    $detail=ArticleDetail::find()->where(['article_id'=>$model->id])->one();
//    var_dump($detail);exit;
$model->delete();
$detail->delete();
return $this->redirect(['index']);


}


public function actionLook($id){
//    var_dump($id);exit;>
    $article=ArticleDetail::find()->where(['article_id'=>$id])->one();
//    var_dump($article);exit;
    return $this->render('/article-detail/index', ['article' => $article]);
}


}
