<?php

namespace app\models;

use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "shipment".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $courier_id
 * @property string $shipment_date
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
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'order_id']);
    }

    public function getCourier()
    {
        return $this->hasOne(Courier::className(), ['id' => 'courier_id']);
    }

    public function getPackagesData() {
        return $this->id.' - $'.$this->price.' - '.$this->description;
    }

    public function shippingDate($order_id) {
        $check = Shipment::find()->where( [ 'order_id' => $order_id ] )->exists();

        if ($check==1) {
            $data = Shipment::findOne($order_id);
            if (!empty($data)) {
                $data = $data->toArray();
            }
            return $data['shipment_date'];

        } else {
            return false;
        }
    }

    public function isShipped($order_id) {
        $check = Shipment::find()->where( [ 'order_id' => $order_id ] )->exists();

        if ($check==1) {
            return true;
        } else {
            return false;
        }
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
            [['order_id', 'courier_id', 'shipment_date', 'tracking_id'], 'required'],
            [['order_id', 'courier_id'], 'integer'],
            [['shipment_date'], 'safe'],
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
            'shipment_date' => 'Shipment Date',
            'tracking_id' => 'Tracking ID',
            'created_by' => 'Created by',
            'created_at' => 'Created at',
            'updated_by' => 'Updated by',
            'updated_at' => 'Updated at',
        ];
    }
}
