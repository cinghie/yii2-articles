<?php

namespace app\modules\articles\models;

use Yii;

/**
 * This is the model class for table "article_items".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $catid
 * @property integer $published
 * @property string $introtext
 * @property string $fulltext
 * @property string $image
 * @property string $image_caption
 * @property string $image_credits
 * @property string $video
 * @property string $video_caption
 * @property string $video_credits
 * @property string $created
 * @property integer $created_by
 * @property string $modified
 * @property integer $modified_by
 * @property integer $access
 * @property integer $ordering
 * @property string $hits
 * @property string $params
 * @property string $metadesc
 * @property string $metakey
 * @property string $language
 */
class Items extends \yii\db\ActiveRecord
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
            [['title', 'catid', 'created', 'modified', 'language'], 'required'],
            [['catid', 'published', 'created_by', 'modified_by', 'access', 'ordering', 'hits'], 'integer'],
            [['introtext', 'fulltext', 'image_caption', 'video', 'video_caption', 'params', 'metadesc', 'metakey'], 'string'],
            [['created', 'modified'], 'safe'],
            [['title', 'alias', 'image', 'image_credits', 'video_credits'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'catid' => Yii::t('app', 'Catid'),
            'published' => Yii::t('app', 'Published'),
            'introtext' => Yii::t('app', 'Introtext'),
            'fulltext' => Yii::t('app', 'Fulltext'),
            'image' => Yii::t('app', 'Image'),
            'image_caption' => Yii::t('app', 'Image Caption'),
            'image_credits' => Yii::t('app', 'Image Credits'),
            'video' => Yii::t('app', 'Video'),
            'video_caption' => Yii::t('app', 'Video Caption'),
            'video_credits' => Yii::t('app', 'Video Credits'),
            'created' => Yii::t('app', 'Created'),
            'created_by' => Yii::t('app', 'Created By'),
            'modified' => Yii::t('app', 'Modified'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'access' => Yii::t('app', 'Access'),
            'ordering' => Yii::t('app', 'Ordering'),
            'hits' => Yii::t('app', 'Hits'),
            'params' => Yii::t('app', 'Params'),
            'metadesc' => Yii::t('app', 'Metadesc'),
            'metakey' => Yii::t('app', 'Metakey'),
            'language' => Yii::t('app', 'Language'),
        ];
    }
}
