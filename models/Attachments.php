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

class Attachments extends Articles
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_attachments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['itemid', 'filename', 'title', 'titleAttribute', 'hits'], 'required'],
            [['itemid', 'hits'], 'integer'],
            [['titleAttribute'], 'string'],
            [['filename', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'itemid' => Yii::t('app', 'Itemid'),
            'filename' => Yii::t('app', 'Filename'),
            'title' => Yii::t('app', 'Title'),
            'titleAttribute' => Yii::t('app', 'Title Attribute'),
            'hits' => Yii::t('app', 'Hits'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(ArticleItems::className(), ['id' => 'itemid']);
    }
}
