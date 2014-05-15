<?php

/**
 * @copyright Copyright &copy;2014 Giandomenico Olini
 * @company Gogodigital - Wide ICT Solutions 
 * @website http://www.gogodigital.it
 * @package yii2-articles
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 */

namespace cinghie\articles\models;

use Yii;

class Categories extends \yii\db\ActiveRecord
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
            [['description', 'image_caption', 'params', 'metadesc', 'metakey'], 'string'],
            [['parent', 'published', 'access', 'ordering'], 'integer'],
            [['name', 'alias', 'image', 'image_credits'], 'string', 'max' => 255],
			[['image'], 'safe'],
	        [['image'], 'file', 'types' => Yii::$app->controller->module->categoryimagetype],
            [['robots'], 'string', 'max' => 20],
            [['author', 'copyright'], 'string', 'max' => 50],
            [['language'], 'string', 'max' => 7]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('articles.message', 'ID'),
            'name' => Yii::t('articles.message', 'Name'),
            'alias' => Yii::t('articles.message', 'Alias'),
            'description' => Yii::t('articles.message', 'Description'),
            'parent' => Yii::t('articles.message', 'Parent'),
            'published' => Yii::t('articles.message', 'Published'),
            'access' => Yii::t('articles.message', 'Access'),
            'ordering' => Yii::t('articles.message', 'Ordering'),
            'image' => Yii::t('articles.message', 'Image'),
            'image_caption' => Yii::t('articles.message', 'Image Caption'),
            'image_credits' => Yii::t('articles.message', 'Image Credits'),
            'params' => Yii::t('articles.message', 'Params'),
            'metadesc' => Yii::t('articles.message', 'Metadesc'),
            'metakey' => Yii::t('articles.message', 'Metakey'),
            'robots' => Yii::t('articles.message', 'Robots'),
            'author' => Yii::t('articles.message', 'Author'),
            'copyright' => Yii::t('articles.message', 'Copyright'),
            'language' => Yii::t('articles.message', 'Language'),
        ];
    }
	
	// Return array for Category Select2
	public function getCategoriesSelect2($id)
	{
		$sql = 'SELECT id,name FROM {{%article_categories}} WHERE published = 1 AND id !='.$id;
		$categories = Categories::findBySql($sql)->asArray()->all();
		
		$array[0] = \Yii::t('articles.message', 'No Parent'); 
		
		foreach($categories as $category)
		{
			$array[$category['id']] = $category['name'];
		}
		
		return $array;
	}
	
	// Return Image Category from Database
	public function getCategoriesimage($id)
	{
		$sql = 'SELECT image FROM {{%article_categories}} WHERE id ='.$id;
		$image = Categories::findBySql($sql)->asArray()->one();
		
		return $image['image'];
	}
	
	// Delete Image From Category
	public function deleteImage() {
		$image = Yii::getAlias('@webroot')."/".Yii::$app->controller->module->categoryimagepath.$this->image;
		
		if (unlink($image)) {
			$this->image = "";
			$this->save();
			return true;
		}
		
		return false;
	}
	
}
