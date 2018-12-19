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
 * ItemsSearch represents the model behind the search form about `cinghie\articles\models\Items`.
 */
class ItemsSearch extends Items
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_id', 'user_id', 'state', 'ordering', 'hits'], 'integer'],
            [['title', 'alias', 'access', 'created_by', 'modified_by', 'introtext', 'fulltext', 'language', 'image', 'image_caption', 'image_credits', 'video', 'video_type', 'video_caption', 'video_credits', 'created', 'modified', 'params', 'metadesc', 'metakey', 'robots', 'author', 'copyright'], 'safe'],
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

        if(!$this->language) {
	        $this->language = 'all';
        }

	    if(isset($this->cat_id) && $this->cat_id !== '')
	    {
		    if((int)$this->cat_id === 0) {
			    $query->andWhere(['is', '{{%article_items}}.cat_id', new \yii\db\Expression('NULL')]);
		    } else {
			    $query->andFilterWhere(['{{%article_items}}.cat_id' => $this->cat_id]);
		    }

	    } else {
		    $query->andFilterWhere(['{{%article_items}}.cat_id' => $this->cat_id]);
	    }

	    if(isset($this->image) && $this->image !== '')
	    {
		    if((int)$this->image === 1) {
			    $query->andWhere(['!=','{{%article_items}}.image','']);
		    } elseif((int)$this->image === 0) {
			    $query->andWhere(['=','{{%article_items}}.image', '']);
		    }
	    } else {
		    $query->andFilterWhere(['like', '{{%article_categories}}.image', $this->image]);
	    }

        $query->andFilterWhere([
            '{{%article_items}}.id' => $this->id,
            '{{%article_items}}.created_by' => $this->created_by,
            '{{%article_items}}.modified_by' => $this->modified_by,
            '{{%article_items}}.user_id' => $this->user_id,
            '{{%article_items}}.state' => $this->state,
            '{{%article_items}}.ordering' => $this->ordering,
            '{{%article_items}}.hits' => $this->hits
        ]);

        $query->andFilterWhere(['like', '{{%article_items}}.title', $this->title])
              ->andFilterWhere(['like', '{{%article_items}}.alias', $this->alias])
              ->andFilterWhere(['like', '{{%article_items}}.access', $this->access])
              ->andFilterWhere(['like', '{{%article_items}}.created', $this->created])
              ->andFilterWhere(['like', '{{%article_items}}.modified', $this->modified])
              ->andFilterWhere(['like', '{{%article_items}}.introtext', $this->introtext])
              ->andFilterWhere(['like', '{{%article_items}}.fulltext', $this->fulltext])
              ->andFilterWhere(['like', '{{%article_items}}.language', $this->language])
              ->andFilterWhere(['like', '{{%article_items}}.image_caption', $this->image_caption])
              ->andFilterWhere(['like', '{{%article_items}}.image_credits', $this->image_credits])
              ->andFilterWhere(['like', '{{%article_items}}.video', $this->video])
			  ->andFilterWhere(['like', '{{%article_items}}.video_type', $this->video_type])
              ->andFilterWhere(['like', '{{%article_items}}.video_caption', $this->video_caption])
              ->andFilterWhere(['like', '{{%article_items}}.video_credits', $this->video_credits])
              ->andFilterWhere(['like', '{{%article_items}}.params', $this->params])
              ->andFilterWhere(['like', '{{%article_items}}.metadesc', $this->metadesc])
              ->andFilterWhere(['like', '{{%article_items}}.metakey', $this->metakey])
              ->andFilterWhere(['like', '{{%article_items}}.robots', $this->robots])
              ->andFilterWhere(['like', '{{%article_items}}.author', $this->author])
              ->andFilterWhere(['like', '{{%article_items}}.copyright', $this->copyright]);

	    // Print SQL query
	    //var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

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
