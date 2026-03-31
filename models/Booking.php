<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "bookings".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $date
 * @property string $time
 * @property int $people
 * @property string|null $message
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 */
class Booking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bookings';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'pending'],
            [['name', 'email', 'phone', 'date', 'time', 'people'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['time'], 'match', 'pattern' => '/^\d{2}:\d{2}(:\d{2})?$/', 'message' => 'Time must be in HH:MM or HH:MM:SS format.'],
            [['people'], 'integer', 'min' => 1],
            [['message'], 'string'],
            [['email'], 'email'],
            [['status'], 'in', 'range' => ['pending', 'confirmed', 'cancelled']],
            [['name', 'email', 'phone', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * Normalize user input before validation/saving.
     */
    public function beforeValidate()
    {
        if (is_string($this->time) && preg_match('/^\d{2}:\d{2}$/', $this->time) === 1) {
            $this->time .= ':00';
        }

        return parent::beforeValidate();
    }

    /**
     * Normalize database values before insert/update.
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'date' => 'Date',
            'time' => 'Time',
            'people' => 'People',
            'message' => 'Message',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
