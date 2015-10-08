<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property integer $id
 * @property integer $store_number
 * @property string $name
 * @property string $location
 * @property string $since
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_number', 'name', 'location', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['store_number', 'created_by', 'updated_by'], 'integer'],
            [['since', 'created_at', 'updated_at'], 'safe'],
            [['name', 'location'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_number' => 'Store Number',
            'name' => 'Name',
            'location' => 'Location',
            'since' => 'Since',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
}
