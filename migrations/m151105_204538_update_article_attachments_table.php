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

class m151105_204538_update_article_attachments_table extends Migration
{

    public function up()
    {
        $this->addColumn(
            '{{%article_attachments}}',
            'extension',
            $this->string()->notNull()
        );

        $this->addColumn(
            '{{%article_attachments}}',
            'mimetype',
            $this->string(255)->notNull()
        );

        $this->addColumn(
            '{{%article_attachments}}',
            'size',
            $this->integer()->notNull()
        );
    }

    public function down()
    {
        $this->dropColumn('{{%article_attachments}}','extension');
        $this->dropColumn('{{%article_attachments}}','mimetype');
        $this->dropColumn('{{%article_attachments}}','size');
    }

}
