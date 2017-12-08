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

class ItemsSearch extends Items
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'state', 'access', 'ordering', 'hits'], 'integer'],
            [['title', 'alias', 'cat_id', 'created_by', 'modified_by', 'introtext', 'fulltext', 'language', 'image', 'image_caption', 'image_credits', 'video', 'video_type', 'video_caption', 'video_credits', 'created', 'modified', 'params', 'metadesc', 'metakey', 'robots', 'author', 'copyright'], 'safe'],
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
	 * @throws ForbiddenHttpException
	 * @throws InvalidParamException
	 */
    public function search($params)
    {
        if(Yii::$app->user->can('articles-index-all-items')) {
            $query = Items::find();
        } elseif(Yii::$app->user->can('articles-index-his-items')) {
            $query = Items::find()->where(['created_by' => Yii::$app->user->identity->id]);
        } else {
            throw new ForbiddenHttpException;
        }

        $query->joinWith('category');
        $query->joinWith('createdBy');
        $query->joinWith('modifiedBy');
        $query->joinWith('user');

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
            'user_id' => $this->user_id,
            'state' => $this->state,
            'access' => $this->access,
            'ordering' => $this->ordering,
            'hits' => $this->hits,
            'created' => $this->created,
            'modified' => $this->modified,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
              ->andFilterWhere(['like', 'alias', $this->alias])
              ->andFilterWhere(['like', 'category.name', $this->cat_id])
              ->andFilterWhere(['like', 'createdBy.username', $this->created_by])
              ->andFilterWhere(['like', 'modifiedBy.username', $this->modified_by])
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

	/**
	 * Creates data provider instance with last items
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
			$query = Items::find()->limit($limit);
		} elseif(Yii::$app->user->can('articles-index-his-items')) {
			$query = Items::find()->where(['created_by' => Yii::$app->user->identity->id])->limit($limit);
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
