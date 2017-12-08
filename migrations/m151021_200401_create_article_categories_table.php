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

class m151021_200401_create_article_categories_table extends Migration
{

    public function up()
    {
        $this->createTable("{{%article_categories}}", [
            "id" => $this->primaryKey(),
            "parent_id" => $this->integer(11)->defaultValue(null),
            "name" => $this->string(255)->notNull(),
            "alias" => $this->string(255)->notNull(),
            "description" => $this->text(),
            "state" => $this->boolean()->notNull()->defaultValue(1),
            "access" => $this->string(64)->notNull(),
            "language" => $this->char(7)->notNull()->defaultValue("all"),
            "theme" => $this->string(12)->notNull()->defaultValue("blog"),
            "ordering" => $this->integer(11)->notNull()->defaultValue(0),
            "image" => $this->text(),
            "image_caption" => $this->string(255),
            "image_credits" => $this->string(255),
            "params" => $this->text(),
            "metadesc" => $this->text(),
            "metakey" => $this->text(),
            "robots" => $this->string(20),
            "author" => $this->string(50),
            "copyright" => $this->string(50),
        ], $this->tableOptions);

        // Add Index and Foreign Key access
        $this->createIndex(
            "index_article_categories_access",
            "{{%article_categories}}",
            "access"
        );
        
        // Add Index and Foreign Key parent_id
        $this->createIndex(
            "index_article_categories_parent_id",
            "{{%article_categories}}",
            "parent_id"
        );

        $this->addForeignKey("fk_article_categories_parent_id",
            "{{%article_categories}}", "parent_id",
            "{{%article_categories}}", "id",
            "SET NULL", "CASCADE"
        );
    }

    public function down()
    {
        $this->dropForeignKey("fk_article_categories_parent_id", "{{%article_categories}}");
        $this->dropIndex("index_article_categories_access", "{{%article_categories}}");
        $this->dropIndex("index_article_categories_parent_id", "{{%article_categories}}");
        $this->dropTable("{{%article_categories}}");
    }

}
