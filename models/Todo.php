<?php

namespace app\models;

use yii\db\ActiveRecord;

class Todo extends ActiveRecord
{
    public static function tableName()
    {
        return 'todo';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => 0],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => 'Title',
            'description' => 'Description',
            'status'      => 'Status',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }

    public function getStatusLabel()
    {
        $statuses = [
            0 => 'Pending',
            1 => 'Completed',
        ];
        return $statuses[$this->status] ?? 'Unknown';
    }
}