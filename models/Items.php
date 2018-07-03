<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.5
*/

namespace cinghie\articles\models;

use Yii;
use cinghie\traits\AccessTrait;
use cinghie\traits\AttachmentTrait;
use cinghie\traits\CreatedTrait;
use cinghie\traits\EditorTrait;
use cinghie\traits\GoogleTranslateTrait;
use cinghie\traits\ImageTrait;
use cinghie\traits\LanguageTrait;
use cinghie\traits\ModifiedTrait;
use cinghie\traits\OrderingTrait;
use cinghie\traits\SeoTrait;
use cinghie\traits\StateTrait;
use cinghie\traits\TitleAliasTrait;
use cinghie\traits\UserTrait;
use cinghie\traits\UserHelpersTrait;
use cinghie\traits\VideoTrait;
use cinghie\traits\ViewsHelpersTrait;
use yii\base\InvalidParamException;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%article_items}}".
 *
 * @property int $id
 * @property int $cat_id
 * @property string $introtext
 * @property string $fulltext
 * @property string $theme
 * @property int $ordering
 * @property int $hits
 * @property string $params
 *
 * @property Attachments[] $attachments
 * @property Attachments[] $attachs
 * @property Items[] $items
 * @property Tags[] $tags
 * @property Tagsassign[] $tagsAssigns
 * @property Translations[] $translationsassigns
 *
 * @property ActiveQuery $category
 * @property ActiveQuery $tagsassigns
 * @property ActiveQuery $translations
 *
 * @property string $itemUrl
 * @property string $imagePath
 * @property string $imageUrl
 * @property array $publishSelect2
 */
class Items extends Articles
{

	use AccessTrait, AttachmentTrait, CreatedTrait, EditorTrait, GoogleTranslateTrait, ImageTrait,  LanguageTrait, ModifiedTrait, OrderingTrait, SeoTrait, StateTrait, TitleAliasTrait, UserHelpersTrait, UserTrait, VideoTrait, ViewsHelpersTrait;

