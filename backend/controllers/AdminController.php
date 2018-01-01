<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;

class AdminController extends \yii\web\Controller
{
    public function actionLogin(){
        $model=new LoginForm();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
           $result=Admin::find()->where(['username'=>$model->username])->one();
           if($result){
               //如果用户名存在，验证密码
               $password=\Yii::$app->security->validatePassword($model->password,$result->password);
               if($password){

                   //密码用户名正确，就执行登录
                   \Yii::$app->user->login($result,$model->rememberMe?3600*24*7:0);
                    //设置最后登录的时间
                   $result->last_login_time=date('Ymd');
                   //设置最后登录的IP地址
                   $result->last_login_ip=\Yii::$app->request->userIP;
                   $result->save();
                   return $this->redirect(['index']);

               }else{
                   $model->addError('password',"用户密码错误");
               }




           }else{
               $model->addError("username",'该用户不存在');
           }

        }


        return $this->render('login', ['model' => $model]);

    }






    public function actionIndex()
    {
        $model=Admin::find()->all();
        return $this->render('index',compact('model'));
    }

    public function actionAdd(){
        $model=new Admin();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if ($model->validate()) {
                $model->password=\Yii::$app->security->generatePasswordHash($model->password);
                $model->token=\Yii::$app->security->generateRandomString();
                $model->save();
                \Yii::$app->session->setFlash('info','添加成功');
                \Yii::$app->user->login($model,3600*24*7);
                //设置最后登录的时间
                $model->last_login_time=date('Ymd');
                //设置最后登录的IP地址
                $model->last_login_ip=\Yii::$app->request->userIP;
                $model->save();
                return $this->redirect(['index']);



            }else{
                var_dump($model->getErrors());exit;
            }


        }



        return $this->render('add',compact('model'));
    }
    public function actionEdit($id){
        $model=Admin::findOne($id);
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if ($model->validate()) {
                $model->password=\Yii::$app->security->generatePasswordHash($model->password);
                $model->token=\Yii::$app->security->generateRandomString();
                $model->save();
                \Yii::$app->session->setFlash('info','修改成功');

                return $this->redirect(['index']);



            }else{
                var_dump($model->getErrors());exit;
            }


        }



        return $this->render('add',compact('model'));
    }
        public function actionDel($id){
            if (Admin::findOne($id)->delete()) {
                return $this->redirect(['index']);
            }

        }


}
