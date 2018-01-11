<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 14:02
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $password;
    public $username;
    public $checkCode;
    public $remeMber;
    public function rules()
    {
        return [
          [['username','password','checkCode'],'required'],
            [['remeMber'],'safe'],
          [['checkCode'],'captcha','captchaAction' => '/user/captcha']
        ];
    }
    public function attributeLabels()
    {
        return [
          'username'=>'用户名',
          'pasword'=>'用户密码',
          'checkcode'=>'验证码'
        ];
    }


}