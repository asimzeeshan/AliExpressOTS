<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "courier".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
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
     * Relationship with Shipments
     */
    public function getShipments()
    {
        return $this->hasMany(Shipment::className(), ['courier_id' => 'id']);
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
            [['name', 'created_at', 'modified_at'], 'required'],
            [['created_at', 'modified_at'], 'safe'],
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
            'url' => 'Url',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }
}
