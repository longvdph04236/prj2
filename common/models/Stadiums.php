<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stadiums".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $description
 * @property integer $rate
 * @property integer $count_rate
 * @property string $photos
 * @property integer $manager_id
 * @property string $google_map
 * @property integer $district_id
 *
 * @property Comments[] $comments
 * @property FcList[] $fcLists
 * @property Field[] $fields
 * @property Users $manager
 * @property District $district
 */
class Stadiums extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stadiums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'phone', 'photos', 'manager_id', 'district_id'], 'required'],
            [['address', 'description', 'photos'], 'string'],
            [['rate', 'count_rate', 'manager_id', 'district_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['google_map'], 'string', 'max' => 100],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['manager_id' => 'id']],
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
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'description' => 'Description',
            'rate' => 'Rate',
            'count_rate' => 'Count Rate',
            'photos' => 'Photos',
            'manager_id' => 'Manager ID',
            'google_map' => 'Google Map',
            'district_id' => 'District ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFcLists()
    {
        return $this->hasMany(FcList::className(), ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFields()
    {
        return $this->hasMany(Field::className(), ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }
}
