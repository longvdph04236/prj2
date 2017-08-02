<?php

namespace backend\models;


/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 *
 * @property District[] $districts
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    private $city = [];

    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required','message' => 'Bặt buộc nhập dữ liệu'],
            [['name'], 'string', 'max' => 30],
            ['name','unique','message' => 'Tên Khu vực đã tồn tại']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên Thành Phố',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(District::className(), ['city_id' => 'id']);
    }

    public function getCount() {
        $data = City::find()->count();
        return $data;
    }

    public function getModel($id) {
        $data = City::findOne($id);
        return $data;
    }

    public function getParent() {
        $data = City::find()->all();

        foreach ($data as $key => $value) {
            $this->city[$value->id] = $value->name;
        }

        return $this->city;
    }
}
