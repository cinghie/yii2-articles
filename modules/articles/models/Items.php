<?php

namespace app\modules\articles\models;

use Yii;

/**
 * This is the model class for table "article_items".
 *
 * @property integer $id
 * @property string $title
 * @property integer $catid
 * @property integer $userid
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
 * @property string $alias
 * @property string $metadesc
 * @property string $metakey
 * @property string $robots
 * @property string $author
 * @property string $copyright
 * @property string $params
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
            [['title', 'catid', 'userid', 'created', 'modified', 'language'], 'required'],
            [['catid', 'userid', 'published', 'created_by', 'modified_by', 'access', 'ordering', 'hits'], 'integer'],
            [['introtext', 'fulltext', 'image_caption', 'video', 'video_caption', 'metadesc', 'metakey', 'params'], 'string'],
            [['created', 'modified'], 'safe'],
            [['title', 'image', 'image_credits', 'video_credits', 'alias'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'Title'),
            'catid' => Yii::t('app', 'Catid'),
            'userid' => Yii::t('app', 'Userid'),
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
            'alias' => Yii::t('app', 'Alias'),
            'metadesc' => Yii::t('app', 'Metadesc'),
            'metakey' => Yii::t('app', 'Metakey'),
            'robots' => Yii::t('app', 'Robots'),
            'author' => Yii::t('app', 'Author'),
            'copyright' => Yii::t('app', 'Copyright'),
            'params' => Yii::t('app', 'Params'),
            'language' => Yii::t('app', 'Language'),
        ];
    }
}
