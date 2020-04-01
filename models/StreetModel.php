<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "street".
 *
 * @property string $name
 * @property string $ref
 * @property string $city_ref
 */
class StreetModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'street';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'ref', 'city_ref'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['ref', 'city_ref'], 'string', 'max' => 50],
            [['ref'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'ref' => 'Ref',
            'city_ref' => 'City Ref',
        ];
    }
}
