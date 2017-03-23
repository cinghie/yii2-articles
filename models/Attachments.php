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
            [['itemid', 'title', 'titleAttribute'], 'required'],
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
            'id' => Yii::t('articles', 'ID'),
            'itemid' => Yii::t('articles', 'Article'),
            'filename' => Yii::t('articles', 'Filename'),
            'title' => Yii::t('articles', 'Title'),
            'titleAttribute' => Yii::t('articles', 'Title Attribute'),
            'hits' => Yii::t('articles', 'Hits'),
        ];
    }

    /**
     * check if current user is the author from the article id
     * @return bool
     */
    public function isUserAuthor()
    {
        if ( Yii::$app->user->identity->id == $this->getUserAuthor() )
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * return user of the author from the article
     * @return bool
     */
    public function getUserAuthor()
    {
        return $this->getItem()->one()->created_by;
    }

    /**
     * Delete File attached
     * @return mixed the uploaded image instance
     */
    public function deleteFile()
    {
        $file = Yii::getAlias(Yii::$app->controller->module->attachPath).$this->filename;

        // check if image exists on server
        if ( empty($this->filename) || !file_exists($file) ) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (unlink($file)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'itemid']);
    }
}
