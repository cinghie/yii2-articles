Yii2 Articles
=============

Yii2 Articles to create, manage, and delete articles in a Yii2 site.

## FEATURES

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

## CHANGELOG

<ul>
  <li>0.1.4 - Adding Item Variables in Module</li>
  <li>0.1.3 - Refactoring Module Variables</li>
  <li>0.1.2 - Added Facebook and Twitter Item View</li>
  <li>0.1.1 - Added Attachment's Table in database</li>
  <li>0.1.0 - Refactoring Project</li>
  <li>0.0.7 - Added Image Upload for Categories</li>
  <li>0.0.6 - Added Composer</li>	
  <li>0.0.5 - Fixed problem with Upload Image</li>		
  <li>0.0.4 - Added editors ckeditor, tinymce, markdown from other Packages</li>		
  <li>0.0.3 - Various Fix and Update for Categories Views</li>	
  <li>0.0.2 - Added multi-language with I18N</li>
  <li>0.0.1 - Initial Releases</li>
</ul>

## INSTALLATION USING COMPOSER

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require cinghie/yii2-articles "dev-master"
```

or add

```
"cinghie/yii2-articles": "dev-master"
```

## CONFIGURATION
<ul>
<li>Copy images folder from Extension root to yor webroot</li>
<li>Add in your configuration file, in modules section:
<pre>'modules' => [ 
...
	// Module Articles
	'articles' => [
		'class' => 'cinghie\articles\Articles',
		
		// Select Languages allowed
		'languages' => [ 
			"it-IT" => "it-IT", 
			"en-GB" => "en-GB" 
		],			
		// Select Editor: no-editor, ckeditor, tinymce, markdown
		'editor' => 'ckeditor',
		// Select Path To Upload Category Image
		'categoryImagePath' => 'img/articles/categories/',
		// Select Path To Upload Category Thumb
		'categoryThumbPath' => 'img/articles/categories/thumb/',
		// Select Path To Upload Item Image
		'itemImagePath' => 'img/articles/items/',
		// Select Path To Upload Item Thumb
		'itemThumbPath' => 'img/articles/items/thumb/',
		// Select Image Name: categoryname, original, casual
		'imageNameType' => 'categoryname',
		// Select Image Types allowed
		'imageType'     => 'img/jpg,image/jpeg,image/gif,image/png',
		// Thumbnails Options
		'thumbOptions'  => [ 
			'small'  => ['quality' => 100, 'width' => 150, 'height' => 100],
			'medium' => ['quality' => 100, 'width' => 200, 'height' => 150],
			'large'  => ['quality' => 100, 'width' => 300, 'height' => 250],
			'extra'  => ['quality' => 100, 'width' => 400, 'height' => 350],
		],
	],	
	// Module Kartik-v Grid
	'gridview' =>  [
		'class' => '\kartik\grid\Module',
	],	
	// Module Kartik-v Markdown Editor
	'markdown' => [
		'class' => 'kartik\markdown\Module',
	],
...
]</pre>
</li>

<li>Create Database Tables running the file articles\docs\database_tables.sql. If you want use database prefix, edit the file sql adding the prefix and remember to set it in your config:
<pre>
'components' => [
...
	'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=YOURDBNAME',
            'username' => 'YOURDBUSER',
            'password' => 'YOURDBPSW',
            'charset' => 'utf8',
            'tablePrefix' => 'YOURPREFIX_',
        ],
...
]
</pre>
</li>
</ul>

## LINKS
<ul> 
  <li>Admin Panel: PathToApp/index.php?r=articles</li>
  <li>Admin Panel with Pretty Urls: PathToApp/articles</li>
  <li>Categories: PathToApp/index.php?r=articles/categories</li>
  <li>Categories with Pretty Urls: PathToApp/articles/categories</li>
  <li>Items: PathToApp/index.php?r=articles/items</li>
  <li>Items with Pretty Urls: PathToApp/articles/items</li>
</ul>


## LIBRARIES NEEDED

<ul> 
  <li>Yii2 Grid: https://github.com/kartik-v/yii2-grid</li>
  <li>Yii2 Widget: https://github.com/kartik-v/yii2-widgets</li>
  <li>Yii2 MarkDown: https://github.com/kartik-v/yii2-markdown</li>
  <li>Yii2 CKEditor: https://github.com/2amigos/yii2-ckeditor-widget</li>
  <li>Yii2 TinyMCE: https://github.com/2amigos/yii2-tinymce-widget</li>
</ul> 