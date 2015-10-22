<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions 
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.2.7
 */

use cinghie\articles\migrations\Migration;
use yii\db\Schema;

class m151021_200518_create_article_attachments_table extends Migration
{

    public function up()
    {
        $this->createTable('{{%article_attachments}}', [
            'id' => Schema::TYPE_PK,
            'itemid' => 'int(11) NOT NULL',
            'filename' => Schema::TYPE_STRING . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'titleAttribute' => Schema::TYPE_TEXT,
            'hits' => 'int(11) NOT NULL',
        ], $this->tableOptions);

        $this->addForeignKey('fk_attachment_article', '{{%article_attachments}}', 'itemid', '{{%article_items}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%article_attachments}}');
    }

}
