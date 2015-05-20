<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 1.0
*/

namespace cinghie\articles\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use cinghie\articles\models\Items;

class ItemsSearch extends Items
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'catid', 'userid', 'published', 'access', 'ordering', 'hits', 'created_by', 'modified_by'], 'integer'],
            [['title', 'alias', 'introtext', 'fulltext', 'language', 'image', 'image_caption', 'image_credits', 'video', 'video_type', 'video_caption', 'video_credits', 'created', 'modified', 'params', 'metadesc', 'metakey', 'robots', 'author', 'copyright'], 'safe'],
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
        $query = Items::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'catid' => $this->catid,
            'userid' => $this->userid,
            'published' => $this->published,
            'access' => $this->access,
            'ordering' => $this->ordering,
            'hits' => $this->hits,
            'created' => $this->created,
            'created_by' => $this->created_by,
            'modified' => $this->modified,
            'modified_by' => $this->modified_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
              ->andFilterWhere(['like', 'alias', $this->alias])
              ->andFilterWhere(['like', 'introtext', $this->introtext])
              ->andFilterWhere(['like', 'fulltext', $this->fulltext])
              ->andFilterWhere(['like', 'language', $this->language])
              ->andFilterWhere(['like', 'image', $this->image])
              ->andFilterWhere(['like', 'image_caption', $this->image_caption])
              ->andFilterWhere(['like', 'image_credits', $this->image_credits])
              ->andFilterWhere(['like', 'video', $this->video])
			  ->andFilterWhere(['like', 'video_type', $this->video_type])
              ->andFilterWhere(['like', 'video_caption', $this->video_caption])
              ->andFilterWhere(['like', 'video_credits', $this->video_credits])
              ->andFilterWhere(['like', 'params', $this->params])
              ->andFilterWhere(['like', 'metadesc', $this->metadesc])
              ->andFilterWhere(['like', 'metakey', $this->metakey])
              ->andFilterWhere(['like', 'robots', $this->robots])
              ->andFilterWhere(['like', 'author', $this->author])
              ->andFilterWhere(['like', 'copyright', $this->copyright]);

        return $dataProvider;
    }
}
