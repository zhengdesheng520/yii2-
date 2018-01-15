<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 11:30
 */

namespace frontend\components;


use frontend\models\Cart;
use yii\base\Component;
use yii\web\Cookie;

class ShopCart extends Component
{
    //私有化一个数组用来装从cookie里取出的值
    private $_cart=[];
    //创建自动执行方法
    public function __construct(array $config = [])
    {
        //取出cookie里面商品的数据
        $this->_cart=\Yii::$app->request->cookies->getValue('cart',[]);
        parent::__construct($config);
    }

    public function add($id,$amount){

        //判定cookie里面 的数据有没有商品，没有的话执行增加商品，有的话修改
        if (isset($this->_cart[$id])) {
            $this->_cart[$id]+=$amount;

        }else{
            //如果购物车里没有该商品，执行增加一个新商品
            $this->_cart[$id]=$amount;

        }
        return $this;


    }

//保存cookie方法
    public function save(){

        //2得到设置cookie的对象
        $setCookie=\Yii::$app->response->cookies;
        //3.生成一个COOKIE对象

        $cookie=new Cookie([
            'name' => 'cart',
            'value' => $this->_cart,
            'expire' => time()+3600*24*30
        ]);
//

        //4.利用cookie对象添加（保存）一个cookie
        $setCookie->add($cookie);
        //添加到购物车成功跳转到购物车列表
    }
    //修改方法购物车数量
    public function update($id,$amount){
        $this->_cart[$id]=$amount;
        return $this;


    }

    //删除购物车商品
    public function del($id){
        unset($this->_cart[$id]);
        return $this;

    }

    //登录后把保存在cookie里面的购物车的商品添加到对应user的数据库
    //本地数据同步到数据库
    public function insert(){
        //商品id=>商品数量
        foreach ($this->_cart as $goodsId=>$amount){
            $userId=\Yii::$app->user->id;
            //取出商品ID对应的商品数据
            $cartGoods=Cart::findOne(['good_id'=>$goodsId,'user_id'=>$userId]);
            //判定商品是否存在
            if($cartGoods){
                //如果存在，执行修改数量操作
                $cartGoods->amount+=$amount;
                $cartGoods->save();

            }else{
                //不存在执行新增商品操作
                $cart=new Cart();
                $cart->amount=$amount;
                $cart->user_id=$userId;
                $cart->good_id=$goodsId;
                $cart->save();


            }

        }
    }

    //登录成功保存数据后要清空未登录时保存的商品
    public function flush(){
        $this->_cart=[];
        return $this;
    }





}