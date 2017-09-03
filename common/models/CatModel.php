<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "cats".
 *
 * @property integer $id
 * @property string $cat_name
 */
class CatModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'cat_name' => Yii::t('common', 'Cat Name'),
        ];
    }
    
    public static function getAllcats(){
    	
    	$res = self::find()->asArray()->all();

    	if($res){
    		foreach ($res as $value){
    			$cat[$value['id']]=$value['cat_name'];
    		}
    	}
    	return $cat;
    }
}
