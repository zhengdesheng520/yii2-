<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m171228_101148_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('商品名称'),
            'sn'=>$this->char(20)->notNull()->comment('商品货号'),
            'logo'=>$this->string()->notNull()->comment('商品图片'),
            'good_category_id'=>$this->integer()->notNull()->comment('商品分类'),
            'brand_id'=>$this->integer()->notNull()->comment('所属品牌'),
            'status'=>$this->integer()->notNull()->comment('是否上架'),
            'market_price'=>$this->decimal()->notNull()->comment('市场价格'),
            'shop_price'=>$this->decimal()->notNull()->comment('本店价格'),
            'stock'=>$this->integer()->notNull()->comment('商品库存'),
            'sort'=>$this->integer()->comment('排序'),
            'inputtime'=>$this->integer()->comment('上架时间')

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
