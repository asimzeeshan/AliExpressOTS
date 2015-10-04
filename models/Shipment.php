<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "shipment".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $courier_id
 * @property string $tracking_id
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Shipment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shipment';
    }

    /**
     * Relationship with Order
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public function getCourier()
    {
        return $this->hasOne(Courier::className(), ['id' => 'courier_id']);
    }

    public function getOrderID()
    {
        return $this->package->ae_order_id;
    }

    public function getCourierName()
    {
        return $this->courier->name;
    }

    public function getOrdersData() {
        return $this->id.' - $'.$this->price.' - '.$this->description;
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
            [['order_id', 'courier_id', 'tracking_id'], 'required'],
            [['order_id', 'courier_id'], 'integer'],
            [['tracking_id'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'courier_id' => 'Courier',
            'tracking_id' => 'Tracking ID',
            'created_by' => 'Created by',
            'created_at' => 'Created at',
            'updated_by' => 'Updated by',
            'updated_at' => 'Updated at',
        ];
    }
}
