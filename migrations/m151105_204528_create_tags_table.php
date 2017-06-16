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

class m151105_204528_create_tags_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%article_tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'alias' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'state' => $this->boolean()->notNull()->defaultValue(0),
        ], $this->tableOptions);

        $this->createTable('{{%article_tags_assign}}', [
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer(11)->notNull()->defaultValue(0),
            'item_id' => $this->integer(11)->notNull()->defaultValue(0),
        ], $this->tableOptions);

        // Auth Item Permissions
        $this->insert('{{%auth_item}}',['name' => 'articles-create-tags', 'type' => '2', 'description' => 'Can create tags','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-update-tags', 'type' => '2', 'description' => 'Can update tags','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-delete-tags', 'type' => '2', 'description' => 'Can delete tags','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-publish-tags', 'type' => '2', 'description' => 'Can publish tags','created_at' => time(),'updated_at' => time()]);

        // Auth Item Child Admin Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-create-tags']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-delete-tags']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-publish-tags']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-update-tags']);

        // Auth Item Child Admin Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-create-tags']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-delete-tags']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-publish-tags']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-update-tags']);

        // Auth Item Child Admin Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'articles-create-tags']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'articles-publish-tags']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'articles-update-tags']);

        // Auth Item Child Admin Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'articles-create-tags']);
    }

    public function down()
    {
        $this->dropTable('{{%article_tags}}');
        $this->dropTable('{{%article_tags_assign}}');
    }
}
