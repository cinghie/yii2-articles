<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.4.0
 */

use yii\db\Migration;

class m151105_204428_insert_article_auth extends Migration
{
    public function safeUp()
    {
        // Auth Item
        $this->insert('{{%auth_item}}',['name' => 'admin','type' => '1','description' => 'Can create, publish all, update all, delete all, view and admin grid articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'editor','type' => '1','description' => 'Can create, publish his article, update all articles, delete his articles, view and admin grid articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'author','type' => '1','description' => 'Can create and update his articles and view','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'create-articles', 'type' => '1', 'description' => 'Can create articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'create-categories', 'type' => '1', 'description' => 'Can create categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'delete-articles', 'type' => '1', 'description' => 'Can delete articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'delete-categories', 'type' => '1', 'description' => 'Can delete categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'index-articles', 'type' => '1', 'description' => 'Can view articles admin grid','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'index-categories', 'type' => '1', 'description' => 'Can view categories admin grid','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'publish-articles', 'type' => '1', 'description' => 'Can publish articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'publish-categories', 'type' => '1', 'description' => 'Can publish categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'update-articles', 'type' => '1', 'description' => 'Can update articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'update-categories', 'type' => '1', 'description' => 'Can update categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'view-articles', 'type' => '1', 'description' => 'Can view articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'view-categories', 'type' => '1', 'description' => 'Can view categories','created_at' => time(),'updated_at' => time()]);

        // Auth Item Child Admin
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'create-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'create-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'delete-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'delete-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'index-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'index-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'publish-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'publish-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'update-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'update-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'view-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'view-articles']);

        // Auth Item Child Editor
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'create-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'delete-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'index-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'publish-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'update-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'view-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'view-articles']);

        // Auth Item Child Author
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'create-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'update-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'view-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'view-articles']);
    }

    public function safeDown()
    {
        // Auth Item
        $this->delete('{{%auth_item}}', ['name' => 'admin']);
        $this->delete('{{%auth_item}}', ['name' => 'editor']);
        $this->delete('{{%auth_item}}', ['name' => 'author']);
        $this->delete('{{%auth_item}}', ['name' => 'create-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'create-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'delete-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'delete-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'index-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'index-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'publish-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'publish-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'update-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'update-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'view-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'view-categories']);

        // Auth Item Child
        $this->delete('{{%auth_item_child}}', ['parent' => 'admin']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'editor']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'author']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'create-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'create-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'delete-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'delete-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'index-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'index-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'publish-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'publish-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'update-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'update-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'view-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'view-categories']);
    }

}
