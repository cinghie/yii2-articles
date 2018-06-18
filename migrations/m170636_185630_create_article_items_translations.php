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

use cinghie\traits\migrations\Migration;

class m170636_185630_create_article_items_translations extends Migration
{
	/**
	 * @inheritdoc
	 */
	public function safeUp()
	{
		$this->createTable('{{%article_items_translations}}', [
			'id' => $this->primaryKey(),
			'item_id' => $this->integer(11)->defaultValue(null),
			'translation_id' => $this->integer(11)->defaultValue(null),
			'lang' => $this->string(3)->notNull(),
			'lang_tag' => $this->string(5)->notNull(),
		], $this->tableOptions);

		// Add Index and Foreign Key item_id
		$this->createIndex(
			'index_article_items_translations_item_id',
			'{{%article_items_translations}}',
			'item_id'
		);

		$this->addForeignKey('fk_article_items_translations_item_id',
			'{{%article_items_translations}}', 'item_id',
			'{{%article_items}}', 'id',
			'SET NULL', 'CASCADE'
		);

		// Add Index and Foreign Key translation_id
		$this->createIndex(
			'index_article_items_translations_translation_id',
			'{{%article_items_translations}}',
			'translation_id'
		);

		$this->addForeignKey('fk_article_items_translations_translation_id',
			'{{%article_items_translations}}', 'translation_id',
			'{{%article_items}}', 'id',
			'SET NULL', 'CASCADE'
		);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown()
	{
		$this->dropForeignKey('fk_article_items_translations_translation_id', '{{%article_items_translations}}');
		$this->dropForeignKey('fk_article_items_translations_item_id', '{{%article_items_translations}}');
		$this->dropIndex('index_article_items_translations_translation_id', '{{%article_items_translations}}');
		$this->dropIndex('index_article_items_translations_item_id', '{{%article_items_translations}}');
		$this->dropTable('{{%article_items_translations}}');
	}

}
