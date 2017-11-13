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

use Yii;
use cinghie\traits\EditorTrait;
use cinghie\traits\NameAliasTrait;
use cinghie\traits\StateTrait;
use cinghie\traits\ViewsHelpersTrait;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%article_tags}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property integer $state
 * @property string $description
 */
class Tags extends Articles
{

    use EditorTrait, NameAliasTrait, StateTrait, ViewsHelpersTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(NameAliasTrait::rules(), StateTrait::rules(), [
            [['name'], 'required'],
            [['description'], 'string'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(NameAliasTrait::attributeLabels(), StateTrait::attributeLabels(),[
            'id' => Yii::t('articles', 'ID'),
            'description' => Yii::t('articles', 'Description'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagsassign()
    {
        return $this->hasMany(Tagsassign::className(), ['tag_id' => 'id']);
    }

    /**
     * return Tag url
     *
     * @return string
     */
    public function getTagUrl() {
        return Url::to(['/articles/tags/view', 'id' => $this->id, 'alias' => $this->alias]);
    }

    /**
     * @inheritdoc
     *
     * @return TagsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagsQuery(get_called_class());
    }

}
