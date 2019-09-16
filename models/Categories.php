<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.6
*/

namespace cinghie\articles\models;

use Yii;
use cinghie\traits\AccessTrait;
use cinghie\traits\EditorTrait;
use cinghie\traits\ImageTrait;
use cinghie\traits\LanguageTrait;
use cinghie\traits\NameAliasTrait;
use cinghie\traits\OrderingTrait;
use cinghie\traits\ParentTrait;
use cinghie\traits\SeoTrait;
use cinghie\traits\StateTrait;
use cinghie\traits\UserHelpersTrait;
use cinghie\traits\ViewsHelpersTrait;
use yii\base\InvalidParamException;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%article_categories}}".
 *
 * @property int $id
 * @property string $description
 * @property string $theme
 * @property int $ordering
 * @property string $params
 *
 * @property Categories $parent
 * @property Categories[] $categories
 * @property CategoriesTranslations[] $translations
 * @property ActiveQuery $items
 * @property string $categoryUrl
 * @property string $imageUrl
 * @property string $imagePath
 * @property array[] $themesSelect2
 */
class Categories extends Articles
{

    use AccessTrait, EditorTrait, ImageTrait, LanguageTrait, NameAliasTrait, OrderingTrait, ParentTrait, SeoTrait, StateTrait, UserHelpersTrait, ViewsHelpersTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {	
        return array_merge(AccessTrait::rules(), ImageTrait::rules(), LanguageTrait::rules(), NameAliasTrait::rules(), OrderingTrait::rules(), ParentTrait::rules(), StateTrait::rules(),[
            [['access', 'name', 'language', 'state', 'theme'], 'required'],
            [['theme'], 'string', 'max' => 12],
			[['robots'], 'string', 'max' => 20],
            [['author', 'copyright'], 'string', 'max' => 50],
            [['description', 'metadesc', 'metakey', 'params'], 'string'],
	        [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => static::class, 'targetAttribute' => [ 'parent_id' => 'id']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(AccessTrait::attributeLabels(), ImageTrait::attributeLabels(), LanguageTrait::attributeLabels(), NameAliasTrait::attributeLabels(), OrderingTrait::attributeLabels(), ParentTrait::attributeLabels(), StateTrait::attributeLabels(),[
            'id' => Yii::t('articles', 'ID'),
            'description' => Yii::t('articles', 'Description'),
            'theme' => Yii::t('articles', 'Theme'),
            'image' => Yii::t('traits', 'Image'),
            'image_caption' => Yii::t('traits', 'Image Caption'),
            'image_credits' => Yii::t('traits', 'Image Credits'),
            'params' => Yii::t('articles', 'Params'),
            'metadesc' => Yii::t('traits', 'Metadesc'),
            'metakey' => Yii::t('traits', 'Metakey'),
            'robots' => Yii::t('traits', 'Robots'),
            'author' => Yii::t('traits', 'Author'),
            'copyright' => Yii::t('traits', 'Copyright'),
            'language' => Yii::t('traits', 'Language'),
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(self::class, [ 'parent_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Items::class, ['cat_id' => 'id']);
    }

	/**
	 * @return ActiveQuery
	 */
	public function getTranslations()
	{
		return $this->hasMany(CategoriesTranslations::class, ['cat_id' => 'id']);
	}

	/**
	 * Return CategoriesTranslations by lang
	 *
	 * @param string $lang
	 *
	 * @return CategoriesTranslations[]
	 */
	public function getTranslationsObject($lang)
	{
		return CategoriesTranslations::find()->where(['cat_id' => $this->id, 'lang' => $lang])->one();
	}

	/**
	 * Return CategoriesTranslations by ID
	 *
	 * @param int $id
	 * @param string $lang
	 *
	 * @return CategoriesTranslations[]
	 */
	public function getTranslationsObjectByID($id,$lang)
	{
		return CategoriesTranslations::find()->where(['cat_id' => $id, 'lang' => $lang])->one();
	}

	/**
	 * Before delete Categories, delete image
	 *
	 * @throws InvalidParamException
	 */
	public function beforeDelete()
	{
		/** @var Categories $this */
		$this->deleteTranslations();
		$this->deleteImage();

		return parent::beforeDelete();
	}

	/**
	 * Delete Translations
	 */
	public function deleteTranslations()
	{
		/** @var CategoriesTranslations $translation */
		foreach($this->translations as $translation)
		{
			if ($this->id !== $translation->translation_id && ($category = self::findOne($translation->translation_id)) !== null) {
				$category->delete();
			}

			$translation->delete();
		}
	}

	/**
	 * Delete Images
	 *
	 * @return mixed the uploaded image instance
	 * @throws InvalidParamException
	 */
	public function deleteImage()
	{
		$image   = Yii::getAlias( Yii::$app->getModule('articles')->categoryImagePath ) . $this->image;
		$imageS  = Yii::getAlias( Yii::$app->getModule('articles')->categoryThumbPath . 'small/' ) . $this->image;
		$imageM  = Yii::getAlias( Yii::$app->getModule('articles')->categoryThumbPath . 'medium/' ) . $this->image;
		$imageL  = Yii::getAlias( Yii::$app->getModule('articles')->categoryThumbPath . 'large/' ) . $this->image;
		$imageXL = Yii::getAlias( Yii::$app->getModule('articles')->categoryThumbPath . 'extra/' ) . $this->image;

		// check if image exists on server
		if (empty($this->image) || !file_exists($image)) {
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
	 * Return Tag url
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
	public function getCategoryUrl() {
		return Url::to(['/articles/categories/view', 'id' => $this->id, 'alias' => $this->alias]);
	}

	/**
	 * Fetch stored file url
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
	public function getImageUrl()
	{
		$file = isset($this->image) ? $this->image : 'default.jpg';
		return Yii::getAlias(Yii::$app->getModule('articles')->categoryImageURL).$file;
	}

	/**
	 * Fetch stored file name with complete path
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
    public function getImagePath()
    {
        return isset($this->image) ? Yii::getAlias(Yii::$app->getModule('articles')->categoryImagePath).$this->image : null;
    }

	/**
	 * Fetch stored image thumb url
	 *
	 * @param $size
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
    public function getImageThumbUrl($size)
    {
        // return a default image placeholder if your source avatar is not found
        $file = isset($this->image) ? $this->image : 'default.jpg';
        return Yii::getAlias(Yii::$app->getModule('articles')->categoryImageURL) . 'thumb/' . $size . '/' . $file;
    }

	/**
	 * Check Translation Item by lang
	 *
	 * @param string $lang
	 *
	 * @return Items[] || Items
	 */
	public function getCategoryTranslation($lang)
	{
		/** @var CategoriesTranslations $translation */
		$translation = $this->getTranslationsObject($lang);

		if($translation !== null && $translation->getTranslation()->one() !== null) {
			return $translation->getTranslation()->one();
		}

		$translation = null;
		$translation_parent = CategoriesTranslations::find()->where(['translation_id' => $this->id])->one();

		if($translation_parent !== null) {
			$translation = $this->getTranslationsObjectByID($translation_parent->cat_id,$lang);
		}

		if($translation !== null && $translation->getTranslation()->one() !== null) {
			return $translation->getTranslation()->one();
		}

		return null;
	}

	/**
	 * Return CategoriesTranslations Item by lang
	 *
	 * @param string $lang
	 * @param string $field
	 *
	 * @return CategoriesTranslations[] | string
	 */
	public function getFieldTranslation($lang,$field)
	{
		/** @var CategoriesTranslations $translation */
		$translation = $this->getTranslationsObject($lang);

		if($this->isNewRecord) {
			return '';
		}

		if($translation !== null && $translation->getTranslation()->one() !== null) {
			return $translation->getTranslation()->one()->$field;
		}

		$translation = null;
		$translation_parent = CategoriesTranslations::find()->where(['translation_id' => $this->id])->one();

		if($translation_parent !== null) {
			$translation = $this->getTranslationsObjectByID($translation_parent->cat_id,$lang);
		}

		if($translation !== null && $translation->getTranslation()->one() !== null) {
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
	public function getCategoriesLangSelect2($lang)
	{
		/** @var CategoriesTranslations $translation */
		$translation = $this->getTranslationsObject($lang);

		if($this->isNewRecord) {
			return [ 0 => Yii::t('articles', 'Not Yet Translated') ];
		}

		if($translation !== null && $translation->getTranslation()->one() !== null) {
			return [ $translation->translation_id => $translation->getTranslation()->one()->name ];
		}

		$translation = null;
		$translation_parent = CategoriesTranslations::find()->where(['translation_id' => $this->id])->one();

		if($translation_parent !== null) {
			$translation = $this->getTranslationsObjectByID($translation_parent->cat_id,$lang);
		}

		if($translation !== null && $translation->getTranslation()->one() !== null) {
			return [ $translation->translation_id => $translation->getTranslation()->one()->title ];
		}

		return [ 0 => Yii::t('articles', 'Not Yet Translated') ];
	}

    /**
     * @inheritdoc
     *
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery( static::class );
    }
	
}
