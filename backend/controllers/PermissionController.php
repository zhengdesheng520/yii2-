<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    public function actionIndex()
    {

        //实例化autumanager组件
        $anth=\Yii::$app->authManager;
        //获取所有权限
        $permission=$anth->getPermissions();

        return $this->render('index',compact('permission'));
    }

    public function actionAdd(){
        //实例化autumanager组件
            $auth=\Yii::$app->authManager;
            $model=new AuthItem();
            //判定post提交后台验证
        if ($model->load(\Yii::$app->request->post())&& $model->validate()) {
//            echo "<pre>";
//            var_dump($model);exit;
            //1.创建权限
            $permission=$auth->createPermission($model->name);
            //var_dump($permission);exit;
            //设置权限
            $permission->description=$model->description;
            //添加入库
            if ($auth->add($permission)) {
                \Yii::$app->session->setFlash('info','添加权限'.$model->name.'成功');
                return $this->refresh();
            }

        }
         return $this->render('add',compact('model'));
    }

    public function actionEdit($name){
        //实例化组件
        $auth=\Yii::$app->authManager;
        //找到需要修改的权限
        $model=AuthItem::findOne($name);

        //判断是不是post提交
        if ($model->load(\Yii::$app->request->post())&&$model->validate()) {
            //找到需要修改的权限’
            $permission=$auth->getPermission($model->name);
            if($permission){
                //2.修改权限
                $permission->description=$model->description;
                //添加入库
                if ($auth->update($name,$permission)) {
                    \Yii::$app->session->setFlash('success','修改权限'.$model->name.'成功');
                    return $this->redirect(['index']);

                }


            }


        }
            return $this->render('edit',compact('model'));



    }
    public function actionDel($name){
        //实例化组件
        $auth=\Yii::$app->authManager;
        $model=$auth->getPermission($name);
        if ($auth->remove($model)) {
            return $this->redirect(['index']);
        }

    }






}
