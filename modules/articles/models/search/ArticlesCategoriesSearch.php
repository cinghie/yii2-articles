<?php

namespace app\modules\articles\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\articles\models\ArticlesCategories;

/**
 * ArticlesCategoriesSearch represents the model behind the search form about `app\modules\articles\models\ArticlesCategories`.
 */
class ArticlesCategoriesSearch extends ArticlesCategories
{
    public function rules()
    {
        return [
            [['id', 'parent', 'published', 'access', 'ordering'], 'integer'],
            [['name', 'alias', 'description', 'image', 'params', 'metadesc', 'metakey', 'language'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ArticlesCategories::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent' => $this->parent,
            'published' => $this->published,
            'access' => $this->access,
            'ordering' => $this->ordering,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'params', $this->params])
            ->andFilterWhere(['like', 'metadesc', $this->metadesc])
            ->andFilterWhere(['like', 'metakey', $this->metakey])
            ->andFilterWhere(['like', 'language', $this->language]);

        return $dataProvider;
    }
}
