<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.3.1
 */

use yii\db\Migration;

class m151105_204428_insert_auth_articles extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%auth_item}}',
            ['name' => 'admin', 'type' => '1', 'description' => 'Can create, update, delete, view and admin grid articles'],
            ['name' => 'create-articles', 'type' => '1', 'description' => 'Can create articles'],
            ['name' => 'create-categories', 'type' => '1', 'description' => 'Can create categories'],
            ['name' => 'delete-articles', 'type' => '1', 'description' => 'Can delete articles'],
            ['name' => 'delete-categories', 'type' => '1', 'description' => 'Can delete categories'],
            ['name' => 'index-articles', 'type' => '1', 'description' => 'Can view articles admin grid'],
            ['name' => 'index-categories', 'type' => '1', 'description' => 'Can view categories admin grid'],
            ['name' => 'publish-articles', 'type' => '1', 'description' => 'Can publish articles'],
            ['name' => 'publish-categories', 'type' => '1', 'description' => 'Can publish categories'],
            ['name' => 'update-articles', 'type' => '1', 'description' => 'Can update articles'],
            ['name' => 'update-categories', 'type' => '1', 'description' => 'Can update categories'],
            ['name' => 'view-articles', 'type' => '1', 'description' => 'Can view articles'],
            ['name' => 'view-categories', 'type' => '1', 'description' => 'Can view categories']
        );

        $this->insert('{{%auth_item_child}}',
            ['parent' => 'admin', 'child' => 'create-articles'],
            ['parent' => 'admin', 'child' => 'create-categories'],
            ['parent' => 'admin', 'child' => 'delete-articles'],
            ['parent' => 'admin', 'child' => 'delete-categories'],
            ['parent' => 'admin', 'child' => 'index-articles'],
            ['parent' => 'admin', 'child' => 'index-categories'],
            ['parent' => 'admin', 'child' => 'publish-articles'],
            ['parent' => 'admin', 'child' => 'publish-categories'],
            ['parent' => 'admin', 'child' => 'update-articles'],
            ['parent' => 'admin', 'child' => 'update-categories'],
            ['parent' => 'admin', 'child' => 'view-categories'],
            ['parent' => 'admin', 'child' => 'view-articles']
        );
    }

    public function safeDown()
    {
        $this->delete('{{%auth_item}}',
            ['name' => 'admin'],
            ['name' => 'create-articles'],
            ['name' => 'create-categories'],
            ['name' => 'delete-articles'],
            ['name' => 'delete-categories'],
            ['name' => 'index-articles'],
            ['name' => 'index-categories'],
            ['name' => 'publish-articles'],
            ['name' => 'publish-categories'],
            ['name' => 'update-articles'],
            ['name' => 'update-categories'],
            ['name' => 'view-articles'],
            ['name' => 'view-categories']
        );

        $this->delete('{{%auth_item_child}}',
            ['parent' => 'admin'],
            ['parent' => 'create-articles'],
            ['parent' => 'create-categories'],
            ['parent' => 'delete-articles'],
            ['parent' => 'delete-categories'],
            ['parent' => 'index-articles'],
            ['parent' => 'index-categories'],
            ['parent' => 'publish-articles'],
            ['parent' => 'publish-categories'],
            ['parent' => 'update-articles'],
            ['parent' => 'update-categories'],
            ['parent' => 'view-articles'],
            ['parent' => 'view-categories']
        );
        
    }

}
