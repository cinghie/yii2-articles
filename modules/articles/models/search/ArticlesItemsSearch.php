<?php

namespace app\modules\articles\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\articles\models\ArticlesItems;

/**
 * ArticlesItemsSearch represents the model behind the search form about `app\modules\articles\models\ArticlesItems`.
 */
class ArticlesItemsSearch extends ArticlesItems
{
    public function rules()
    {
        return [
            [['id', 'catid', 'published', 'created_by', 'modified_by', 'access', 'ordering', 'hits'], 'integer'],
            [['title', 'alias', 'introtext', 'fulltext', 'created', 'modified', 'params', 'metadesc', 'metakey', 'language'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ArticlesItems::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'catid' => $this->catid,
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
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'introtext', $this->introtext])
            ->andFilterWhere(['like', 'fulltext', $this->fulltext])
            ->andFilterWhere(['like', 'params', $this->params])
            ->andFilterWhere(['like', 'metadesc', $this->metadesc])
            ->andFilterWhere(['like', 'metakey', $this->metakey])
            ->andFilterWhere(['like', 'language', $this->language]);

        return $dataProvider;
    }
}
