<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.3
 */

use cinghie\traits\migrations\Migration;

class m151105_204548_update_tags_table extends Migration
{

    public function up()
    {
        // Add Index and Foreign Key
        $this->createIndex("index_article_tags_tag_id","{{%article_tags_assign}}", "tag_id" );
        $this->addForeignKey("fk_article_tags_tag_id", '{{%article_tags_assign}}', "tag_id", '{{%article_tags_assign}}', "id");

        // Add Index and Foreign Key
        $this->createIndex("index_article_tags_item_id","{{%article_tags_assign}}", "item_id" );
        $this->addForeignKey("fk_article_tags_item_id", '{{%article_tags_assign}}', "item_id", '{{%article_items}}', "id");
    }

}
