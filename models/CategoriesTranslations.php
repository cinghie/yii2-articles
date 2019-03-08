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
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%article_categories_translations}}".
 *
 * @property int $id
 * @property int $cat_id
 * @property int $translation_id
 * @property string $lang
 * @property string $lang_tag
 *
 * @property Categories $item
 * @property Categories $translation
 */
class CategoriesTranslations extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%article_categories_translations}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['cat_id', 'translation_id'], 'integer'],
			[['lang', 'lang_tag'], 'required'],
			[['lang'], 'string', 'max' => 3],
			[['lang_tag'], 'string', 'max' => 5],
			[['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['cat_id' => 'id']],
			[['translation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['translation_id' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('traits', 'ID'),
			'cat_id' => Yii::t('articles', 'Category'),
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
		return $this->hasOne(Categories::class, ['id' => 'cat_id']);
	}

	/**
	 * @return ActiveQuery
	 */
	public function getTranslation()
	{
		return $this->hasOne(Categories::class, ['id' => 'translation_id']);
	}

	/**
	 * @inheritdoc
	 *
	 * @return CategoriesTranslationsQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new CategoriesTranslationsQuery( static::class );
	}

}
