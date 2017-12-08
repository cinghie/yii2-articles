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

class m151021_200427_create_article_items_table extends Migration
{

    public function up()
    {
        $this->createTable("{{%article_items}}", [
            "id" => $this->primaryKey(),
            "cat_id" => $this->integer(11)->defaultValue(null),
            "title" => $this->string(255)->notNull(),
            "alias" => $this->string(255)->notNull(),
            "introtext" => $this->text(),
            "fulltext" => $this->text(),
            "state" => $this->boolean()->notNull()->defaultValue(0),
            "access" => $this->string(64)->notNull(),
            "language" => $this->char(7)->notNull(),
            "theme" => $this->string(12)->notNull()->defaultValue("blog"),
            "ordering" => $this->integer(11)->notNull()->defaultValue(0),
            "hits" => $this->integer(11)->notNull()->defaultValue(0),
            "image" => $this->text(),
            "image_caption" => $this->string(255),
            "image_credits" => $this->string(255),
            "video" => $this->text(),
            "video_type" => $this->string(20)->defaultValue(null),
            "video_caption" => $this->string(255)->defaultValue(null),
            "video_credits" => $this->string(255)->defaultValue(null),
            "params" => $this->text(),
            "metadesc" => $this->text(),
            "metakey" => $this->text(),
            "robots" => $this->string(20)->defaultValue(null),
            "author" => $this->string(50)->defaultValue(null),
            "copyright" => $this->string(50)->defaultValue(null),
            "user_id" => $this->integer(11)->defaultValue(null),
            "created_by" => $this->integer(11)->defaultValue(null),
            "created" => $this->dateTime()->notNull()->defaultValue("0000-00-00 00:00:00"),
            "modified_by" => $this->integer(11)->defaultValue(null),
            "modified" => $this->dateTime()->notNull()->defaultValue("0000-00-00 00:00:00"),
        ], $this->tableOptions);

        // Add Index and Foreign Key access
        $this->createIndex(
            "index_article_items_access",
            "{{%article_items}}",
            "access"
        );

        // Add Index and Foreign Key cat_id
        $this->createIndex(
            "index_article_items_cat_id",
            "{{%article_items}}",
            "cat_id"
        );

        $this->addForeignKey("fk_article_items_cat_id",
            "{{%article_items}}", "cat_id",
            "{{%article_categories}}", "id",
            "SET NULL", "CASCADE"
        );

        // Add Index and Foreign Key user_id
        $this->createIndex(
            "index_article_items_user_id",
            "{{%article_items}}",
            "user_id"
        );
        $this->addForeignKey(
            "fk_article_items_user_id",
            "{{%article_items}}", "user_id",
            "{{%user}}", "id",
            "SET NULL", "CASCADE"
        );

        // Add Index and Foreign Key created_by
        $this->createIndex(
            "index_article_items_created_by",
            "{{%article_items}}",
            "created_by"
        );

        $this->addForeignKey("fk_article_items_created_by",
            "{{%article_items}}", "created_by",
            "{{%user}}", "id",
            "SET NULL", "CASCADE"
        );

        // Add Index and Foreign Key modified_by
        $this->createIndex(
            "index_article_items_modified_by",
            "{{%article_items}}",
            "modified_by"
        );

        $this->addForeignKey(
            "fk_article_items_modified_by",
            "{{%article_items}}", "modified_by",
            "{{%user}}", "id",
            "SET NULL", "CASCADE"
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_article_items_user_id', '{{%article_items}}');
        $this->dropForeignKey("fk_article_items_created_by", "{{%article_items}}");
        $this->dropForeignKey("fk_article_items_modified_by", "{{%article_items}}");
        $this->dropIndex('index_article_items_user_id', '{{%article_items}}');
        $this->dropIndex("index_article_items_access", "{{%article_items}}");
        $this->dropIndex("index_article_items_created_by", "{{%article_items}}");
        $this->dropIndex("index_article_items_modified_by", "{{%article_items}}");
        $this->dropTable("{{%article_items}}");
    }

}
