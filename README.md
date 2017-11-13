Yii2 Articles
=============

Yii2 Articles to create, manage, and delete articles in a Yii2 site.

<ul>
  <li>Create, edit and delete articles</li>
  <li>Article with attachments, image, gallery, hits</li>
  <li>Manage categories and subcategories</li>
  <li>Advanced Access Permission</li>
  <li>Approval</li>
  <li>Multi-Language with I18N</li>
  <li>Extra Field Management</li>
  <li>SEO Optimization</li>
</ul>

Installation
-----------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require cinghie/yii2-articles "*"
```

or add

```
"cinghie/yii2-articles": "*"
```

Configuration
-----------------

### 1. Images folder

Copy img folder to your webroot

### 2. Update yii2 articles database schema

Make sure that you have properly configured `db` application component
and run the following command:
```
$ php yii migrate/up --migrationPath=@vendor/cinghie/yii2-articles/migrations
```

### 3. Set configuration file

Set on your configuration file, in modules section

```
'modules' => [ 

	// Module Articles
	'articles' => [
		'class' => 'cinghie\articles\Articles',
		'userClass' => 'dektrium\user\models\User',
		
		// Select Languages allowed
		'languages' => [ 
			"it-IT" => "it-IT", 
			"en-GB" => "en-GB" 
		],			
		
		// Select Date Format
		'dateFormat' => 'd F Y',
		
		// Select Editor: no-editor, ckeditor, imperavi, tinymce, markdown
		'editor' => 'ckeditor',
		
		// Select Path To Upload Category Image
		'categoryImagePath' => '@webroot/img/articles/categories/',
		// Select URL To Upload Category Image
		'categoryImageURL'  => '@web/img/articles/categories/',
		// Select Path To Upload Category Thumb
		'categoryThumbPath' => '@webroot/img/articles/categories/thumb/',
		// Select URL To Upload Category Image
		'categoryThumbURL'  => '@web/img/articles/categories/thumb/',

		// Select Path To Upload Item Image
		'itemImagePath' => '@webroot/img/articles/items/',
		// Select URL To Upload Item Image
		'itemImageURL' => '@web/img/articles/items/',
		// Select Path To Upload Item Thumb
		'itemThumbPath' => '@webroot/img/articles/items/thumb/',
		// Select URL To Upload Item Thumb
		'itemThumbURL' => '@web/img/articles/items/thumb/',

		// Select Path To Upload Attachments
		'attachPath' => '@webroot/attachments/',
		// Select URL To Upload Attachment
		'attachURL' => '@web/img/articles/items/',
		// Select Image Types allowed
		'attachType' => ['jpg','jpeg','gif','png','csv','pdf','txt','doc','docs'],
		
		// Select Image Name: categoryname, original, casual
		'imageNameType' => 'categoryname',
		// Select Image Types allowed
		'imageType' => ['png','jpg','jpeg'],
		// Thumbnails Options
		'thumbOptions'  => [ 
			'small'  => ['quality' => 100, 'width' => 150, 'height' => 100],
			'medium' => ['quality' => 100, 'width' => 200, 'height' => 150],
			'large'  => ['quality' => 100, 'width' => 300, 'height' => 250],
			'extra'  => ['quality' => 100, 'width' => 400, 'height' => 350],
		],

		// Show Titles in the views
		'showTitles' => true,
		],	
	],
	
]
```

### 4. Other Configurations

To use easily this extension is strongly recommended install and config dektrium/yii2-user to manage user

[Installation](https://github.com/dektrium/yii2-user/blob/master/docs/getting-started.md)  
[Configuration](https://github.com/dektrium/yii2-user/blob/master/docs/configuration.md)

and dektrium/yii2-rbac to manage auth permission

[Installation](https://github.com/dektrium/yii2-rbac/blob/master/docs/installation.md)

### 5. Add your User as admin

```
INSERT INTO `PREFIX_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 'YUOR_USER_ID', 1451514052);
```

Override PREFIX_ with your tables prefix and YUOR_USER_ID with your user_id. For example:

```
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1451514052);
```

### Advanced Template Recommended Configuration

[Advanced Template recommended configuration](docs/advanced-template-recommended-configuration.md)

## URL Rules

```
'components' => [

        // Url Manager
        'urlManager' => [
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            // Disable site/ from the URL
            'rules' => [
                '<id:\d+>/<alias:[A-Za-z0-9 -_.]+>' => 'articles/categories/view',
                '<cat>/<id:\d+>/<alias:[A-Za-z0-9 -_.]+>' => 'articles/items/view',
            ],
        ],
],
```

## Users Auth

### Articles Permissions

