<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pricing".
 *
 * @property integer $id
 * @property integer $mon
 * @property integer $tue
 * @property integer $wed
 * @property integer $thu
 * @property integer $fri
 * @property integer $sat
 * @property integer $sun
 * @property string $field_type
 * @property string $time_range
 * @property integer $field_id
 *
 * @property Stadiums $field
 */
class Pricing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pricing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun', 'field_id'], 'integer'],
            [['field_type', 'time_range', 'field_id'], 'required'],
            [['field_type', 'time_range'], 'string'],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stadiums::className(), 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mon' => 'Mon',
            'tue' => 'Tue',
            'wed' => 'Wed',
            'thu' => 'Thu',
            'fri' => 'Fri',
            'sat' => 'Sat',
            'sun' => 'Sun',
            'field_type' => 'Field Type',
            'time_range' => 'Time Range',
            'field_id' => 'Field ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Stadiums::className(), ['id' => 'field_id']);
    }
}
