<?php

namespace app\modules\articles\models;

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
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'alias' => Yii::t('app', 'Alias'),
            'description' => Yii::t('app', 'Description'),
            'parent' => Yii::t('app', 'Parent'),
            'published' => Yii::t('app', 'Published'),
            'access' => Yii::t('app', 'Access'),
            'ordering' => Yii::t('app', 'Ordering'),
            'image' => Yii::t('app', 'Image'),
            'image_caption' => Yii::t('app', 'Image Caption'),
            'image_credits' => Yii::t('app', 'Image Credits'),
            'params' => Yii::t('app', 'Params'),
            'metadesc' => Yii::t('app', 'Metadesc'),
            'metakey' => Yii::t('app', 'Metakey'),
            'robots' => Yii::t('app', 'Robots'),
            'author' => Yii::t('app', 'Author'),
            'copyright' => Yii::t('app', 'Copyright'),
            'language' => Yii::t('app', 'Language'),
        ];
    }
}
