<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions 
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.1
 */

use cinghie\articles\migrations\Migration;
use yii\db\Schema;

class m151021_200427_create_article_items_table extends Migration
{

    public function up()
    {
        $this->createTable('{{%article_items}}', [
            'id' => Schema::TYPE_PK,
            'title' => 'varchar(255) NOT NULL',
            'alias' => 'varchar(255) DEFAULT NULL',
            'catid' => 'int(11) NOT NULL',
            'userid' => 'int(11) NOT NULL',
            'introtext' => 'text',
            'fulltext' => 'text',
            'state' => 'tinyint(1) NOT NULL DEFAULT 0',
            'access' => 'varchar(64) NOT NULL',
            'language' => 'char(7) NOT NULL',
            'ordering' => 'int(11) NOT NULL DEFAULT 0',
            'hits' => 'int(10) unsigned NOT NULL DEFAULT 0',
            'image' => 'text',
            'image_caption' => 'varchar(255) DEFAULT NULL',
            'image_credits' => 'varchar(255) DEFAULT NULL',
            'video' => 'text',
            'video_type' => 'varchar(20) DEFAULT NULL',
            'video_caption' => 'varchar(255) DEFAULT NULL',
            'video_credits' => 'varchar(255) DEFAULT NULL',
            'created' => 'datetime NOT NULL',
            'created_by' => 'int(11) NOT NULL DEFAULT 0',
            'modified' => 'datetime NOT NULL',
            'modified_by' => 'int(11) NOT NULL DEFAULT 0',
            'params' => 'text',
            'metadesc' => 'text',
            'metakey' => 'text',
            'robots' => 'varchar(20) DEFAULT NULL',
            'author' => 'varchar(50) DEFAULT NULL',
            'copyright' => 'varchar(50) DEFAULT NULL',
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%article_items}}');
    }

}
