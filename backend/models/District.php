<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property integer $id
 * @property string $name
 * @property integer $city_id
 *
 * @property City $city
 * @property FcList[] $fcLists
 * @property Stadiums[] $stadiums
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'city_id'], 'required','message' => 'Bắt buộc Nhập dữ liệu'],
            [['city_id'], 'integer'],
            [['name'],'string', 'max' => 30,],
            ['name','unique','targetAttribute' => ['name', 'city_id'],'message' => 'Khu vực đã tồn tại'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên Quận, Huyện',
            'city_id' => 'Thành Phố',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFcLists()
    {
        return $this->hasMany(FcList::className(), ['district_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStadiums()
    {
        return $this->hasMany(Stadiums::className(), ['district_id' => 'id']);
    }

    public function getModel($id) {
        $data = District::find(['city_id'=>$id])->all();
        return $data;
    }

    public function getCount() {
        $data = District::find()->count();
        return $data;
    }
}
