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

use yii\db\Migration;

class m151105_204428_insert_article_auth extends Migration
{
    public function safeUp()
    {
        // Auth Item Roles
        $this->insert('{{%auth_item}}',['name' => 'admin','type' => '1','description' => 'Can create, publish all, update all, delete all, view and admin grid articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'editor','type' => '1','description' => 'Can create, publish all articles, update all articles, delete his articles, view and admin grid articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'publisher','type' => '1','description' => 'Can create, publish his articles, update all articles, view and admin grid his articles','created_at' => time(),'updated_at' => time()]);
		$this->insert('{{%auth_item}}',['name' => 'author','type' => '1','description' => 'Can create and update his articles and view','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'registered','type' => '1','description' => 'User Logged','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'public','type' => '1','description' => 'User not Logged','created_at' => time(),'updated_at' => time()]);

		// Auth Item Permissions
		$this->insert('{{%auth_item}}',['name' => 'articles-create-items', 'type' => '2', 'description' => 'Can create articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-create-categories', 'type' => '2', 'description' => 'Can create categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-delete-all-items', 'type' => '2', 'description' => 'Can delete all articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-delete-his-items', 'type' => '2', 'description' => 'Can delete his articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-delete-categories', 'type' => '2', 'description' => 'Can delete all categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-index-all-items', 'type' => '2', 'description' => 'Can view all articles admin grid','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-index-his-items', 'type' => '2', 'description' => 'Can view his articles admin grid','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-index-categories', 'type' => '2', 'description' => 'Can view categories admin grid','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-publish-all-items', 'type' => '2', 'description' => 'Can publish all articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-publish-his-items', 'type' => '2', 'description' => 'Can publish his articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-publish-categories', 'type' => '2', 'description' => 'Can publish categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-update-all-items', 'type' => '2', 'description' => 'Can update all articles','created_at' => time(),'updated_at' => time()]);
		$this->insert('{{%auth_item}}',['name' => 'articles-update-his-items', 'type' => '2', 'description' => 'Can update his articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-update-categories', 'type' => '2', 'description' => 'Can update all categories','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-view-items', 'type' => '2', 'description' => 'Can view articles','created_at' => time(),'updated_at' => time()]);
        $this->insert('{{%auth_item}}',['name' => 'articles-view-categories', 'type' => '2', 'description' => 'Can view categories','created_at' => time(),'updated_at' => time()]);	
		
        // Auth Item Child Admin Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-create-items']);
		$this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-delete-all-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-index-all-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-publish-all-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-update-all-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-view-items']);

        // Auth Item Child Admin Categories
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-create-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-delete-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-publish-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-index-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-update-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'admin', 'child' => 'articles-view-categories']);

        // Auth Item Child Editor Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-create-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-delete-his-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-index-all-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-publish-all-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-update-all-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-view-items']);

        // Auth Item Child Editor Categories
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-create-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-index-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-update-categories']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'editor', 'child' => 'articles-view-categories']);

		// Auth Item Child Publisher Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'articles-create-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'articles-index-his-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'articles-publish-his-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'articles-update-his-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'articles-view-items']);

        // Auth Item Child Publisher Categories
        $this->insert('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'articles-view-categories']);

        // Auth Item Child Author Articles
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'articles-create-items']);
		$this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'articles-index-his-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'articles-update-his-items']);
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'articles-view-items']);

        // Auth Item Child Author Categories
        $this->insert('{{%auth_item_child}}', ['parent' => 'author', 'child' => 'articles-view-categories']);
    }

    public function safeDown()
    {
        // Auth Item Roles
        $this->delete('{{%auth_item}}', ['name' => 'admin']);
        $this->delete('{{%auth_item}}', ['name' => 'editor']);
        $this->delete('{{%auth_item}}', ['name' => 'publisher']);
        $this->delete('{{%auth_item}}', ['name' => 'author']);
		
		// Auth Item Permissions
        $this->delete('{{%auth_item}}', ['name' => 'articles-create-items']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-create-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-delete-all-items']);
		$this->delete('{{%auth_item}}', ['name' => 'articles-delete-his-items']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-delete-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-index-all-items']);
		$this->delete('{{%auth_item}}', ['name' => 'articles-index-his-items']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-index-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-publish-all-items']);
		$this->delete('{{%auth_item}}', ['name' => 'articles-publish-his-items']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-publish-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-update-all-items']);
		$this->delete('{{%auth_item}}', ['name' => 'articles-update-his-items']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-update-categories']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-view-items']);
        $this->delete('{{%auth_item}}', ['name' => 'articles-view-categories']);

        // Auth Item Child Roles
        $this->delete('{{%auth_item_child}}', ['parent' => 'admin']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'editor']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'publisher']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'author']);
		
		// Auth Item Child Permissions
        $this->delete('{{%auth_item_child}}', ['parent' => 'create-all-articles']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'create-his-articles']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'articles-create-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'articles-delete-all-items']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'articles-delete-his-items']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'articles-delete-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'articles-index-all-items']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'articles-index-his-items']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'articles-index-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'articles-publish-all-items']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'articles-publish-his-items']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'articles-publish-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'articles-update-all-items']);
		$this->delete('{{%auth_item_child}}', ['parent' => 'articles-update-his-items']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'articles-update-categories']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'articles-view-items']);
        $this->delete('{{%auth_item_child}}', ['parent' => 'articles-view-categories']);
    }

}
