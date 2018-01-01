<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\UploadedFile;
use flyok666\qiniu\Qiniu;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $brand = Brand::find()->where(['status'=>1])->all();
        return $this->render('index', compact("brand"));
    }

    //设置禁用启用
    public function actionChang($id){
        $model=Brand::findOne($id);
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

        $model=Brand::find()->where(['status'=>2])->orderBy('id')->all();

        return $this->render('back',compact('model'));

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
//        $files=UploadedFile::getInstanceByName("file");
        //判定有没有上传
//        if ($files) {
//            //拼接路径
//            $path="images/brand/".time().'.'.$files->extension;
//            //移动图片
//            if ($files->saveAs($path,false)) {
//                //保存图片
//                $result=[
//                    'code'=>0,
//                    'url'=>"/".$path,
//                    'attachment'=>$path
//                ];
//                echo json_encode($result);
//            }
//        }
        //上传到七牛云

        $config = [
            'accessKey' => '2PkV3UFQINHKWEQ1svmiJ7wJe3MsRigTj_OsZ5e9',//AK
            'secretKey' => 'EAK4piJt68WSfMb4rYwROym5oHxbrT38XlrN0Hgt',//SK
            'domain' => 'http://p1jt28cdr.bkt.clouddn.com',//临时域名

            'bucket' => 'yii2',//空间名称
            'area' => Qiniu::AREA_HUANAN//区域
        ];
        //实例化对象
        $qiniu=new Qiniu($config);
//        var_dump($qiniu);exit;
        //上传后的文件名
        $imgName=uniqid();
//        var_dump($imgName);exit;
        //调用上传方法上传文件
        $qiniu->uploadFile($_FILES['file']['tmp_name'],$imgName);
        //得到上传后的地址
        $url=$qiniu->getLink($imgName);
        //返回结果
        $result=[
            'code'=>0,
            'url'=>$url,
            'attachment'=>$url,
        ];

        return json_encode($result);

    }


}