|           | create | publish | update | delete | index | view |
|:---------:|:------:|:-------:|:------:|:------:|:-----:|:----:|
|   admin   |   yes  |   all   |   all  |   all  |  yes  |  yes |
|   editor  |   yes  |   all   |   all  |   his  |  yes  |  yes |
| publisher |   yes  |   his   |   his  |    no  |  his  |  yes |
|   author  |   yes  |    no   |   his  |    no  |  his  |  yes |

### Categories Permissions

|           | create | publish | update | delete | index | view |
|:---------:|:------:|:-------:|:------:|:------:|:-----:|:----:|
|   admin   |   yes  |   yes   |   yes  |   yes  |  yes  |  yes |
|   editor  |   yes  |    no   |   yes  |    no  |  yes  |  yes |
| publisher |    no  |    no   |    no  |    no  |  yes  |  yes |
|   author  |    no  |    no   |    no  |    no  |  yes  |  yes |

### Tags Permissions

|           | create | publish | update | index  | delete |
|:---------:|:------:|:-------:|:------:|:------:|:------:|
|   admin   |   yes  |   yes   |   yes  |   yes  |   yes  |
|   editor  |   yes  |   yes   |   yes  |   yes  |   yes  |
| publisher |   yes  |   yes   |   yes  |   yes  |    no  |
|   author  |   yes  |    no   |    no  |    no  |    no  |

### Users Types

The migrations add to the database 4 types of users:

<ol> 
  <li>Admin: 
  	<ul>
  	    <li>Can Create Categories</li>
  	    <li>Can Publish Categories</li>
  	    <li>Can Delete Categories</li>
  	    <li>Can Update Categories</li>
  	    <li>Can Index Categories</li>
  		<li>Can Create Articles</li>
  		<li>Can Publish all Articles</li>
  		<li>Can Update all Articles</li>
  		<li>Can Delete all Articles</li>
  		<li>Can Index all Articles</li>
  		<li>Can View all Articles</li>
  		<li>Can Create Tags</li>
        <li>Can Publish Tags</li>
        <li>Can Delete Tags</li>
        <li>Can Update Tags</li>
        <li>Can Index Tags</li>	    
  	</ul>
  </li>
  <li>Editor: 
  	<ul>
  	    <li>Can Create Categories</li>
        <li>Can't Publish Categories</li>
        <li>Can't Delete Categories</li>
        <li>Can Update Categories</li>
        <li>Can Index Categories</li>
  		<li>Can Create Articles</li>
  		<li>Can Publish his Articles</li>
  		<li>Can Update all Articles</li>
  		<li>Can Delete his Articles</li>
  		<li>Can Index Articles</li>
  		<li>Can View all Articles</li>
  		<li>Can Create Tags</li>
        <li>Can Publish Tags</li>
        <li>Can Delete Tags</li>
        <li>Can Update Tags</li>
        <li>Can Index Tags</li>	  
  	</ul>
  </li>
  <li>Publisher: 
  	<ul>
        <li>Can't Create Categories</li>
        <li>Can't Publish Categories</li>
        <li>Can't Delete Categories</li>  
        <li>Can't Update Categories</li>
        <li>Can Index Categories</li>
  		<li>Can Create Articles</li>
  		<li>Can Publish his Articles</li>
  		<li>Can Update his Articles</li>
  		<li>Can Delete his Articles</li>
  		<li>Can Index his Articles</li>
  		<li>Can View all Articles</li>
  		<li>Can Create Tags</li>
        <li>Can Publish Tags</li>
        <li>Can Update Tags</li>  	
        <li>Can Index Tags</li>	
  	</ul>
  </li>  
  <li>Author: 
  	<ul>
        <li>Can't Create Categories</li>
        <li>Can't Publish Categories</li>
        <li>Can't Delete Categories</li>
        <li>Can't Update Categories</li>
        <li>Can Index Categories</li>
  		<li>Can Create Articles</li>
  		<li>Can't Publish his Articles</li>
  		<li>Can Update his Articles</li>
  		<li>Can't Delete Articles</li>
  		<li>Can't Index Articles</li>
  		<li>Can View Articles</li>
  		<li>Can Create Tags</li>
  	</ul>
  </li>
</ol>  

## LINKS
<ul> 
  <li>Admin Panel: PathToApp/index.php?r=articles</li>
  <li>Admin Panel with Pretty Urls: PathToApp/articles</li>
  <li>Categories: PathToApp/index.php?r=articles/categories</li>
  <li>Categories with Pretty Urls: PathToApp/articles/categories</li>
  <li>Items: PathToApp/index.php?r=articles/items</li>
  <li>Items with Pretty Urls: PathToApp/articles/items</li>
  <li>Attachments: PathToApp/index.php?r=articles/attachments</li>
  <li>Attachments with Pretty Urls: PathToApp/articles/attachments</li>
  <li>Tags: PathToApp/index.php?r=articles/tags</li>
  <li>Tags with Pretty Urls: PathToApp/articles/tags</li>
</ul>
