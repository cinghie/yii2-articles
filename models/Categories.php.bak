<?php

namespace cinghie\articles\models;

use Yii;

/**
 * This is the model class for table "article_categories".
 *
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $description
 * @property integer $parent
 * @property integer $published
 * @property integer $access
 * @property integer $ordering
 * @property string $image
 * @property string $image_caption
 * @property string $image_credits
 * @property string $params
 * @property string $metadesc
 * @property string $metakey
 * @property string $robots
 * @property string $author
 * @property string $copyright
 * @property string $language
 */
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
            [['name', 'alias', 'language'], 'required'],
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
	
}
