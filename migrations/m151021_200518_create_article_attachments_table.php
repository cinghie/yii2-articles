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

class m151021_200518_create_article_attachments_table extends Migration
{

    public function up()
    {
        $this->createTable("{{%article_attachments}}", [
            "id" => $this->primaryKey(),
            "item_id" => $this->integer(11)->notNull(),
            "title" => $this->string(255)->notNull(),
            "alias" => $this->string(255)->notNull(),
            "titleAttribute" => $this->text(),
            "filename" => $this->string(255)->notNull(),
            "extension" => $this->string(12)->notNull(),
            "mimetype" => $this->string(255)->notNull(),
            "size" => $this->integer(32)->notNull(),
            "hits" => $this->integer(11)->notNull()->defaultValue(0),
        ], $this->tableOptions);

        // Add Index and Foreign Key
        $this->createIndex(
            "index_article_attachments_item_id",
            "{{%article_attachments}}",
            "item_id"
        );

        $this->addForeignKey(
            "fk_article_attachments_item_id",
            "{{%article_attachments}}", "item_id",
            "{{%article_items}}", "id"
        );
    }

    public function down()
    {
        $this->dropForeignKey("{{fk_article_attachments_item_id}}", "{{%article_attachments}}");
        $this->dropIndex("{{index_article_attachments_item_id}}", "{{%article_attachments}}");
        $this->dropTable("{{%article_attachments}}");
    }

}
