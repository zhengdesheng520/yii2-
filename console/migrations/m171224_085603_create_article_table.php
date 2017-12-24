<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171224_085603_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment("名称"),
            'article_category_id'=>$this->smallInteger()->comment("分类"),
            'intro'=>$this->text()->comment("介绍"),
            'status'=>$this->smallInteger()->defaultValue('1')->comment("0=是，1=否"),
            'sort'=>$this->smallInteger()->defaultValue('20')->comment("排序"),
            'createtime'=>$this->smallInteger()->comment("添加时间")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
