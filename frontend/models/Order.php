<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $town
 * @property string $address
 * @property string $phone
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property string $delivery_orice
 * @property integer $pay_id
 * @property integer $pay_name
 * @property string $trade_no
 * @property string $price
 * @property integer $status
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'name' => '收货人',
            'province' => '省份',
            'city' => '区',
            'town' => '城镇',
            'address' => '详细地址',
            'phone' => '联系电话',
            'delivery_id' => '运送方式ID',
            'delivery_name' => '运送方式名字',
            'delivery_orice' => '运费',
            'pay_id' => '运送方式ID',
            'pay_name' => '运送方式名字',
            'trade_no' => '订单编号',
            'price' => '总金额',
            'status' => '订单状态，0表示取消，1表示待付款，2表示待发送，3表示待收货4表示已完成',
            'create_time' => '订单生成时间',
        ];
    }
}
