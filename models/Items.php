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

class Items extends Articles
{
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
        return [
            [['title', 'catid', 'userid', 'created', 'modified', 'language'], 'required'],
            [['catid', 'userid', 'published', 'created_by', 'modified_by', 'access', 'ordering', 'hits'], 'integer'],
            [['introtext', 'fulltext', 'image_caption', 'video_caption', 'metadesc', 'metakey', 'params'], 'string'],
			[['title', 'alias', 'image_caption', 'image_credits', 'video_caption', 'video_credits'], 'string', 'max' => 255],
			[['video', 'author', 'copyright'], 'string', 'max' => 50],
			[['robots','video_type'], 'string', 'max' => 20],
			[['language'], 'string', 'max' => 7],
            [['created', 'modified','image'], 'safe'],
			[['image'], 'file', 'extensions' => Yii::$app->controller->module->imageType,]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('articles.message', 'ID'),
            'title' => Yii::t('articles.message', 'Title'),
            'catid' => Yii::t('articles.message', 'Catid'),
            'userid' => Yii::t('articles.message', 'Userid'),
            'published' => Yii::t('articles.message', 'Published'),
            'introtext' => Yii::t('articles.message', 'Introtext'),
            'fulltext' => Yii::t('articles.message', 'Fulltext'),
            'image' => Yii::t('articles.message', 'Image'),
            'image_caption' => Yii::t('articles.message', 'Image Caption'),
            'image_credits' => Yii::t('articles.message', 'Image Credits'),
            'video' => Yii::t('articles.message', 'Video ID'),
			'video_type' => Yii::t('articles.message', 'Video Type'),
            'video_caption' => Yii::t('articles.message', 'Video Caption'),
            'video_credits' => Yii::t('articles.message', 'Video Credits'),
            'created' => Yii::t('articles.message', 'Created'),
            'created_by' => Yii::t('articles.message', 'Created By'),
            'modified' => Yii::t('articles.message', 'Modified'),
            'modified_by' => Yii::t('articles.message', 'Modified By'),
            'access' => Yii::t('articles.message', 'Access'),
            'ordering' => Yii::t('articles.message', 'Ordering'),
            'hits' => Yii::t('articles.message', 'Hits'),
            'alias' => Yii::t('articles.message', 'Alias'),
            'metadesc' => Yii::t('articles.message', 'Metadesc'),
            'metakey' => Yii::t('articles.message', 'Metakey'),
            'robots' => Yii::t('articles.message', 'Robots'),
            'author' => Yii::t('articles.message', 'Author'),
            'copyright' => Yii::t('articles.message', 'Copyright'),
            'params' => Yii::t('articles.message', 'Params'),
            'language' => Yii::t('articles.message', 'Language'),
        ];
    }
	
	/**
     * fetch stored file name with complete path 
     * @return string
     */
    public function getFilePath() 
    {
        return isset($this->image) ? Yii::getAlias('@webroot')."/".Yii::$app->controller->module->itemImagePath. $this->image : null;
    }
	
	/**
     * fetch stored file url
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $file = isset($this->image) ? $this->image : 'default.jpg';
        return Yii::getAlias('@web')."/".Yii::$app->controller->module->itemImagePath . $file;
    }
	
	/**
    * Delete Image
    * @return mixed the uploaded image instance
    */
	public function deleteImage() 
	{
		$image   = Yii::getAlias('@webroot')."/".Yii::$app->controller->module->itemImagePath.$this->image;
		$imageS  = Yii::getAlias('@webroot')."/".Yii::$app->controller->module->itemThumbPath."small/".$this->image;
		$imageM  = Yii::getAlias('@webroot')."/".Yii::$app->controller->module->itemThumbPath."medium/".$this->image;
		$imageL  = Yii::getAlias('@webroot')."/".Yii::$app->controller->module->itemThumbPath."large/".$this->image;
		$imageXL = Yii::getAlias('@webroot')."/".Yii::$app->controller->module->itemThumbPath."extra/".$this->image;
		
		// check if image exists on server
        if (empty($image) || !file_exists($image)) {
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
	public function getCategoriesSelect2($id)
	{
		$sql = 'SELECT id,name FROM {{%article_categories}} WHERE published = 1 AND id !='.$id;
		$categories = Categories::findBySql($sql)->asArray()->all();
		
		$array[0] = \Yii::t('articles.message', 'No Category'); 
		
		foreach($categories as $category)
		{
			$array[$category['id']] = $category['name'];
		}
		
		return $array;
	}
	
	// Return Username by UserID
	public function getUsernameByUserID($id)
	{
		$sql      = 'SELECT username FROM {{%user}} WHERE id='.$id;
		$username = Items::findBySql($sql)->asArray()->one();
		
		return $username['username'];
	}
	
	// Return array for User Select2
	public function getUsersSelect2()
	{
		$sql   = 'SELECT id,username FROM {{%user}}';
		$users = Items::findBySql($sql)->asArray()->all();
		
		foreach($users as $user)
		{
			$array[$user['id']] = $user['username'];
		}
		
		return $array;
	}
	
	// Return array for Video Type
	public function getVideoTypeSelect2()
	{
		$videotype = [ "youtube" => "YouTube", "vimeo" => "Vimeo", "dailymotion" => "Dailymotion" ];

		return $videotype;
		
	}
	
	// Return Attachment
    public function getArticleAttachments()
    {
        return $this->hasMany(ArticleAttachments::className(), ['itemid' => 'id']);
    }

    // Return Category
    public function getCat()
    {
        return $this->hasOne(ArticleCategories::className(), ['id' => 'catid']);
    }
	
	// Return User
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
	
}
