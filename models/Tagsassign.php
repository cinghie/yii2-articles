<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.3
 */

namespace cinghie\articles\models;

use Yii;

/**
 * This is the model class for table "{{%article_tags_assign}}".
 * @property integer $id
 * @property integer $tagid
 * @property integer $itemid
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
            [['tagid', 'itemid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('articles', 'ID'),
            'tagid' => Yii::t('articles', 'Tagid'),
            'itemid' => Yii::t('articles', 'Itemid'),
        ];
    }

    /**
     * @inheritdoc
     * @return TagsAssignQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagsAssignQuery(get_called_class());
    }
}
