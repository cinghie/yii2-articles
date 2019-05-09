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
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%article_items_translations}}".
 *
 * @property int $id
 * @property int $item_id
 * @property int $translation_id
 * @property string $lang
 * @property string $lang_tag
 *
 * @property Items $item
 * @property Items $translation
 */
class Translations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_items_translations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'translation_id'], 'integer'],
            [['lang', 'lang_tag'], 'required'],
            [['lang'], 'string', 'max' => 3],
            [['lang_tag'], 'string', 'max' => 5],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::class, 'targetAttribute' => ['item_id' => 'id']],
            [['translation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::class, 'targetAttribute' => ['translation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('traits', 'ID'),
            'item_id' => Yii::t('articles', 'Item'),
            'translation_id' => Yii::t('traits', 'Translation'),
            'lang' => Yii::t('traits', 'Language'),
            'lang_tag' => Yii::t('traits', 'Language Tag'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::class, ['id' => 'item_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslation()
    {
        return $this->hasOne(Items::class, ['id' => 'translation_id']);
    }

    /**
     * @inheritdoc
     *
     * @return TranslationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TranslationsQuery( static::class );
    }

}
