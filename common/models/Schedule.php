<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $id
 * @property integer $field_id

 * @property string $field_type
 * @property integer $user_id
 * @property string $name
 * @property string $date
 * @property string $time_range
 * @property string $tracking_code
 * @property string $create_at
 * @property string $status
 *
 * @property Field $field
 * @property Users $user
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['field_id', 'user_id'], 'integer'],
            [['field_type', 'date', 'time_range'], 'required'],
            [['field_type', 'time_range', 'status'], 'string'],
            [['date', 'create_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['tracking_code'], 'string', 'max' => 10],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['field_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_id' => 'Field ID',

            'field_type' => 'Field Type',
            'user_id' => 'User ID',
            'name' => 'Name',
            'date' => 'Date',
            'time_range' => 'Time Range',
            'tracking_code' => 'Tracking Code',
            'create_at' => 'Create At',
            'status' => 'Status',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
