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
        $this->insert('{{%auth_item}}',['name' => 'editor','type' => '1','description' => 'Can create, publish all articles, update all articles, delete his articles, view and admin grid articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'publisher','type' => '1','description' => 'Can create, publish his articles, update all articles, view and admin grid his articles','created_at' => time(),'updated_at' => time()]);
		$this->insert('{{%auth_item}}',['name' => 'author','type' => '1','description' => 'Can create and update his articles and view','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'create-articles', 'type' => '1', 'description' => 'Can create articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'create-categories', 'type' => '1', 'description' => 'Can create categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'delete-all-articles', 'type' => '1', 'description' => 'Can delete all articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'delete-his-articles', 'type' => '1', 'description' => 'Can delete his articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'delete-all-categories', 'type' => '1', 'description' => 'Can delete all categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'delete-his-categories', 'type' => '1', 'description' => 'Can delete his categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'index-all-articles', 'type' => '1', 'description' => 'Can view all articles admin grid','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'index-his-articles', 'type' => '1', 'description' => 'Can view his articles admin grid','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'index-categories', 'type' => '1', 'description' => 'Can view categories admin grid','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'publish-all-articles', 'type' => '1', 'description' => 'Can publish all articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'publish-his-articles', 'type' => '1', 'description' => 'Can publish his articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'publish-categories', 'type' => '1', 'description' => 'Can publish categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'update-all-articles', 'type' => '1', 'description' => 'Can update all articles','created_at' => time(),'updated_at' => time()]);
		$this->insert('{{%auth_item}}',['name' => 'update-his-articles', 'type' => '1', 'description' => 'Can update his articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'update-all-categories', 'type' => '1', 'description' => 'Can update all categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'update-his-categories', 'type' => '1', 'description' => 'Can update his categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'view-articles', 'type' => '1', 'description' => 'Can view articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'view-categories', 'type' => '1', 'description' => 'Can view categories','created_at' => time(),'updated_at' => time()]);

        // Auth Item Child Admin Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'create-articles']);
		$this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'delete-all-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'index-all-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'publish-all-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'update-all-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'view-articles']);

        // Auth Item Child Admin Categories
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'create-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'delete-all-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'publish-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'index-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'update-all-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'view-categories']);

        // Auth Item Child Editor Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'create-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'delete-his-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'index-all-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'publish-all-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'update-all-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'view-articles']);

        // Auth Item Child Editor Categories
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'create-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'delete-his-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'index-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'update-his-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'view-categories']);

		// Auth Item Child Publisher Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'create-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'index-his-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'publish-his-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'update-his-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'view-articles']);

        // Auth Item Child Publisher Categories
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'view-categories']);

        // Auth Item Child Author Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'create-articles']);
		$this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'index-his-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'update-his-articles']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'view-articles']);

        // Auth Item Child Author Categories
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'view-categories']);
    }

    public function safeDown()
    {
        // Auth Item
        $this->delete('{{%auth_item}}', ['name' => 'admin']);
        $this->delete('{{%auth_item}}', ['name' => 'editor']);
        $this->delete('{{%auth_item}}', ['name' => 'publisher']);
        $this->delete('{{%auth_item}}', ['name' => 'author']);
        $this->delete('{{%auth_item}}', ['name' => 'create-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'create-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'delete-all-articles']);
		$this->delete('{{%auth_item}}', ['name' => 'delete-his-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'delete-all-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'delete-his-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'index-all-articles']);
		$this->delete('{{%auth_item}}', ['name' => 'index-his-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'index-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'publish-all-articles']);
		$this->delete('{{%auth_item}}', ['name' => 'publish-his-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'publish-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'update-all-articles']);
		$this->delete('{{%auth_item}}', ['name' => 'update-his-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'update-all-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'update-his-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'view-articles']);
        $this->delete('{{%auth_item}}', ['name' => 'view-categories']);

        // Auth Item Child
        $this->delete('{{%auth_item_child}}', ['parent' => 'admin']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'editor']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'publisher']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'author']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'create-all-articles']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'create-his-articles']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'create-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'delete-all-articles']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'delete-his-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'delete-all-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'delete-his-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'index-all-articles']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'index-his-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'index-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'publish-all-articles']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'publish-his-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'publish-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'update-all-articles']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'update-his-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'update-all-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'update-his-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'view-articles']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'view-categories']);
    }

}
