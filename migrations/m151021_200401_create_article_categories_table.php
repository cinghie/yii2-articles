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

class m151021_200401_create_article_categories_table extends Migration
{

    public function up()
    {
        $this->createTable('{{%article_categories}}', [
            'id' => Schema::TYPE_PK,
            'name' => 'varchar(255) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'description' => 'text',
            'parentid' => 'int(11) DEFAULT 0',
            'state' => 'tinyint(1) NOT NULL DEFAULT 0',
            'access' => 'varchar(64) NOT NULL',
            'language' => 'char(7) NOT NULL',
            'ordering' => 'int(11) NOT NULL DEFAULT 0',
            'image' => 'text',
            'image_caption' => 'varchar(255) DEFAULT NULL',
            'image_credits' => 'varchar(255) DEFAULT NULL',
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
        $this->dropTable('{{%article_categories}}');
    }

}
