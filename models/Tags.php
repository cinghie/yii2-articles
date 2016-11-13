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
 * This is the model class for table "{{%article_tags}}".
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $description
 */
class Tags extends \yii\db\ActiveRecord
{
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
        return [
            [['name', 'alias'], 'required'],
            [['description'], 'string'],
            [['name', 'alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('articles', 'ID'),
            'name' => Yii::t('articles', 'Name'),
            'alias' => Yii::t('articles', 'Alias'),
            'description' => Yii::t('articles', 'Description'),
        ];
    }

    /**
     * @inheritdoc
     * @return TagsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagsQuery(get_called_class());
    }
}
