<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $brand = Brand::find()->all();
        return $this->render('index', compact("brand"));
    }


    public function actionAdd()
    {
        $model = new Brand();
        $request = \Yii::$app->request;
        //判定post提交
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            if ($model->validate()) {
                    //保存数据
                    $model->save();
                    \Yii::$app->session->setFlash("success", "添加成功");
                    return $this->redirect(["index"]);
            } else {
                var_dump($model->getErrors());
                exit;
            }
        }



        return $this->render("add", ['model' => $model]);

    }
    public function actionEdit($id){
        $model =Brand::findOne($id);
        $request = \Yii::$app->request;
        //判定post提交
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            if ($model->validate()) {

                //保存数据
                $model->save();
                \Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(["index"]);
            } else {
                var_dump($model->getErrors());
                exit;
            }



        }


        return $this->render("add", ['model' => $model]);
    }
        public function actionDel($id){
            $model=Brand::findOne($id);
            $oldImg=Brand::findOne($id)->logo;
            if ($model->delete()) {
                //删除品牌时，同时删除图片
                unlink($oldImg);
                return $this->redirect(["index"]);

            }

        }


        //上传图片方法
    public function actionUpload(){
//            var_dump($_FILES);
        // 正确时， 其中 attachment 指的是保存在数据库中的路径，url 是该图片在web可访问的地址
       // {"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}
        $files=UploadedFile::getInstanceByName("file");
        //判定有没有上传路径
        if ($files) {
            //拼接路径
            $path="images/brand/".time().'.'.$files->extension;
            //移动图片
            if ($files->saveAs($path,false)) {
                //保存图片
                $result=[
                    'code'=>0,
                    'url'=>"/".$path,
                    'attachment'=>$path
                ];
                echo json_encode($result);
            }
        }



    }


}
