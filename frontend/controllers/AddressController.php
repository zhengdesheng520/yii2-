<?php

namespace frontend\controllers;

use frontend\models\Address;

class AddressController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAdd(){
        $model=new Address();
        $request=\Yii::$app->request;
        //判定post提交
        if($request->isPost){
            $model->load($request->post());
//            $model->status=$model->status;
//            echo "<pre>";
//            var_dump($model);exit;
            $model->user_id=\Yii::$app->user->identity->id;
            if ($model->save()) {
                return $this->refresh();
//                return $this->redirect(['user/user']);
            }

        }


        return $this->render('address');

    }

    public function actionEdit(){

     return 111;
    }





}
