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

/**
 * Class m180619_200132_create_article_items_nested_sets
 */
class m180619_200132_add_to_article_items_nested_sets extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->addColumn('{{%article_items}}', 'tree', $this->integer()->notNull().' AFTER theme');
	    $this->addColumn('{{%article_items}}', 'lft', $this->integer()->notNull().' AFTER tree');
	    $this->addColumn('{{%article_items}}', 'rgt', $this->integer()->notNull().' AFTER lft');
	    $this->addColumn('{{%article_items}}', 'depth', $this->integer()->notNull().' AFTER rgt');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%article_items}}','tree');
        $this->dropColumn('{{%article_items}}','lft');
        $this->dropColumn('{{%article_items}}','rgt');
        $this->dropColumn('{{%article_items}}','depth');
    }

}
