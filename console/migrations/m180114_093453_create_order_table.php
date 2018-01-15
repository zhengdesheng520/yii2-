<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180114_093453_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->comment('用户ID'),
            'name'=>$this->string()->comment('收货人'),
            'province'=>$this->string()->comment('省份'),
            'city'=>$this->string()->comment('区'),
            'town'=>$this->string()->comment('城镇'),
            'address'=>$this->string()->comment('详细地址'),
            'phone'=>$this->string()->comment('联系电话'),
            'delivery_id'=>$this->integer()->comment('运送方式ID'),
            'delivery_name'=>$this->string()->comment('运送方式名字'),
            'delivery_orice'=>$this->decimal(10,2)->comment('运费'),
            'pay_id'=>$this->integer()->comment('运送方式ID'),
            'pay_name'=>$this->integer()->comment('运送方式名字'),
            'trade_no'=>$this->string()->comment('订单编号'),
            'price'=>$this->decimal(10,2)->comment('总金额'),
            'status'=>$this->integer()->comment('订单状态，0表示取消，1表示待付款，2表示待发送，3表示待收货4表示已完成'),
            'create_time'=>$this->integer()->comment('订单生成时间')
        ]);
        $this->createTable('order_datail', [
            'id' => $this->primaryKey(),
            'order_id'=>$this->integer()->comment('订单ID'),
            'goods_id'=>$this->integer()->comment('商品ID'),
            'goods_name'=>$this->string()->comment('商品名称'),
            'logo'=>$this->string()->comment('商品图片'),
            'goods_price'=>$this->decimal(10,2)->comment('商品价格'),
            'goods_amount'=>$this->integer()->comment('购买数量'),
            'total_price'=>$this->decimal(10,2)->comment('小计')

        ]);


    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
