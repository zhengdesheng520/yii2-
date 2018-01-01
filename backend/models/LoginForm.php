<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 18:34
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe=true;
    public function rules()
    {
        return [
          [['username','password'],'required'],
            [['rememberMe'],'safe']

        ];
    }
    public function attributeLabels()
    {
        return [
          'username'=>'用户姓名',
          'password'=>'用户密码',
            'remamberMe'=>'记住密码',
        ];
    }


}