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
use cinghie\traits\AccessTrait;
use cinghie\traits\AttachmentTrait;
use cinghie\traits\CreatedTrait;
use cinghie\traits\EditorTrait;
use cinghie\traits\ImageTrait;
use cinghie\traits\LanguageTrait;
use cinghie\traits\ModifiedTrait;
use cinghie\traits\SeoTrait;
use cinghie\traits\StateTrait;
use cinghie\traits\TitleAliasTrait;
use cinghie\traits\UserTrait;
use cinghie\traits\UserHelpersTrait;
use cinghie\traits\VideoTrait;
use cinghie\traits\ViewsHelpersTrait;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%article_items}}".
 *
 * @property int $id
 * @property int $cat_id
 * @property string $title
 * @property string $alias
 * @property string $introtext
 * @property string $fulltext
 * @property int $state
 * @property string $access
 * @property string $language
 * @property string $theme
 * @property int $ordering
 * @property int $hits
 * @property string $image
 * @property string $image_caption
 * @property string $image_credits
 * @property string $video
 * @property string $video_type
 * @property string $video_caption
 * @property string $video_credits
 * @property string $params
 * @property string $metadesc
 * @property string $metakey
 * @property string $robots
 * @property string $author
 * @property string $copyright
 * @property int $user_id
 * @property int $created_by
 * @property string $created
 * @property int $modified_by
 * @property string $modified
 *
 * @property Attachments[] $articleAttachments
 * @property Items $cat
 * @property Items[] $items
 * @property \dektrium\user\models\User $createdBy
 * @property \dektrium\user\models\User $modifiedBy
 * @property \dektrium\user\models\User $user
 * @property TagsAssign[] $articleTagsAssigns
 */
class Items extends Articles
{

    use AccessTrait, AttachmentTrait, CreatedTrait, EditorTrait, ImageTrait, LanguageTrait, ModifiedTrait, SeoTrait, StateTrait, TitleAliasTrait, UserHelpersTrait, UserTrait, VideoTrait, ViewsHelpersTrait;

    public $attachments;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%article_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(AccessTrait::rules(), CreatedTrait::rules(), ImageTrait::rules(), LanguageTrait::rules(), ModifiedTrait::rules(), SeoTrait::rules(), StateTrait::rules(), TitleAliasTrait::rules(), UserTrait::rules(), VideoTrait::rules(), [
            [['title', 'user_id', 'created', 'modified', 'language'], 'required'],
            [['cat_id', 'ordering', 'hits'], 'integer'],
            [['introtext', 'fulltext', 'params'], 'string'],
	        [['attachments'], 'safe'],
	        [['attachments'], 'file', 'extensions' => Yii::$app->controller->module->attachType],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['cat_id' => 'id']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(AccessTrait::attributeLabels(), CreatedTrait::attributeLabels(), ImageTrait::attributeLabels(), LanguageTrait::attributeLabels(), ModifiedTrait::attributeLabels(), SeoTrait::attributeLabels(), StateTrait::attributeLabels(), TitleAliasTrait::attributeLabels(), UserTrait::attributeLabels(),  VideoTrait::attributeLabels(), [
            'id' => Yii::t('articles', 'ID'),
            'cat_id' => Yii::t('articles', 'Catid'),
            'introtext' => Yii::t('articles', 'Introtext'),
            'fulltext' => Yii::t('articles', 'Fulltext'),
            'ordering' => Yii::t('articles', 'Ordering'),
            'hits' => Yii::t('articles', 'Hits'),
            'params' => Yii::t('articles', 'Params'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachments::className(), ['item_id' => 'id'])->from(Attachments::tableName() . ' AS attach');
    }

	public function getAttachs()
	{
		return Attachments::find()->where(['item_id' => $this->id])->all();
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id'])->from(Categories::tableName() . ' AS category');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(self::className(), ['cat_id' => 'id'])->from(self::tableName() . ' AS items');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagsAssigns()
    {
        return $this->hasMany(TagsAssign::className(), ['item_id' => 'id'])->from(TagsAssign::tableName() . ' AS tags_assign');
    }

    /**
     * return item url
     *
     * @return string
     */
    public function getItemUrl() {
        return Url::to(['/articles/items/view', 'id' => $this->id, 'alias' => $this->alias, 'cat' => $this->category->alias]);
    }

	/**
     * Fetch stored file name with complete path
     *
     * @return string
     */
    public function getImagePath() {
        return isset($this->image) ? Yii::getAlias(Yii::$app->controller->module->itemImagePath).$this->image : null;
    }
	
	/**
     * Fetch stored file url
     *
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $file = isset($this->image) ? $this->image : 'default.jpg';
        return Yii::getAlias(Yii::$app->controller->module->itemImageURL).$file;
    }

    /**
     * Fetch stored image url
     *
     * @param $size
     * @return string
     */
    public function getImageThumbUrl($size)
    {
        $file = isset($this->image) ? $this->image : 'default.jpg';
        return Yii::getAlias(Yii::$app->controller->module->itemImageURL)."thumb/".$size."/".$file;
    }
	
	/**
    * Delete Image
    *
    * @return mixed the uploaded image instance
    */
	public function deleteImage() 
	{
		$image   = Yii::getAlias(Yii::$app->controller->module->itemImagePath).$this->image;
		$imageS  = Yii::getAlias(Yii::$app->controller->module->itemThumbPath."small/").$this->image;
		$imageM  = Yii::getAlias(Yii::$app->controller->module->itemThumbPath."medium/").$this->image;
		$imageL  = Yii::getAlias(Yii::$app->controller->module->itemThumbPath."large/").$this->image;
		$imageXL = Yii::getAlias(Yii::$app->controller->module->itemThumbPath."extra/").$this->image;
		
		// check if image exists on server
        if ( empty($this->image) || !file_exists($image) ) {
            return false;
        }
		
		// check if uploaded file can be deleted on server
		if (unlink($image))
		{
			unlink($imageS);
			unlink($imageM);
			unlink($imageL);
			unlink($imageXL);
			
			return true;
			
		} else {
			return false;
		}
		
	}

    /**
     * Return array for Publish Status
     *
     * @return array
     */
    public function getPublishSelect2()
    {
        if ( Yii::$app->user->can('articles-publish-all-items') || Yii::$app->user->can('articles-publish-his-items') ) {
            return [ 1 => Yii::t('articles', 'Published'), 0 => Yii::t('articles', 'Unpublished') ];
        } else {
            return [ 0 => Yii::t('articles', 'Unpublished') ];
        }
    }

    /*
     * Return a date formatted with default format
     *
     * @param strung $date
     * @return string
     */
    public function getDateFormatted($date) {
        return Yii::$app->formatter->asDatetime($date, "php:".Yii::$app->controller->module->dateFormat);
    }
	
}
