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

class m151105_204528_create_tags_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%article_tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'alias' => $this->string(255)->notNull(),
            'description' => $this->text(),
        ], $this->tableOptions);

        $this->createTable('{{%article_tags_assign}}', [
            'id' => $this->primaryKey(),
            'tagid' => $this->integer(11)->notNull()->defaultValue(0),
            'itemid' => $this->integer(11)->notNull()->defaultValue(0),
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%article_tags}}');
        $this->dropTable('{{%article_tags_assign}}');
    }
}
