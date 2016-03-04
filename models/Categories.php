<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.1
*/

namespace cinghie\articles\models;

use Yii;

class Categories extends Articles
{
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
        return [
            [['name', 'language'], 'required'],
			[['parentid', 'state', 'ordering'], 'integer'],
			[['name', 'alias', 'image_caption', 'image_credits'], 'string', 'max' => 255],
            [['description', 'image', 'params', 'metadesc', 'metakey'], 'string'],
            [['access'], 'string', 'max' => 64],
			[['author', 'copyright'], 'string', 'max' => 50],
			[['language'], 'string', 'max' => 7],
			[['robots'], 'string', 'max' => 20],
			[['image'], 'file', 'extensions' => Yii::$app->controller->module->imageType,],
			[['image'], 'safe']
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
            'parentid' => Yii::t('articles', 'Parent'),
            'state' => Yii::t('articles', 'State'),
            'access' => Yii::t('articles', 'Access'),
            'ordering' => Yii::t('articles', 'Ordering'),
            'image' => Yii::t('articles', 'Image'),
            'image_caption' => Yii::t('articles', 'Image Caption'),
            'image_credits' => Yii::t('articles', 'Image Credits'),
            'params' => Yii::t('articles', 'Params'),
            'metadesc' => Yii::t('articles', 'Metadesc'),
            'metakey' => Yii::t('articles', 'Metakey'),
            'robots' => Yii::t('articles', 'Robots'),
            'author' => Yii::t('articles', 'Author'),
            'copyright' => Yii::t('articles', 'Copyright'),
            'language' => Yii::t('articles', 'Language'),
        ];
    }
	
	// Return Parent ID
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parentid'])->from(self::tableName() . ' AS parent');
    }
	
	// Return Parent Name
	public function getParentName()
	{
        $model = $this->parent;
        return $model?$model->name:'';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['parentid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleItems()
    {
        return $this->hasMany(ArticleItems::className(), ['catid' => 'id']);
    }
	
	/**
     * fetch stored file name with complete path 
     * @return string
     */
    public function getFilePath() 
    {
        return isset($this->image) ? Yii::getAlias(Yii::$app->controller->module->categoryImagePath).$this->image : null;
    }
	
	/**
     * fetch stored file url
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $file = isset($this->image) ? $this->image : 'default.jpg';
        return Yii::getAlias(Yii::$app->controller->module->categoryImageURL).$file;
    }
	
	/**
     * fetch stored image url
     * @return string
     */
    public function getImageThumbUrl($size)
    {
        // return a default image placeholder if your source avatar is not found
        $file = isset($this->image) ? $this->image : 'default.jpg';
        return Yii::getAlias(Yii::$app->controller->module->categoryImageURL)."thumb/".$size."/".$file;
    }
	
	/**
    * Delete Image
    * @return mixed the uploaded image instance
    */
	public function deleteImage() 
	{
		$image   = Yii::getAlias(Yii::$app->controller->module->categoryImagePath).$this->image;
		$imageS  = Yii::getAlias(Yii::$app->controller->module->categoryThumbPath."small/").$this->image;
		$imageM  = Yii::getAlias(Yii::$app->controller->module->categoryThumbPath."medium/").$this->image;
		$imageL  = Yii::getAlias(Yii::$app->controller->module->categoryThumbPath."large/").$this->image;
		$imageXL = Yii::getAlias(Yii::$app->controller->module->categoryThumbPath."extra/").$this->image;
		
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
			
		} else {
			return false;
		}
		
	}
		
	// Return array for Category Select2
	public function getCategoriesSelect2()
	{
		$sql = 'SELECT id,name FROM {{%article_categories}} WHERE state = 1';
		$categories = Categories::findBySql($sql)->asArray()->all();
		
		$array[0] = Yii::t('articles', 'No Parent'); 
		
		foreach($categories as $category)
		{
			$array[$category['id']] = $category['name'];
		}
		
		return $array;
	}
	
}
