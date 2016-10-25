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

use cinghie\articles\migrations\Migration;
use yii\db\Schema;

class m151021_200427_create_article_items_table extends Migration
{

    public function up()
    {
        $this->createTable('{{%article_items}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'alias' => $this->string(255)->notNull(),
            'catid' => $this->integer(11)->notNull()->defaultValue(0),
            'userid' => $this->integer(11)->notNull()->defaultValue(0),
            'introtext' => $this->text(),
            'fulltext' => $this->text(),
            'state' => $this->boolean()->notNull()->defaultValue(0),
            'access' => $this->string(64)->notNull(),
            'language' => $this->char(7)->notNull(),
            'theme' => $this->string(12)->notNull()->defaultValue('blog'),
            'ordering' => $this->integer(11)->notNull()->defaultValue(0),
            'hits' => $this->integer(11)->notNull()->defaultValue(0),
            'image' => $this->text(),
            'image_caption' => $this->string(255),
            'image_credits' => $this->string(255),
            'video' => $this->text(),
            'video_type' => $this->string(20)->defaultValue(null),
            'video_caption' => $this->string(255)->defaultValue(null),
            'video_credits' => $this->string(255)->defaultValue(null),
            'created' => $this->dateTime()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'created_by' => $this->integer(11)->notNull()->defaultValue(0),
            'modified' => $this->dateTime()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'modified_by' => $this->integer(11)->notNull()->defaultValue(0),
            'params' => $this->text(),
            'metadesc' => $this->text(),
            'metakey' => $this->text(),
            'robots' => $this->string(20)->defaultValue(null),
            'author' => $this->string(50)->defaultValue(null),
            'copyright' => $this->string(50)->defaultValue(null)
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%article_items}}');
    }

}
