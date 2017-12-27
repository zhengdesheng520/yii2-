<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m171226_060506_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull()->comment('深度'),
            'name' => $this->string()->notNull()->comment('分类名称'),
            'parent_id'=>$this->integer()->notNull()->comment('父类ID'),
            'intro'=>$this->string()->comment('简介')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
