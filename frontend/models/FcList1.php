<?php

namespace frontend\models;

use Yii;
use backend\models\City;
Use backend\models\District;

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
class FcList1 extends \yii\db\ActiveRecord
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
            [['fc_name','description', 'kickoff', 'district_id', 'phone', 'rented', 'field_type'],'required','message' => 'Thông tin bắt buộc'],
            [['description', 'photo', 'rented'], 'string'],
            [['kickoff'], 'safe'],
            [['fc_name'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            ['phone', 'match', 'pattern' => '/^((0|\+84)1[2689]|(0|\+84)9)[0-9]{8}$/','message' => 'Dữ liệu không hợp lệ'],
            ['district_id', 'integer'],
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
