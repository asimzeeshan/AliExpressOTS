<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shipment".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $courier_id
 * @property integer $tracking_id
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'courier_id', 'tracking_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['order_id', 'courier_id', 'tracking_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
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
            'courier_id' => 'Courier ID',
            'tracking_id' => 'Tracking ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
}