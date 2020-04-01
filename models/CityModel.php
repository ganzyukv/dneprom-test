<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property string $name
 * @property string $ref
 */
class CityModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'ref'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['ref'], 'string', 'max' => 50],
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
        ];
    }
}
