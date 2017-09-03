<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $label_img
 * @property integer $cat_id
 * @property integer $user_id
 * @property string $user_name
 * @property integer $is_valid
 * @property integer $created_at
 * @property integer $updated_at
 */
class PostModel extends BaseModel
{
	const IS_VALID = 1;  //发布
	const NO_VALID = 0;  //未发布
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['cat_id', 'user_id', 'is_valid', 'created_at', 'updated_at'], 'integer'],
            [['title', 'summary', 'label_img', 'user_name'], 'string', 'max' => 255],
        ];
    }
    
    public function getRelate(){
    	// 						↓ 参数表				       ↓ 第一个字段对应参数表
    	return $this->hasMany(PostTagModel::className(), ['post_id'=>'id']);
    	//                                                            ↑ 第二个字段对应该类表
    }
    
    public function getExtend(){
    	return $this->hasOne(PostExtends::className(), ['post_id'=>'id']);
    }
    
    public function getCat(){
    	return $this->hasOne(CatModel::className(), ['id'=>'cat_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
		return [ 
			'id' => Yii::t ( 'common', 'ID' ),
			'title' => Yii::t ( 'common', 'Title' ),
			'summary' => Yii::t ( 'common', 'Summary' ),
			'content' => Yii::t ( 'common', 'Content' ),
			'label_img' => Yii::t ( 'common', 'Label_Img' ),
			'cat_name' => Yii::t ( 'common', 'Cat Name' ),
			'user_id' => Yii::t ( 'common', 'User ID' ),
			'user_name' => Yii::t ( 'common', 'User Name' ),
			'is_valid' => Yii::t ( 'common', 'Is Valid' ),
			'created_at' => Yii::t ( 'common', 'Created_at' ),
			'updated_at' => Yii::t ( 'common', 'Updated_at' ) 
		];
	}
	
	/**
	 * 审核文章状态
	 */
	public function approve(){
		if($this->is_valid == 0){
			$this->is_valid = 1;
			return ($this->save()) ? true : false;
		}
	}
	
	
	public function beforeSave($insert){
		if(parent::beforeSave($insert)){
			if($insert){
				$this->updated_at = time();
				$this->created_at = time();
			}
			else{
				$this->updated_at = time();
			}
			return true;
		}
	}
}
