<?php

namespace frontend\controllers;

use backend\models\Goods;
use dosamigos\qrcode\lib\Enum;
use dosamigos\qrcode\QrCode;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDatail;
use function PHPSTORM_META\map;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use EasyWeChat\Foundation\Application;
use yii\helpers\Url;

class OrderController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        //判定是否是游客
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(['user/login', 'back' => '/order/index']);
        }
        $userId = \Yii::$app->user->id;
        $address = Address::find()->where(['user_id' => $userId])->all();
        $cart = Cart::find()->where(['user_id' => $userId])->asArray()->all();
        //取出所有商品
        $cartGoods = ArrayHelper::map($cart, 'good_id', 'amount');
        //取出所有的goodsid
        $goodsId = array_column($cart, 'good_id');
//            var_dump($cartGoods);exit;
        //通过商品ID把所有商品取出来
        $goods = Goods::find()->where(['in', 'id', $goodsId])->asArray()->all();
//        var_dump($goods);exit;
        //默认运费
        $yunFei = ArrayHelper::map(\Yii::$app->params['give'], 'id', 'price');

        //计算总价
        $totalPrice = 0;
        foreach ($goods as $k => $v) {
            //追加购物车每个商品数量字段
//                var_dump($v);exit;
            $goods[$k]['num'] = $cartGoods[$v['id']];
            $totalPrice += $v['shop_price'] * $cartGoods[$v['id']];

        }
        //运费加商品总价得到应付金额
        $allPrice = $totalPrice + $yunFei[1];

        //处理表单传过来的数据
        $request=\Yii::$app->request;
        if($request->isPost){

            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();

            try {

                //echo "<pre>";
                //var_dump($request->post('address'));exit;
                //根据表单传递过来的地址id找出发货地址
                $addresses=Address::findOne($request->post('address'));
                //取出送货方式
                $delivery=ArrayHelper::map(\Yii::$app->params['give'],'id','name');
                //取出运费
                $yun_fei=ArrayHelper::map(\Yii::$app->params['give'],'id','price');
                //取出支付方式
                $pay=ArrayHelper::map(\Yii::$app->params['pay'],'id','name');
//            echo "<pre>";
//            var_dump($yun_fei);exit;
                //实例化订单对象
                $order=new Order();
                $order->user_id=$userId;
                $order->name=$addresses->name;
                $order->province=$addresses->province;
                $order->city=$addresses->city;
                $order->town=$addresses->town;
                $order->address=$addresses->address;
                $order->phone=$addresses->phone;
                $order->delivery_id=$request->post('delivery');
                $order->delivery_name=$delivery[$order->delivery_id];
                $order->delivery_price=$yun_fei[$order->delivery_id];
                $order->pay_id=$request->post('pay');
                $order->pay_name=$pay[$order->pay_id];
                $order->trade_no=date('ymdHis').rand(1000,9999);
                $order->price=$totalPrice+$order->delivery_price;
                $order->status=1;
                $order->create_time=time();
                $order->save();
//            echo "<pre>";
//            var_dump($goods);exit;
                //订单详情表入库
                foreach ($goods as $good){

                    ////取出当前商品库存
                    $stock=Goods::findOne($good['id'])->stock;
                    //判定当前购买的商品数量是否大于该商品的库存
                    if($good['num']>$stock){
                        throw new Exception('库存不足');
                    }


                    //实例化订单详情表对象
                    $order_detail=new OrderDatail();
                    $order_detail->order_id=$order->id;
                    $order_detail->goods_id=$good['id'];
                    $order_detail->goods_name=$good['name'];
                    $order_detail->logo=$good['logo'];
                    $order_detail->goods_price=$good['shop_price'];
                    $order_detail->goods_amount=$good['num'];
                    $order_detail->total_price=$good['num']*$good['shop_price'];

                    //保存成功后减去商品对应的库存
                    if($order_detail->save()){
                        //-少库存   Goods::updateAllCounters(['修改的字段'=>-数量],['id'=>商品Id]);
                        Goods::updateAllCounters(['stock'=>-$good['num']],['id'=>$good['id']]);
                        /*  $g= Goods::findOne($good['id']);
                         $g->stock=$g->stock-$good['num'];
                         $g->save();*/
                    }
//                echo '<pre>';
//                var_dump($good);exit;

                }
                //生成订单后清空购物车
                Cart::deleteAll(['user_id'=>$userId]);
                $transaction->commit();//提交事务
                $id=$order->id;

            } catch(Exception $e) {

                $transaction->rollBack();//回滚事物
                exit($e->getMessage());//错误信息

            }
            return $this->redirect(['order/finish','id'=>$id]);

        }

//        var_dump($allPrice);exit;
//            var_dump($goods);exit;
        return $this->render('index', compact('address', 'goods', 'yunFei', 'allPrice','totalPrice'));


    }


    public function actionFinish($id){

        return $this->render('finish',compact('id'));
    }


    public function actionPay($id){

        //找出订单
        $userId=\Yii::$app->user->id;
        $goodOrder=Order::findOne($id);
//        var_dump($goodOrder);exit;
        $options = \Yii::$app->params['easyWechat'];
        //实例化全局对象
        $app = new Application($options);
        //支付对象
        $payment = $app->payment;




        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...支付方式是扫码
            'body'             => '养猪城订单支付',//订单标题
            'detail'           => '各种商品',//订单详情
            'out_trade_no'     => $goodOrder->trade_no,//订单号
//            'total_fee'        => $goodOrder->price*100, // 单位：分，支付金额
            'total_fee'        => 1, // 单位：分，支付金额
            'notify_url'       => Url::to(['order/notify'],true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            //'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];

        $order = new \EasyWeChat\Payment\Order($attributes);
        //同意下单
        $result = $payment->prepare($order);
//        var_dump($result);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            //生成二维码
//            ,false,Enum::QR_ECLEVEL_H,6
            return QrCode::png($result->code_url,false,Enum::QR_ECLEVEL_H,6);

        }else{
                    var_dump($result);

        }
//       return $this->redirect(['order/no-pay']);

    }

//展示没有支付的页面
//    public function actionNoPay(){
//
//
//
////        var_dump($orderId);exit;
//        $this->render('no-pay');
//    }

    public function actionNotify(){

        $options = \Yii::$app->params['easyWechat'];
        //实例化全局对象
        $app = new Application($options);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
//            $order = ($notify->out_trade_no);
            $order=Order::findOne(['trade_no'=>$notify->out_trade_no]);
            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status!=1) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态

                $order->status = 2;
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });

        return $response;

    }


}
