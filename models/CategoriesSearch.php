<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.5
*/

namespace cinghie\articles\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;

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
            [['id', 'state', 'ordering'], 'integer'],
            [['name', 'parent_id', 'alias', 'description', 'access', 'image', 'image_caption', 'image_credits', 'params', 'metadesc', 'metakey', 'robots', 'author', 'copyright', 'theme', 'language'], 'safe'],
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
	 * @throws InvalidParamException
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
            '{{%article_categories}}.id' => $this->id,
            '{{%article_categories}}.state' => $this->state,
            '{{%article_categories}}.ordering' => $this->ordering,
        ]);

        $query->andFilterWhere(['like', '{{%article_categories}}.name', $this->name])
              ->andFilterWhere(['like', 'parent.name', $this->parent_id])
              ->andFilterWhere(['like', '{{%article_categories}}.alias', $this->alias])
              ->andFilterWhere(['like', '{{%article_categories}}.description', $this->description])
              ->andFilterWhere(['like', '{{%article_categories}}.access', $this->access])
              ->andFilterWhere(['like', '{{%article_categories}}.image', $this->image])
              ->andFilterWhere(['like', '{{%article_categories}}.image_caption', $this->image_caption])
              ->andFilterWhere(['like', '{{%article_categories}}.image_credits', $this->image_credits])
              ->andFilterWhere(['like', '{{%article_categories}}.metadesc', $this->metadesc])
              ->andFilterWhere(['like', '{{%article_categories}}.metakey', $this->metakey])
              ->andFilterWhere(['like', '{{%article_categories}}.robots', $this->robots])
              ->andFilterWhere(['like', '{{%article_categories}}.author', $this->author])
              ->andFilterWhere(['like', '{{%article_categories}}.copyright', $this->copyright])
              ->andFilterWhere(['like', '{{%article_categories}}.theme', $this->theme])
              ->andFilterWhere(['like', '{{%article_categories}}.language', $this->language]);

        return $dataProvider;
    }

	/**
	 * Creates data provider instance with last categories
	 *
	 * @param int $limit
	 * @param string $orderby
	 * @param int $order
	 *
	 * @return ActiveDataProvider
	 * @throws ForbiddenHttpException
	 * @throws InvalidParamException
	 */
	public function last($limit, $orderby = 'id', $order = SORT_DESC)
	{
		if(Yii::$app->user->can('articles-index-all-items')) {
			$query = Categories::find()->limit($limit);
		} else {
			throw new ForbiddenHttpException;
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => $limit,
			],
			'sort' => [
				'defaultOrder' => [
					$orderby => $order
				],
			],
			'totalCount' => $limit
		]);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		return $dataProvider;
	}

}
