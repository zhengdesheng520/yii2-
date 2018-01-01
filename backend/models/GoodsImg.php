<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_img".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $path
 */
class GoodsImg extends \yii\db\ActiveRecord
{
    public $imgFiles;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['path','goods_id','imgFiles'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'goods_id' => '商品ID',
            'path' => '图片地址',
            'imgFiles'=>'商品多图'
        ];
    }
}
