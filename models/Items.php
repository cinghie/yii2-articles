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
use yii\helpers\Url;

class Items extends Articles
{
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
        return [
            [['title', 'catid', 'userid', 'created', 'modified', 'language'], 'required'],
            [['catid', 'userid', 'state', 'created_by', 'modified_by', 'ordering', 'hits'], 'integer'],
            [['introtext', 'fulltext', 'access', 'image_caption', 'video_caption', 'metadesc', 'metakey', 'params'], 'string'],
			[['title', 'alias', 'image_caption', 'image_credits', 'video_caption', 'video_credits'], 'string', 'max' => 255],
            [['access'], 'string', 'max' => 64],
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
            'id' => Yii::t('articles', 'ID'),
            'title' => Yii::t('articles', 'Title'),
            'catid' => Yii::t('articles', 'Catid'),
            'userid' => Yii::t('articles', 'Userid'),
            'state' => Yii::t('articles', 'State'),
            'introtext' => Yii::t('articles', 'Introtext'),
            'fulltext' => Yii::t('articles', 'Fulltext'),
            'image' => Yii::t('articles', 'Image'),
            'image_caption' => Yii::t('articles', 'Image Caption'),
            'image_credits' => Yii::t('articles', 'Image Credits'),
            'video' => Yii::t('articles', 'Video ID'),
			'video_type' => Yii::t('articles', 'Video Type'),
            'video_caption' => Yii::t('articles', 'Video Caption'),
            'video_credits' => Yii::t('articles', 'Video Credits'),
            'created' => Yii::t('articles', 'Created'),
            'created_by' => Yii::t('articles', 'Created By'),
            'modified' => Yii::t('articles', 'Modified'),
            'modified_by' => Yii::t('articles', 'Modified By'),
            'access' => Yii::t('articles', 'Access'),
            'ordering' => Yii::t('articles', 'Ordering'),
            'hits' => Yii::t('articles', 'Hits'),
            'alias' => Yii::t('articles', 'Alias'),
            'metadesc' => Yii::t('articles', 'Metadesc'),
            'metakey' => Yii::t('articles', 'Metakey'),
            'robots' => Yii::t('articles', 'Robots'),
            'author' => Yii::t('articles', 'Author'),
            'copyright' => Yii::t('articles', 'Copyright'),
            'params' => Yii::t('articles', 'Params'),
            'language' => Yii::t('articles', 'Language'),
        ];
    }

    /**
     * check if current user is the author from the article id
     * @return bool
     */
    public function isUserAuthor()
    {
        if ( Yii::$app->user->identity->id == $this->created_by ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * return item url
     * @return string
     */
    public function getItemUrl() {
        return Url::to(['/articles/items/view', 'id' => $this->id, 'alias' => $this->alias, 'cat' => $this->category->alias]);
    }

	/**
     * fetch stored file name with complete path 
     * @return string
     */
    public function getFilePath() {
        return isset($this->image) ? Yii::getAlias(Yii::$app->controller->module->itemImagePath).$this->image : null;
    }
	
	/**
     * fetch stored file url
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $file = isset($this->image) ? $this->image : 'default.jpg';
        return Yii::getAlias(Yii::$app->controller->module->itemImageURL).$file;
    }

    /**
     * fetch stored image url
     * @param $size
     * @return string
     */
    public function getImageThumbUrl($size)
    {
        // return a default image placeholder if your source avatar is not found
        $file = isset($this->image) ? $this->image : 'default.jpg';
        return Yii::getAlias(Yii::$app->controller->module->itemImageURL)."thumb/".$size."/".$file;
    }
	
	/**
    * Delete Image
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
	
	/**
     * Return array for Category Select2
     * @return array
     **/
	public function getCategoriesSelect2()
	{
        $categories = Categories::find()
            ->select(['id','name'])
            ->where(['state' => 1])
            ->all();

		$array[0] = Yii::t('articles', 'No Category');
		
		foreach($categories as $category) {
			$array[$category['id']] = $category['name'];
		}
		
		return $array;
	}

    /*
     * Return array for Video Type
     * @return array
     */
	public function getVideoTypeSelect2()
	{
		$videotype = [ "youtube" => "YouTube", "vimeo" => "Vimeo", "dailymotion" => "Dailymotion" ];

		return $videotype;
	}

    /**
     * Return Attachments
     * @return Attachments
     */
    public function getAttachments() {
        return $this->hasMany(Attachments::className(), ['itemid' => 'id'])->from(Attachments::tableName() . ' AS attach');
    }

    /**
     * Return Categories
     * @return Categories
     */
    public function getCategory() {
        return $this->hasOne(Categories::className(), ['id' => 'catid'])->from(Categories::tableName() . ' AS category');
    }

    /**
     * Return User
     * @return $this
     */
    public function getUser() {
        $userClass = Yii::$app->controller->module->userClass;
        $user = Yii::$container->get($userClass);
        return $this->hasOne($userClass, ['id' => 'userid'])->from($user::tableName() . ' AS user');
    }

    /**
     * Return Created_By
     * @return $this
     */
    public function getCreatedby() {
        $userClass = Yii::$app->controller->module->userClass;
        $user = Yii::$container->get($userClass);
        return $this->hasOne($userClass, ['id' => 'created_by'])->from($user::tableName() . ' AS createdby');
    }

    /**
     * Return Tags
     * @return $this
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])
            ->viaTable(Tagsassign::className(), ['item_id' => 'id']);
    }

    /**
     * Return Modified_By
     * @return $this
     */
    public function getModifiedby() {
        $userClass = Yii::$app->controller->module->userClass;
        $user = Yii::$container->get($userClass);
        return $this->hasOne($userClass, ['id' => 'modified_by'])->from($user::tableName() . ' AS modifiedby');
    }

    /*
     * Return a date formatted with default format
     * @return string
     */
    public function getDateFormatted($date) {
        return Yii::$app->formatter->asDatetime($date, "php:".Yii::$app->controller->module->dateFormat);
    }
	
}
