<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Cart;
use yii\web\Cookie;

class CartController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }



//购物车方法
    public function actionAddCart($id,$amount){

        //1判定有没有登录，没有登录把商品信息存入cookie里面
        if (\Yii::$app->user->isGuest) {
            //5.取出cookie里面的数据进行判定
            $cookieData=\Yii::$app->request->cookies->getValue('cart',[]);//设置为默认的一个数组不然在cookie不存在的情况下会报错
            //6用函数array_key_exists判定取出来的cookie值里面有没有当前商品的id，这个key值，（键名为当前商品的id）
//        var_dump(array_key_exists($id,$cookieData));exit;
            if(array_key_exists($id,$cookieData)){
                //7如果返回结果是true，执行修改操作，商品加1
                $cookieData[$id]+=$amount;
            }else{
                //8如果返回结果为false证明购物车没有改商品，执行增加操作
                $cookieData[$id]=$amount;
            }
            //把
//            var_dump($cookieData);exit;

            //2得到设置cookie的对象
            $setCookie=\Yii::$app->response->cookies;
            //3.生成一个COOKIE对象
            $cookie=new Cookie([
                'name' => 'cart',
                'value' => $cookieData,
                'expire' => time()+3600*24*30
            ]);
//

            //4.利用cookie对象添加（保存）一个cookie
            $setCookie->add($cookie);
            //添加到购物车成功跳转到购物车列表



        }else{
            //如果登录了把购物车商品加入数据库
           $user_id=\Yii::$app->user->id;
//           var_dump($user_id);exit;
            $goodsOle=Cart::find()->where(['good_id'=>$id])->andWhere(['user_id'=>$user_id])->all();
//            var_dump($goodsOle);exit;
            //判定有没有查询到对应用户的数据,有的话就数量加
            if($goodsOle){
                $goodsOle[0]->amount+=$amount;
                $goodsOle[0]->save();

            }else{
                $cart=new Cart();
                $cart->good_id=$id;
                $cart->user_id=$user_id;
                $cart->amount=$amount;
                $cart->save();

            }


        }
        return $this->redirect(['cart-list']);

    }


    //购物车列表页
    public function actionCartList(){
        //判定有没有登录，如果没登录在cookie里面取数据
        if (\Yii::$app->user->isGuest) {
            $cateData=\Yii::$app->request->cookies->getValue('cart',[]);
//       var_dump($cateData);exit;
            //取出所有商品的ID，也就是取出所有商品的键
            $goodsId=array_keys($cateData);
//            var_dump($goodsId);exit;
            //通过取出的商品id吧所有数据取出来

            $goods=Goods::find()->where(['in','id',$goodsId])->asArray()->all();
//        var_dump($goods);exit;
            foreach ($goods as $k=>$v){
                //循环添加一个字段num，好标识购物车一共有多少件商品
                $goods[$k]['num']=$cateData[$v['id']];

            }
//        var_dump($goods);exit;
        }else{
            //如果登录，在数据库里面取
            $user_id=\Yii::$app->user->id;
            $carts=Cart::find()->where(['user_id'=>$user_id])->asArray()->all();
//            var_dump($carts);exit;
//            $goodsId=[];
            //取出数组中商品的ID，键值
            foreach ($carts as $k=>$v){
                $carts[$k]=$v['good_id'];
            }
//            var_dump($carts);exit;
            //通过goodsid查到对应的所有商品
            $goods=Goods::find()->where(['in','id',$carts])->asArray()->all();
            //吧数量绑定在数组中
         foreach ($goods as $k=>$good){
             $goods[$k]['num']=Cart::findOne(['good_id'=>$good['id'],'user_id'=>\Yii::$app->user->id])->amount;
         }
//            var_dump($goods);exit;

        }




        return $this->render('cart-list',compact('goods'));
    }








//修改数量后的操作

    public function actionUpdateCart($id,$amount){
        //判定是否是游客
        if (\Yii::$app->user->isGuest) {
            $cate=\Yii::$app->request->cookies->getValue('cart',[]);
//            var_dump($cate);exit;
            $cate[$id]=$amount;

            //创建一个执行cookie的对象
            $cookObj=\Yii::$app->response->cookies;
            //设置一个cookie
            $cookie=new Cookie([
                'name' => 'cart',
                'value' => $cate,
                'expire' => time()+3600*24*30
            ]);
            $cookObj->add($cookie);
//            return 111;
        }else {
            //如果登录了把购物车商品加入数据库
            $user_id = \Yii::$app->user->id;
//           var_dump($user_id);exit;
            $goodsOle = Cart::find()->where(['good_id' => $id])->andWhere(['user_id' => $user_id])->all();
//            var_dump($goodsOle);exit;
            $goodsOle[0]->amount = $amount;
            $goodsOle[0]->save();
        }




    }
    public function actionDelCart($id){
        //判定是否是游客
        if (\Yii::$app->user->isGuest) {
            $cate=\Yii::$app->request->cookies->getValue('cart',[]);
//            var_dump($cate);exit;
           unset($cate[$id]);

            //创建一个执行cookie的对象
            $cookObj=\Yii::$app->response->cookies;
            //设置一个cookie
            $cookie=new Cookie([
                'name' => 'cart',
                'value' => $cate,
                'expire' => time()+3600*24*30
            ]);
            $cookObj->add($cookie);

        }else{
            $user_id=\Yii::$app->user->id;
            Cart::findOne(['user_id'=>$user_id,'good_id'=>$id])->delete();

        }
        return $this->redirect(['cart/cart-list']);

        }







}
