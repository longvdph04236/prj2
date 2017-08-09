<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 06/02/2017
 * Time: 3:41 CH
 */

namespace yii\widgets;

use yii\base\Widget;

class NameToLink extends Widget
{
    public static $name;

    public function run(){
        $name = mb_strtolower(self::$name, 'UTF-8');
        $list = array('á'=>'a', 'à'=>'a', 'ã'=>'a', 'ả'=>'a', 'ạ'=>'a',
                                'ắ'=>'a', 'ằ'=>'a', 'ẵ'=>'a', 'ẳ'=>'a', 'ặ'=>'a',
                                'ấ'=>'a', 'ầ'=>'a', 'ẫ'=>'a', 'ẩ'=>'a', 'ậ'=>'a',
                                'é'=>'e', 'è'=>'e', 'ẽ'=>'e', 'ẻ'=>'e', 'ẹ'=>'e',
                                'ế'=>'e', 'ề'=>'e', 'ễ'=>'e', 'ể'=>'e', 'ệ'=>'e',
                                'í'=>'i', 'ì'=>'i', 'ĩ'=>'i', 'ỉ'=>'i', 'ị'=>'i',
                                'ó'=>'o', 'ò'=>'o', 'õ'=>'o', 'ỏ'=>'o', 'ọ'=>'o',
                                'ố'=>'o', 'ồ'=>'o', 'ỗ'=>'o', 'ổ'=>'o', 'ộ'=>'o',
                                'ớ'=>'o', 'ờ'=>'o', 'ỡ'=>'o', 'ở'=>'o', 'ợ'=>'o',
                                'ú'=>'u', 'ù'=>'u', 'ũ'=>'u', 'ủ'=>'u', 'ụ'=>'u',
                                'ứ'=>'u', 'ừ'=>'u', 'ữ'=>'u', 'ử'=>'u', 'ự'=>'u',
                                'ý'=>'y', 'ỳ'=>'y', 'ỹ'=>'y', 'ỷ'=>'y', 'ỵ'=>'y',
                                'ă'=>'a', 'â'=>'a', 'ô'=>'o', 'ơ'=>'o', 'đ'=>'d',
                                'ê'=>'e', 'ư'=>'u');

        $linkstr = strtr( $name, $list );
        $linkstr = str_replace(' ','-',$linkstr);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $linkstr);

    }
}