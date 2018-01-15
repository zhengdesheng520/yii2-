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
        if(\Yii::$app->user->isGuest){
            $this->redirect(['user/login','back'=>'address/add']);
        }
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

    public function actionEdit($id){
        if(\Yii::$app->user->isGuest){
            $this->redirect(['user/login','back'=>"address/add"]);
        }
        $model=Address::findOne($id);
        $request=\Yii::$app->request;
        //判定post提交
        if($request->isPost){
            $model->load($request->post());
//            $model->status=$model->status;
//            echo "<pre>";
//            var_dump($model);exit;
            $model->user_id=\Yii::$app->user->identity->id;
            if ($model->save()) {
                return $this->redirect(['add']);
//                return $this->redirect(['user/user']);
            }

        }


        return $this->render('edit',compact('model'));




    }

    public function actionDel($id){
//        $userId=\Yii::$app->user->id;
        $model=Address::findOne($id);//        var_dump($model);exit;
        $model->delete();

//
        return $this->redirect(['address/add']);


    }


    public function actionDefault($id){
        $model=Address::find()->all();
//        var_dump($model);exit;
        foreach ($model as $v){
//            var_dump($v);exit;
            $v->status=0;
            $v->save();
        }
//
        $address=Address::findOne($id);
            $address->status=1;
            $address->save();


//        var_dump($model);exit;
        return $this->redirect(['address/add']);
    }




}
