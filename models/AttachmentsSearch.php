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
use cinghie\articles\models\Attachments;

/**
 * AttachmentsSearch represents the model behind the search form about `app\models\Attachments`.
 */
class AttachmentsSearch extends Attachments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'itemid', 'hits'], 'integer'],
            [['filename', 'title', 'titleAttribute'], 'safe'],
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
        $query = Attachments::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'itemid' => $this->itemid,
            'hits' => $this->hits,
        ]);

        $query->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'titleAttribute', $this->titleAttribute]);

        return $dataProvider;
    }
}
