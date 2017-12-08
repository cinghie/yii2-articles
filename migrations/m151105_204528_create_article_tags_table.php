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

class m151105_204528_create_article_tags_table extends Migration
{
    public function up()
    {
        $this->createTable("{{%article_tags}}", [
            "id" => $this->primaryKey(),
            "name" => $this->string(255)->notNull(),
            "alias" => $this->string(255)->notNull(),
            "description" => $this->text(),
            "state" => $this->boolean()->notNull()->defaultValue(0),
        ], $this->tableOptions);

        $this->createTable("{{%article_tags_assign}}", [
            "id" => $this->primaryKey(),
            "tag_id" => $this->integer(11)->notNull()->defaultValue(0),
            "item_id" => $this->integer(11)->notNull()->defaultValue(0),
        ], $this->tableOptions);

        // Add Index and Foreign Key
        $this->createIndex(
            "index_article_tags_assign_tag_id",
            "{{%article_tags_assign}}",
            "tag_id"
        );

        $this->addForeignKey(
            "fk_article_tags_assign_tag_id",
            "{{%article_tags_assign}}", "tag_id",
            "{{%article_tags}}", "id"
        );

        // Add Index and Foreign Key
        $this->createIndex(
            "index_article_tags_assign_item_id",
            "{{%article_tags_assign}}",
            "item_id"
        );

        $this->addForeignKey(
            "fk_article_tags_assign_item_id",
            "{{%article_tags_assign}}", "item_id",
            "{{%article_items}}", "id"
        );
    }

    public function down()
    {
        $this->dropForeignKey("{{fk_article_tags_assign_tag_id}}", "{{%article_tags_assign}}");
        $this->dropForeignKey("{{fk_article_tags_assign_item_id}}", "{{%article_tags_assign}}");
        $this->dropIndex("{{index_article_tags_assign_item_id}}", "{{%article_tags_assign}}");
        $this->dropIndex("{{index_article_tags_assign_tag_id}}", "{{%article_tags_assign}}");
        $this->dropTable("{{%article_tags_assign}}");
        $this->dropTable("{{%article_tags}}");
    }

}
