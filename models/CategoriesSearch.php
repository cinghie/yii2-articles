<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.1
*/

namespace cinghie\articles\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use cinghie\articles\models\Categories;

/**
 * CategoriesSearch represents the model behind the search form about `cinghie\articles\models\Attachments`.
 */
class CategoriesSearch extends Categories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'state', 'access', 'ordering'], 'integer'],
            [['name', 'parentid', 'alias', 'description', 'image', 'image_caption', 'image_credits', 'params', 'metadesc', 'metakey', 'robots', 'author', 'copyright', 'language'], 'safe'],
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
        $query = Categories::find();

        $query->joinWith('parent');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'state' => $this->state,
            'access' => $this->access,
            'ordering' => $this->ordering,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'parent.name', $this->parentid])
              ->andFilterWhere(['like', 'alias', $this->alias])
              ->andFilterWhere(['like', 'description', $this->description])
              ->andFilterWhere(['like', 'image', $this->image])
              ->andFilterWhere(['like', 'image_caption', $this->image_caption])
              ->andFilterWhere(['like', 'image_credits', $this->image_credits])
              ->andFilterWhere(['like', 'params', $this->params])
              ->andFilterWhere(['like', 'metadesc', $this->metadesc])
              ->andFilterWhere(['like', 'metakey', $this->metakey])
              ->andFilterWhere(['like', 'robots', $this->robots])
              ->andFilterWhere(['like', 'author', $this->author])
              ->andFilterWhere(['like', 'copyright', $this->copyright])
              ->andFilterWhere(['like', 'language', $this->language]);

        return $dataProvider;
    }
}
