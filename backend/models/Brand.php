<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $logo
 * @property integer $status
 * @property string $intro
 */
class Brand extends \yii\db\ActiveRecord
{
//    public $img;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['intro','logo','sort'],'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名称',
            'logo' => '品牌图标',
            'status' => '状态',
            'sort'=>'排序',
            'intro' => '品牌介绍',
        ];
    }
}
