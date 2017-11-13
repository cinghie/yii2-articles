<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.4
*/

namespace cinghie\articles\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AttachmentsSearch represents the model behind the search form about `cinghie\articles\models\Attachments`.
 */
class AttachmentsSearch extends Attachments
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hits', 'size'], 'integer'],
            [['item_id', 'extension', 'filename', 'mimetype', 'title', 'titleAttribute'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Attachments::find();
        $query->joinWith('item');

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'hits' => $this->hits,
            'size' => $this->size,
        ]);

        $query->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'item.title', $this->item_id])
            ->andFilterWhere(['like', 'extension', $this->extension])
            ->andFilterWhere(['like', 'mimetype', $this->mimetype])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'titleAttribute', $this->titleAttribute]);

        return $dataProvider;
    }

}