	public $attachments;
    public $tags;
    public $tagsAssign;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%article_items}}';
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
	    return array_merge(AccessTrait::rules(), CreatedTrait::rules(), ImageTrait::rules(), LanguageTrait::rules(), ModifiedTrait::rules(), OrderingTrait::rules(), SeoTrait::rules(), StateTrait::rules(), UserTrait::rules(), VideoTrait::rules(), [
	    	[['title', 'user_id', 'created', 'modified', 'language'], 'required'],
            [['cat_id', 'hits'], 'integer'],
            [['introtext', 'fulltext', 'theme', 'params'], 'string'],
	        [['attachments','tags'], 'safe'],
	        [['attachments'], 'file', 'extensions' => Yii::$app->controller->module->attachType],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['cat_id' => 'id']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
	    return array_merge(AccessTrait::attributeLabels(), CreatedTrait::attributeLabels(), ImageTrait::attributeLabels(), LanguageTrait::attributeLabels(), ModifiedTrait::attributeLabels(), OrderingTrait::attributeLabels(), SeoTrait::attributeLabels(), StateTrait::attributeLabels(), TitleAliasTrait::attributeLabels(), UserTrait::attributeLabels(),  VideoTrait::attributeLabels(), [
            'id' => Yii::t('articles', 'ID'),
            'cat_id' => Yii::t('articles', 'Catid'),
            'introtext' => Yii::t('articles', 'Introtext'),
            'fulltext' => Yii::t('articles', 'Fulltext'),
            'theme' => Yii::t('articles', 'Theme'),
            'hits' => Yii::t('articles', 'Hits'),
            'params' => Yii::t('articles', 'Params'),
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachments::class, ['item_id' => 'id'])->from(Attachments::tableName() . ' AS attachments');
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'cat_id'])->from(Categories::tableName() . ' AS categories');
    }

    /**
     * @return ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(self::class, ['cat_id' => 'id'])->from(self::tableName() . ' AS items');
    }

    /**
     * @return ActiveQuery
     */
    public function getTagsassigns()
    {
        return $this->hasMany(Tagsassign::class, ['item_id' => 'id'])->from(Tagsassign::tableName() . ' AS tags_assign');
    }

	/**
	 * @return ActiveQuery
	 */
	public function getTranslations()
	{
		return $this->hasMany(Translations::class, ['item_id' => 'id'])->from(Translations::tableName() . ' AS translations');
	}

	/**
	 * @param $id
	 * @param $lang
	 *
	 * @return ActiveQuery
	 */
	public function getTranslationByIDLang($id,$lang)
	{
		return $this->hasOne(Translations::class, ['item_id' => $id, 'lang' => $lang])->from(Translations::tableName() . ' AS translations');
	}

	/**
	 * Before delete Item, delete Image, Attachments, Tagsassigned
	 *
	 * @throws InvalidParamException
	 */
	public function beforeDelete()
	{
		/** @var Items $this */

		// Delete Attachments
		$this->deleteAttachments();
		Attachments::deleteAll([ 'AND', 'item_id = '.$this->id ]);

		// Delete Image
		$this->deleteImage();

		// Delete Tagsassigned
		Tagsassign::deleteAll([ 'AND', 'item_id = '.$this->id ]);

		// Delete Translations
		Translations::deleteAll([ 'AND', 'item_id = '.$this->id ]);

		return parent::beforeDelete();
	}

	/**
	 * Return Attachments by item_id
	 *
	 * @return Attachments[]
	 */
	public function getAttachs()
	{
		return Attachments::find()->where(['item_id' => $this->id])->all();
	}

	/**
	 * Return Translations by lang
	 *
	 * @param string $lang
	 *
	 * @return Translations[]
	 */
	public function getTranslationsObject($lang)
	{
		return Translations::find()->where(['item_id' => $this->id, 'lang' => $lang])->one();
	}

	/**
	 * Return Translations by ID
	 *
	 * @param int $id
	 * @param string $lang
	 *
	 * @return Translations[]
	 */
	public function getTranslationsObjectByID($id,$lang)
	{
		return Translations::find()->where(['item_id' => $id, 'lang' => $lang])->one();
	}

	/**
	 * return item url
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
    public function getItemUrl() {
        return Url::to(['/articles/items/view', 'id' => $this->id, 'alias' => $this->alias, 'cat' => $this->category->alias]);
    }

	/**
	 * Fetch stored file name with complete path
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
    public function getImagePath() {
        return isset($this->image) ? Yii::getAlias(Yii::$app->controller->module->itemImagePath).$this->image : null;
    }

	/**
	 * Fetch stored file url
	 *
	 * @return string
	 * @throws InvalidParamException
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
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
    public function getImageThumbUrl($size)
    {
        $file = isset($this->image) ? $this->image : 'default.jpg';
        return Yii::getAlias(Yii::$app->controller->module->itemImageURL) . 'thumb/' . $size . '/' . $file;
    }

	/**
	 * Delete Image
	 *
	 * @return mixed the uploaded image instance
	 * @throws InvalidParamException
	 */
	public function deleteImage() 
	{
		$image   = Yii::getAlias( Yii::$app->controller->module->itemImagePath ). $this->image;
		$imageS  = Yii::getAlias( Yii::$app->controller->module->itemThumbPath . 'small/' ) . $this->image;
		$imageM  = Yii::getAlias( Yii::$app->controller->module->itemThumbPath . 'medium/' ) . $this->image;
		$imageL  = Yii::getAlias( Yii::$app->controller->module->itemThumbPath . 'large/' ) . $this->image;
		$imageXL = Yii::getAlias( Yii::$app->controller->module->itemThumbPath . 'extra/' ) . $this->image;
		
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
		}

		return false;
	}

	/**
	 * Delete Attachments
	 *
	 * @throws InvalidParamException
	 */
	public function deleteAttachments()
	{
		$attachments = $this->getAttachs();

		foreach ($attachments as $attachment) {
			$attachmentUrl = Yii::getAlias( Yii::$app->controller->module->attachPath ). $attachment['filename'];
			unlink($attachmentUrl);
		}
	}

	/**
	 * Check Item or Item Translation based on current lang
	 *
	 * @param int $id
	 *
	 * @return Items
	 */
	public function getTranslationItem($id)
	{
		$current_lang = Yii::$app->language;
		$default_lang = Yii::$app->getModule('articles')->languageAll;

		$item = self::find()
			->where(['id' => $id])
			->one();

		if( $item->language === $current_lang && 0 === strpos($default_lang, $current_lang) ) {
			return $item;
		}

		if ( $item->getItemTranslation($current_lang) !== null ) {
			return $item->getItemTranslation($current_lang);
		}

		if( $item->getItemTranslation('all') !== null ) {
			return $item->getItemTranslation('all');
		}

		return $item->getItemTranslation(substr($default_lang,0,2));
	}

	/**
	 * Check Translation Item by lang
	 *
	 * @param string $lang
	 *
	 * @return Items[]
	 */
	public function getItemTranslation($lang)
	{
		/** @var Translations $translation */
		$translation = $this->getTranslationsObject($lang);

		if($translation !== null) {
			return $translation->getTranslation()->one();
		}

		$translation = null;
		$translation_parent = Translations::find()->where(['translation_id' => $this->id])->one();

		if($translation_parent !== null) {
			$translation = $this->getTranslationsObjectByID($translation_parent->item_id,$lang);
		}

		if($translation !== null) {
			return $translation->getTranslation()->one();
		}

		return null;
	}

	/**
	 * Return Translations Item by lang
	 *
	 * @param string $lang
	 * @param string $field
	 *
	 * @return Translations[] | string
	 */
	public function getFieldTranslation($lang,$field)
	{
		/** @var Translations $translation */
		$translation = $this->getTranslationsObject($lang);

		if($translation !== null) {
			return $translation->getTranslation()->one()->$field;
		}

		$translation = null;
		$translation_parent = Translations::find()->where(['translation_id' => $this->id])->one();

		if($translation_parent !== null) {
			$translation = $this->getTranslationsObjectByID($translation_parent->item_id,$lang);
		}

		if($translation !== null) {
			return $translation->getTranslation()->one()->$field;
		}

		return '';
	}

	/**
	 * Return array for ItemsLangSelect2
	 *
	 * @param string $lang
	 *
	 * @return array
	 */
	public function getItemsLangSelect2($lang)
	{
		/** @var Translations $translation */
		$translation = $this->getTranslationsObject($lang);

		if($translation !== null) {
			return [ $translation->translation_id => $translation->getTranslation()->one()->title ];
		}

		$translation = null;
		$translation_parent = Translations::find()->where(['translation_id' => $this->id])->one();

		if($translation_parent !== null) {
			$translation = $this->getTranslationsObjectByID($translation_parent->item_id,$lang);
		}

		if($translation !== null) {
			return [ $translation->translation_id => $translation->getTranslation()->one()->title ];
		}

		return [ 0 => Yii::t('articles', 'Not Yet Translated') ];
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
        }

	    return [ 0 => Yii::t('articles', 'Unpublished') ];
    }

}
