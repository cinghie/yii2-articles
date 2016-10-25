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
        'dateFormat' => 'd F Y';
		
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
        'itemImageURL'  => '@web/img/articles/items/',
        // Select Path To Upload Item Thumb
        'itemThumbPath' => '@webroot/img/articles/items/thumb/',
        // Select URL To Upload Item Thumb
        'itemThumbURL'  => '@web/img/articles/items/thumb/',
		
		// Select Path To Upload Attachments
        'attachPath' => '@webroot/attachments/',
		// Select URL To Upload Attachment
        'attachURL' => '@web/img/articles/items/',
		// Select Image Types allowed
		'attachType' => 'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, .csv, .pdf, text/plain, .jpg, .jpeg, .gif, .png',
		
		// Select Image Name: categoryname, original, casual
		'imageNameType' => 'categoryname',
		// Select Image Types allowed
		'imageType'     => 'jpg,jpeg,gif,png',
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
	
	// Module Kartik-v Grid
	'gridview' =>  [
		'class' => '\kartik\grid\Module',
	],
	
	// Module Kartik-v Markdown Editor
	'markdown' => [
		'class' => 'kartik\markdown\Module',
	],

]
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
|   admin   |   yes  |   yes   |   yes  |   all  |  yes  |  yes |
|   editor  |   yes  |    no   |   yes  |    no  |  yes  |  yes |
| publisher |    no  |    no   |    no  |    no  |  yes  |  yes |
|   author  |    no  |    no   |    no  |    no  |  yes  |  yes |

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
</ul>

## CHANGELOG

<ul>
  <li>Version 0.6.3 - Implementing Pull Request #9</li>
  <li>Version 0.6.2 - Implementing Pull Request #6</li>
  <li>Version 0.6.1 - Fixed #4 #5 and adding active/deactive buttons</li>
  <li>Version 0.6.0 - Adding Url Rules</li>
  <li>Version 0.5.2 - Adding Attachments</li>
  <li>Version 0.6.2 - Adding Access to Categories and Articles</li>
  <li>Version 0.5.0 - Update Articles index, Categories index, Refactor RBAC functions</li>
  <li>Version 0.4.1 - Update RBAC functions</li>
  <li>Version 0.4.0 - Adding first RBAC functions</li>
  <li>Version 0.3.1 - Adding image to categories view</li>
  <li>Version 0.3.0 - Deny to not logged to index, create, update, delete; only view permitted</li>
  <li>Version 0.2.7 - Update Articles Params</li>
  <li>Version 0.2.6 - Update Migrations</li>
  <li>Version 0.2.5 - Update Asset Depends</li>
  <li>Version 0.2.4 - Update Italian Translations</li>
  <li>Version 0.2.3 - Update Asset setting articles.css after bootstrap</li>
  <li>Version 0.2.2 - Update Item View</li>
  <li>Version 0.2.1 - Adding video_type field in Items and fixed modified</li>
  <li>Version 0.2.0 - Adding Upload Image in Items</li>
  <li>Version 0.1.14 - Cleaning Categories Code</li>
  <li>Version 0.1.13 - Generalizing Upload File Field</li>
  <li>Version 0.1.12 - Adding Migrations Example</li>
  <li>Version 0.1.11 - Fixing Delete Image in Categories</li>
  <li>Version 0.1.10 - Adding Admin Menù</li>
  <li>Version 0.1.9 - Adding Attachment's Files</li>
  <li>Version 0.1.8 - Refactoring Categories Upload Image</li>
  <li>Version 0.1.7 - Fixing TinyMCE problems</li>
  <li>Version 0.1.6 - Adding Imperavi Redactor as Editor in Categories and Items</li>
  <li>Version 0.1.5 - Update Item Created and Modified</li>
  <li>Version 0.1.4 - Adding Item Variables in Module</li>
  <li>Version 0.1.3 - Refactoring Module Variables</li>
  <li>Version 0.1.2 - Added Facebook and Twitter Item View</li>
  <li>Version 0.1.1 - Added Attachment's Table in database</li>
  <li>Version 0.1.0 - Refactoring Project</li>
  <li>Version 0.0.7 - Added Image Upload for Categories</li>
  <li>Version 0.0.6 - Added Composer</li>	
  <li>Version 0.0.5 - Fixed problem with Upload Image</li>		
  <li>Version 0.0.4 - Added editors ckeditor, tinymce, markdown from other Packages</li>		
  <li>Version 0.0.3 - Various Fix and Update for Categories Views</li>	
  <li>Version 0.0.2 - Added multi-language with I18N</li>
  <li>Version 0.0.1 - Initial Releases</li>
</ul>


## LIBRARIES NEEDED

<ul> 
  <li>Yii2 Grid: https://github.com/kartik-v/yii2-grid</li>
  <li>Yii2 Widget: https://github.com/kartik-v/yii2-widgets</li>
  <li>Yii2 mPDF: https://github.com/kartik-v/yii2-mpdf</li>
  <li>Yii2 MarkDown: https://github.com/kartik-v/yii2-markdown</li>
  <li>Yii2 CKEditor: https://github.com/2amigos/yii2-ckeditor-widget</li>
  <li>Yii2 TinyMCE: https://github.com/2amigos/yii2-tinymce-widget</li>
  <li>Yii2 Imperavi Redactor: https://github.com/asofter/yii2-imperavi-redactor</li>
</ul> 
