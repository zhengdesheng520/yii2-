<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $good_category_id
 * @property integer $brand_id
 * @property integer $status
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
public $imgFiles;
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [ActiveRecord::EVENT_BEFORE_INSERT=>['inputtime']]

                ]

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'logo', 'good_category_id', 'brand_id', 'status', 'market_price', 'shop_price', 'stock'], 'required'],
            [['good_category_id', 'brand_id', 'status', 'stock', 'sort'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
//            [['logo'],'image','extensions' => 'jpg,gif,png'],
            [['sn','imgFiles'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'name' => '商品名称',
            'sn' => '商品货号',
            'logo' => '商品图片',
            'good_category_id' => '商品分类',
            'brand_id' => '所属品牌',
            'status' => '是否上架',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '商品库存',
            'sort' => '排序',
            'imgFiles'=>'商品图片（多图）'

        ];
    }

    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);

    }
    public function getCates(){
        return $this->hasOne(Category::className(),['id'=>'good_category_id']);
    }


}
