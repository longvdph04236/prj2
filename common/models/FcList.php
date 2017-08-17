<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fc_list".
 *
 * @property integer $id
 * @property string $fc_name
 * @property string $description
 * @property string $kickoff
 * @property integer $district_id
 * @property string $phone
 * @property string $photo
 * @property string $rented
 * @property string $field_type
 *
 * @property District $district
 */
class FcList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fc_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fc_name', 'kickoff', 'district_id', 'phone', 'rented', 'field_type'], 'required'],
            [['description', 'photo', 'rented', 'field_type'], 'string'],
            [['kickoff'], 'safe'],
            [['district_id'], 'integer'],
            [['fc_name'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fc_name' => 'Fc Name',
            'description' => 'Description',
            'kickoff' => 'Kickoff',
            'district_id' => 'District ID',
            'phone' => 'Phone',
            'photo' => 'Photo',
            'rented' => 'Rented',
            'field_type' => 'Field Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }
}
