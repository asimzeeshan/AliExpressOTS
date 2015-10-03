<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property string $price
 * @property string $order_date
 * @property string $description
 * @property string $delivery_date
 * @property integer $arrived_in
 * @property string $paid_with
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'order_date', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['order_date', 'delivery_date', 'created_at', 'updated_at'], 'safe'],
            [['arrived_in', 'created_by', 'updated_by'], 'integer'],
            [['price'], 'string', 'max' => 6],
            [['description'], 'string', 'max' => 48],
            [['paid_with'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'order_date' => 'Order Date',
            'description' => 'Description',
            'delivery_date' => 'Delivery Date',
            'arrived_in' => 'Arrived In',
            'paid_with' => 'Paid With',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
}
