<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "package".
 *
 * @property string $id
 * @property integer $order_id
 * @property string $price
 * @property string $order_date
 * @property string $description
 * @property integer $courier_id
 * @property string $tracking_id
 * @property string $shipment_date
 * @property string $delivery_date
 * @property integer $arrived_in
 * @property string $paid_with
 * @property integer $is_disputed
 * @property string $refund_status
 * @property string $notes
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * Relationship with PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->hasOne(PaymentMethod::className(), ['id' => 'paid_with']);
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

    public function getDaysElapsed($date) {
        $now = time(); // or your date as well
        $your_date = strtotime($date);
        $datediff = $now - $your_date;
        $days_elapsed = floor($datediff/(60*60*24));

        return $days_elapsed." days";//.$date.")";
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
            [['order_id', 'price', 'order_date', 'description', 'paid_with'], 'required'],
            [['order_id', 'courier_id', 'arrived_in', 'is_disputed'], 'integer'],
            [['order_date', 'shipment_date', 'delivery_date'], 'safe'],
            [['notes'], 'string'],
            [['price'], 'string', 'max' => 6],
            [['description'], 'string', 'max' => 48],
            [['tracking_id'], 'string', 'max' => 30],
            [['paid_with'], 'string', 'max' => 5],
            [['refund_status'], 'string', 'max' => 20],
            [['order_id'], 'unique']
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
            'price' => 'Price',
            'order_date' => 'Order Date',
            'description' => 'Description',
            'courier_id' => 'Courier',
            'tracking_id' => 'Tracking ID',
            'shipment_date' => 'Shipment Date',
            'delivery_date' => 'Delivery Date',
            'arrived_in' => 'Arrived In',
            'paid_with' => 'Paid With',
            'is_disputed' => 'Is Disputed',
            'refund_status' => 'Refund Status',
            'notes' => 'Notes',
            'created_by' => 'Created by',
            'created_at' => 'Created at',
            'updated_by' => 'Updated by',
            'updated_at' => 'Updated at',
        ];
    }
}
