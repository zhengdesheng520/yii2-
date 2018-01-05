<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\AuthItem;
use backend\models\LoginForm;
use yii\helpers\ArrayHelper;

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
                   $result->save(false);
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
//        $role=AuthItem::find()->asArray()->all();
        $auth=\Yii::$app->authManager;
        //获取所有的组名
        $role=$auth->getRoles();
        //获取key值就可以，显示到视图
//        $roleArr=array_keys($role);
        $roleArr=ArrayHelper::map($role,'name','description');
//        echo "<pre>";
//        var_dump($roleArr);exit;


        $model->scenario='create';
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
                if ($model->save()) {
//                    $auth = \Yii::$app->authManager;
//                    var_dump($model->name);exit;
                    //判定有没有添加角色
                    if($model->name){
                        //角色是多个，一对多要循环添加
                        foreach ($model->name as $roleName){
                            $pro = $auth->getRole($roleName);
                            //给对应的用户分对应的组
                            $auth->assign($pro,$model->id);
//                            $auth->addChild($)
                        }

                    }

                }



                return $this->redirect(['index']);



            }else{
                var_dump($model->getErrors());exit;
            }


        }



        return $this->render('add',compact('model','roleArr'));
    }



    public function actionEdit($id){
        $model=Admin::findOne($id);
        $model->scenario="update";
        $password=$model->password;
        $model->password='';
        $request=\Yii::$app->request;
        $auth=\Yii::$app->authManager;
        //获取所有的组名
        $role=$auth->getRoles();
        //获取key值就可以，显示到视图
        $roleArr=ArrayHelper::map($role,'name','description');
//        $roleArr=array_keys($role);
        if($request->isPost){

            $model->load($request->post());
    //var_dump($request->post()["Admin"]['password']);exit;
            if ($model->validate()) {
                if(empty($request->post()["Admin"]['password'])){
                  $model->password=$password;

                }else{
//                    echo 123;exit;
                    $model->password=\Yii::$app->security->generatePasswordHash($request->post()["Admin"]['password']);

                }


               $model->token=\Yii::$app->security->generateRandomString();
                if ($model->save()) {
//                   $rolerw =  $auth->getRolesByUser($model->id);
//                   var_dump($rolerw);exit;
                    //删除用户对应的所有组，原本添加的组
                   $auth->revokeAll($id);
//                    var_dump($model->name);exit;

                    if($model->name){
                        foreach ($model->name as $roleName){
                            $pro = $auth->getRole($roleName);
//                            $auth->revoke($pro,$model->id);
//                            $auth->addChild($)
                            $auth->assign($pro,$id);
                        }

                    }
                }




                \Yii::$app->session->setFlash('info','修改成功');

                return $this->redirect(['index']);



            }else{
                var_dump($model->getErrors());exit;
            }


        }
        //根据角色名找对应的角色组
        $rows=$auth->getRolesByUser($id);
//        echo "<pre>";
//        var_dump($rows);exit;
        //取键回显
        $model->name=array_keys($rows);



        return $this->render('add',compact('model','roleArr'));
    }
        public function actionDel($id){
            if (Admin::findOne($id)->delete()) {
                return $this->redirect(['index']);
            }

        }



        public function actionLogout(){
            if (\Yii::$app->user->logout()) {
                return $this->redirect(['login']);
            }
        }


}
