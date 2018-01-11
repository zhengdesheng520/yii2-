<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\captcha\Captcha;
use yii\captcha\CaptchaAction;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
{
    //设置验证码
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4
            ],
        ];
    }
//登录
    public function actionLogin(){
        $user=new LoginForm();
        $request=\Yii::$app->request;
        if($request->isPost){
            $user->load($request->post());
//var_dump($request->post());exit;
            if($user->validate()){
                //判定用户是否存在

                $result=User::findOne(['username'=>$user->username]);
//                var_dump($result);
                if($result){
                    $password=\Yii::$app->security->validatePassword($user->password,$result->password_hash);
                    if($password){
                        \Yii::$app->user->login($result,$user->remeMber?3600*24*7:0);
                        return $this->redirect(['home/index']);

                    }else{
                        echo "<script>alert('密码错误')</script>";
                    }


                }else{
                    echo "<script>alert('用户名不存在')</script>";
                }
            }else{
                var_dump($user->errors);
            }






        }


        return $this->render('login');

    }
    //注销登录
        public function actionLogout(){

            if (\Yii::$app->user->logout()) {
                return $this->redirect(['login']);
            }

        }





    public function actionUser()
    {


        return $this->render('user');
    }

    public function actionRegist(){

        $request=\Yii::$app->request;
        //判定post提交
        if ($request->isPost) {
            // return 111;

          $user=new User();
          //数据绑定
            $user->load($request->post());
            if ($user->validate()) {
                //保存数据
                $user->password_hash=\Yii::$app->security->generatePasswordHash($user->password_hash);
                $user->auth_key=\Yii::$app->security->generateRandomString();
                if ($user->save(false)) {

                    //返回数据
                    return Json::encode(
                        [
                            'status'=>1,
                            'msg'=>"注册成功",
                            'data'=>null
                        ]

                    );
                    }
                }

            return Json::encode( [
                'status'=>0,
                'msg'=>"注册失败",
                'data'=>$user->errors
            ]);

//             var_dump($user->errors); exit;

        }


        return $this->render('regist');
    }

    //短信验证方法
    public function actionSms($phone){
       //1.生成随机验证码
          $code=rand(100000,999999);
         //2.发送验证给手机
//         //配置文件
        $config = [
            'access_key' => 'LTAIcKAUiorUUgrR',//应用ID
            'access_secret' => 'dVtszU8LToXQO5h9hQJ7Pqa7LD5qN8',//秘钥
            'sign_name' => '郑德胜',//签名
        ];

//        //3.创建短信发送对象，内置对象
        $codeObj=new AliSms();
        //发送短信
        $response = $codeObj->sendSms($phone, 'SMS_120406025', ['code'=> $code], $config);
    var_dump($response);
        //3.把验证码保存起来
        \Yii::$app->session->set('tel_'.$phone,$code);

        return $code;
    }


//验证表单输入的短信验证码
public function actionCheck($tel){
        //验证短信验证码是否正确
    //根据对应的手机号取对应的验证码，验证
    $code=\Yii::$app->session->get('tel_'.$tel);
    return $code;

}




}
