<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $town
 * @property string $address
 * @property integer $user_id
 * @property string $phone
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['name', 'province', 'city', 'town', 'address','phone'], 'required'],
            [['status'],'safe']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '收货人',
            'province' => '所在省份',
            'city' => '所在市区',
            'town' => '所在城镇',
            'address' => '详细地址',
            'user_id' => '所属用户',
            'phone' => '联系电话',
        ];
    }
}
