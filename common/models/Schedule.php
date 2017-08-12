<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $id
 * @property integer $field_id
 * @property integer $user_id
 * @property string $date
 * @property string $time_range
 * @property string $tracking_code
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
            [['field_id', 'user_id', 'date', 'time_range', 'tracking_code'], 'required'],
            [['field_id', 'user_id'], 'integer'],
            [['date'], 'safe'],
            [['time_range'], 'string'],
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
            'user_id' => 'User ID',
            'date' => 'Date',
            'time_range' => 'Time Range',
            'tracking_code' => 'Tracking Code',
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
