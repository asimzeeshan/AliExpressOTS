<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "courier".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $max_delivery_days
 * @property string $min_delivery_days
 * @property string $avg_delivery_days
 * @property string $created_at
 * @property string $modified_at
 */
class Courier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courier';
    }

    /**
     * Relationship with User
     */
    public function getCreatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Relationship with User
     */
    public function getUpdatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * TimestampBehavior & BlameableBehavior to update created_* and updated_* fields
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['max_delivery_days', 'min_delivery_days', 'avg_delivery_days'], 'number'],
            [['name'], 'string', 'max' => 75],
            [['url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'URL',
            'max_delivery_days' => 'MAX Delivery Days',
            'min_delivery_days' => 'MIN Delivery Days',
            'avg_delivery_days' => 'AVG Delivery Days',
            'created_by' => 'Created by',
            'created_at' => 'Created at',
            'updated_by' => 'Updated by',
            'updated_at' => 'Updated at',
        ];
    }
}
