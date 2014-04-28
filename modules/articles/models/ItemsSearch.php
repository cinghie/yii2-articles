<?php

namespace app\modules\articles\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\articles\models\Items;

/**
 * ItemsSearch represents the model behind the search form about `app\modules\articles\models\Items`.
 */
class ItemsSearch extends Items
{
    public function rules()
    {
        return [
            [['id', 'catid', 'userid', 'published', 'created_by', 'modified_by', 'access', 'ordering', 'hits'], 'integer'],
            [['title', 'introtext', 'fulltext', 'image', 'image_caption', 'image_credits', 'video', 'video_caption', 'video_credits', 'created', 'modified', 'alias', 'metadesc', 'metakey', 'robots', 'author', 'copyright', 'params', 'language'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Items::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'catid' => $this->catid,
            'userid' => $this->userid,
            'published' => $this->published,
            'created' => $this->created,
            'created_by' => $this->created_by,
            'modified' => $this->modified,
            'modified_by' => $this->modified_by,
            'access' => $this->access,
            'ordering' => $this->ordering,
            'hits' => $this->hits,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'introtext', $this->introtext])
            ->andFilterWhere(['like', 'fulltext', $this->fulltext])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'image_caption', $this->image_caption])
            ->andFilterWhere(['like', 'image_credits', $this->image_credits])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'video_caption', $this->video_caption])
            ->andFilterWhere(['like', 'video_credits', $this->video_credits])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'metadesc', $this->metadesc])
            ->andFilterWhere(['like', 'metakey', $this->metakey])
            ->andFilterWhere(['like', 'robots', $this->robots])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'copyright', $this->copyright])
            ->andFilterWhere(['like', 'params', $this->params])
            ->andFilterWhere(['like', 'language', $this->language]);

        return $dataProvider;
    }
}
