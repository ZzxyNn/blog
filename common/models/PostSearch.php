<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PostModel;

/**
 * PostSearch represents the model behind the search form about `common\models\PostModel`.
 */
class PostSearch extends PostModel
{
	
	public $cat_name;//添加关联字段的属性
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_id', 'user_id', 'is_valid'], 'integer'],
            [['title', 'summary', 'content', 'label_img', 'user_name','cat_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PostModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'pagination'=>['pageSize'=>'6'],
        ]);
        
        $dataProvider->sort->defaultOrder = [
        		'is_valid' => SORT_ASC,
        		'id' => SORT_DESC,
        ];
        
        //添加新字段的排序规则
        $dataProvider->sort->attributes['cat_name']=
        [
        	'asc'=>['cats.cat_name'=>SORT_ASC],
        	'desc'=>['cats.cat_name'=>SORT_DESC],
        ];
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'posts.id' => $this->id,
            'cat_id' => $this->cat_id,
            'user_id' => $this->user_id,
            'is_valid' => $this->is_valid,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'label_img', $this->label_img])
            ->andFilterWhere(['like', 'user_name', $this->user_name]);
            
        //添加新字段的关联查询
        $query->join('INNER JOIN','cats','posts.cat_id = cats.id');
        
        //添加新字段的搜索规则
        $query->andFilterWhere(['like','cats.cat_name',$this->cat_name]);
                                        //↑关联表写原表名拼接sql语句
        return $dataProvider;
    }
}
