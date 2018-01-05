<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class RoleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $auth=\Yii::$app->authManager;
        //获取所有的组
        $role=$auth->getRoles();

        return $this->render('index',compact('role'));
    }
    public function actionAdd(){
        //实例化组件
        $auth=\Yii::$app->authManager;
        $model=new AuthItem();
        //获取所有权限
        $pers=$auth->getPermissions();
        $perArr=ArrayHelper::map($pers,'name','description');
        //判定post提交
        if ($model->load(\Yii::$app->request->post())&&$model->validate()) {
            //1.创建角色
            $role=$auth->createRole($model->name);
            //2.设置描述
            $role->description=$model->description;
            //添加入库
            if ($auth->add($role)) {
                //判定是否有添加权限
                if($model->permission){
                    //循环添加权限
                    foreach ($model->permission as $perName){
                        //通过权限名称找到对应的权限对象
                        $permission=$auth->getPermission($perName);
                        //添加到对应的父类下面
                        $auth->addChild($role,$permission);


                    }

                }
                \Yii::$app->session->setFlash('info','添加组'.$model->name.'成功');
                return $this->refresh();

            }


        }

        return $this->render('add',compact('model','perArr'));


    }
    public function actionEdit($name){
        $auth=\Yii::$app->authManager;
        //找到当前角色
        $model=AuthItem::findOne($name);
        //找到所有的权限
        $pers=$auth->getPermissions();
        $perArr=ArrayHelper::map($pers,'name','description');
        //判定post提交
        if ($model->load(\Yii::$app->request->post())&&$model->validate()) {
//           //找到要修改的角色
            $role=$auth->getRole($name);
//            var_dump($role);exit;
            //设置对应的描述
            $role->description=$model->description;
            //保存数据
            if ($auth->update($name,$role)) {
                //删除当前角色对应的权限，删除角色对应的所有权限
                $auth->removeChildren($role);
                //判定是否修改权限
                if($model->permission){
                    //遍历post传过来的数组权限
                    foreach ($model->permission as $perName){
                        //通过权限名$pername找到对应角色的权限
                        $permission=$auth->getPermission($perName);
                        //吧权限加入到对应的角色中
                        $auth->addChild($role,$permission);

                    }
                    \Yii::$app->session->setFlash('danger','修改成功');
                     return $this->redirect(['index']);

                }

            }
//
//
//
        }
        //权限回显
        //通过角色找到所有的角色对应的权限
        $rows=$auth->getPermissionsByRole($name);
//        echo "<pre>";
//        var_dump(array_keys($rows));exit;
        $model->permission=array_keys($rows);





        return $this->render('edit',compact('model','perArr'));
    }

    public function actionDel($name){
        $auth=\Yii::$app->authManager;
        //找到要删除的角色
        $role=$auth->getRole($name);
        //删除角色所对应的所有权限
        $auth->removeChildren($role);
        //删除角色
        if ($auth->remove($role)) {
            $this->redirect(['index']);
        }


    }




}
