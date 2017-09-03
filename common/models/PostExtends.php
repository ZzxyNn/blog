<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "post_extends".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $browser
 * @property integer $collect
 * @property integer $praise
 * @property integer $comment
 */
class PostExtends extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_extends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'browser', 'collect', 'praise', 'comment'], 'integer'],
        ];
    }
    
    /**
     * 更新文章点击统计
     * @param unknown $condition
     * @param unknown $attibute
     * @param unknown $num
     */
    public function upCount($condition,$attribute,$num){
    	//通过文章id查找文章附属列表里数据
    	$counter = $this->findOne($condition);
    	
    	//如果没有对应的数据则新建一条
    	if(!$counter){
    		//设置post_id = 文章id
    		$this->setAttributes ( $condition );
			
			$this->$attribute = $num; // 等同于 → $this->browser = 1;
			
			$this->save();
    	}else{
    		$countData[$attribute] = $num;//Array ( [browser] => 1 )
    		
    		//更新计数器  对应以上数组里的字段叠加一个数量（FE：原本字段值为15，调用一次就为16）
    		$counter->updateCounters($countData);
    	}
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'post_id' => Yii::t('common', 'Post ID'),
            'browser' => Yii::t('common', 'Browser'),
            'collect' => Yii::t('common', 'Collect'),
            'praise' => Yii::t('common', 'Praise'),
            'comment' => Yii::t('common', 'Comment'),
        ];
    }
}
