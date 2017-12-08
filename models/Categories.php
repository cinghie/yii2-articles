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
use cinghie\traits\EditorTrait;
use cinghie\traits\ImageTrait;
use cinghie\traits\LanguageTrait;
use cinghie\traits\NameAliasTrait;
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
 * @property ActiveQuery $items
 * @property string $categoryUrl
 * @property string $imageUrl
 * @property string $imagePath
 * @property array[] $themesSelect2
 */
class Categories extends Articles
{

    use AccessTrait, EditorTrait, ImageTrait, LanguageTrait, NameAliasTrait, ParentTrait, SeoTrait, StateTrait, UserHelpersTrait, ViewsHelpersTrait;

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
        return array_merge(AccessTrait::rules(), ImageTrait::rules(), LanguageTrait::rules(), NameAliasTrait::rules(), ParentTrait::rules(), StateTrait::rules(),[
            [['access', 'name', 'language', 'state', 'theme'], 'required'],
			[['ordering'], 'integer'],
            [['theme'], 'string', 'max' => 12],
			[['robots'], 'string', 'max' => 20],
            [['author', 'copyright'], 'string', 'max' => 50],
            [['description', 'metadesc', 'metakey', 'params'], 'string'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(AccessTrait::attributeLabels(), ImageTrait::attributeLabels(), LanguageTrait::attributeLabels(), NameAliasTrait::attributeLabels(), ParentTrait::attributeLabels(), StateTrait::attributeLabels(),[
            'id' => Yii::t('articles', 'ID'),
            'description' => Yii::t('articles', 'Description'),
            'theme' => Yii::t('articles', 'Theme'),
            'ordering' => Yii::t('articles', 'Ordering'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(self::className(), [ 'parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Items::className(), ['cat_id' => 'id']);
    }

	/**
	 * Before delete Categories, delete image
	 *
	 * @throws InvalidParamException
	 */
	public function beforeDelete()
	{
		/** @var Categories $this */
		$this->deleteImage();

		return parent::beforeDelete();
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
		return Yii::getAlias(Yii::$app->controller->module->categoryImageURL).$file;
	}

	/**
	 * Fetch stored file name with complete path
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
    public function getImagePath()
    {
        return isset($this->image) ? Yii::getAlias(Yii::$app->controller->module->categoryImagePath).$this->image : null;
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
        return Yii::getAlias(Yii::$app->controller->module->categoryImageURL) . 'thumb/' . $size . '/' . $file;
    }

	/**
	 * Delete Image
	 *
	 * @return mixed the uploaded image instance
	 * @throws InvalidParamException
	 */
	public function deleteImage() 
	{
		$image   = Yii::getAlias( Yii::$app->controller->module->categoryImagePath ) . $this->image;
		$imageS  = Yii::getAlias( Yii::$app->controller->module->categoryThumbPath . 'small/' ) . $this->image;
		$imageM  = Yii::getAlias( Yii::$app->controller->module->categoryThumbPath . 'medium/' ) . $this->image;
		$imageL  = Yii::getAlias( Yii::$app->controller->module->categoryThumbPath . 'large/' ) . $this->image;
		$imageXL = Yii::getAlias( Yii::$app->controller->module->categoryThumbPath . 'extra/' ) . $this->image;
		
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
     * Return array with Categories Themes
     *
     * @return array[]
     */
    public function getThemesSelect2()
    {
        $array = [
            'blog' => 'Blog',
            'portfolio' => 'Portfolio'
        ];

        return $array;
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
