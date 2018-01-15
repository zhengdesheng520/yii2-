<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_datail".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $goods_id
 * @property string $goods_name
 * @property string $logo
 * @property string $goods_price
 * @property integer $goods_amount
 * @property string $total_price
 */
class OrderDatail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_datail';
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
            'order_id' => '订单ID',
            'goods_id' => '商品ID',
            'goods_name' => '商品名称',
            'logo' => '商品图片',
            'goods_price' => '商品价格',
            'goods_amount' => '购买数量',
            'total_price' => '小计',
        ];
    }
}
