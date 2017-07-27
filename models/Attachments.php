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
use cinghie\traits\AttachmentTrait;
use cinghie\traits\ViewsHelpersTrait;

/**
 * This is the model class for table "{{%article_attachments}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $title
 * @property string $alias
 * @property string $titleAttribute
 * @property string $filename
 * @property string $extension
 * @property string $mimetype
 * @property int $size
 * @property int $hits
 *
 * @property Items $item
 */
class Attachments extends Articles
{

    use AttachmentTrait, ViewsHelpersTrait;

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
        return array_merge(AttachmentTrait::rules(), [
            [['title'], 'required'],
            [['item_id', 'hits'], 'integer'],
            [['titleAttribute'], 'string'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(AttachmentTrait::attributeLabels(), [
            'id' => Yii::t('articles', 'ID'),
            'item_id' => Yii::t('articles', 'Article'),
            'titleAttribute' => Yii::t('articles', 'Title Attribute'),
            'hits' => Yii::t('articles', 'Hits'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
    }

    /**
     * check if current user is the author from the article id
     *
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
     *
     * @return bool
     */
    public function getUserAuthor()
    {
        return $this->getItem()->one()->created_by;
    }

    /**
     * Delete File attached
     *
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
        }
    }

}
