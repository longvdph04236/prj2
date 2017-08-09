<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "field".
 *
 * @property integer $id
 * @property integer $field_id
 * @property string $field_type
 * @property string $name
 *
 * @property Stadiums $field
 * @property Pricing[] $pricings
 * @property Schedule[] $schedules
 */
class Field extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_id', 'field_type', 'name'], 'required'],
            [['field_id'], 'integer'],
            [['field_type'], 'string'],
            [['name'], 'string', 'max' => 10],
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
            'field_id' => 'Field ID',
            'field_type' => 'Field Type',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Stadiums::className(), ['id' => 'field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricings()
    {
        return $this->hasMany(Pricing::className(), ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['field_id' => 'id']);
    }
}
