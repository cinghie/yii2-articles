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

/**
 * This is the model class for table "{{%article_tags_assign}}".
 *
 * @property integer $id
 * @property integer $tag_id
 * @property integer $item_id
 */
class Tagsassign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_tags_assign}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','tag_id', 'item_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('articles', 'ID'),
            'tag_id' => Yii::t('articles', 'Tagid'),
            'item_id' => Yii::t('articles', 'Itemid'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tags::className(), ['id' => 'tag_id']);
    }

    /**
     * @inheritdoc
     *
     * @return TagsAssignQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagsAssignQuery(get_called_class());
    }

}
