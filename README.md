Yii2 Articles
=============

Yii2 Articles to create, manage, and delete articles in a Yii2 site.

<h2>FEATURES</h2>

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

<h2>CHANGELOG</h2>

<ul>
  <li>0.0.5 - Fixed problem with Upload Image</li>		
  <li>0.0.4 - Added editors ckeditor, tinymce, markdown from other Packages</li>		
  <li>0.0.3 - Various Fix and Update for Categorie Views</li>	
  <li>0.0.2 - Update Categories Create View, multi-linguage with I18N</li>
  <li>0.0.1 - Initial Realese, CRUD for Categories and Items</li>
</ul>

<h2>INSTALLATION USING COMPOSER</h2>

<h2>MANUAL INSTALLATION</h2>

Download and copy the file in your module folder

<h2>CONFIGURATION</h2>
<ul>

<li>Add in your configuration file, in modules section:
<pre>'modules' => [ 
...
	// Module Articles
	'articles' => [
		'class' => 'app\modules\articles\Articles',
		
		// Select Languages allowed
		'languages' => array_merge([ "en-GB" => "en-GB" ],[ "it-IT" => "it-IT" ]),			
		// Select Editor: no-editor, ckeditor, tinymce, markdown
		'editor' => 'ckeditor',
		// Select Image Types allowed
		'categoryimagetype' => 'jpg,jpeg,gif,png',
		// Select Image Path To Upload
		'categoryimagepath' => dirname(dirname(__DIR__)) . '/frontend/web/img/articles/categories/',
		// Select Image Path To Upload
		'categorythumbpath' => dirname(dirname(__DIR__)) . '/frontend/web/img/articles/categories/thumb/',
	],
	
	// Module Kartik-v Grid
		'gridview' =>  [
			'class' => '\kartik\grid\Module',
			
			// array the the internalization configuration for this module
			'i18n' => [
				'class' => 'yii\i18n\PhpMessageSource',
				'basePath' => '@kvgrid/messages',
				'forceTranslation' => true
			], 
		],
		
	// Module Kartik-v Markdown Editor
		'markdown' => [
			'class' => 'kartik\markdown\Module',
			
			// array the the internalization configuration for this module
			'i18n' => [
				'class' => 'yii\i18n\PhpMessageSource',
				'basePath' => '@markdown/messages',
				'forceTranslation' => true
			], 
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

<h2>LINK</h2>
<ul> 
  <li>Admin Panel: PathToApp/index.php?r=articles</li>
  <li>Admin Panel with Pretty Urls: PathToApp/articles</li>
  <li>Categories: PathToApp/index.php?r=articles/categories</li>
  <li>Categories with Pretty Urls: PathToApp/articles/categories</li>
  <li>Items: PathToApp/index.php?r=articles/items</li>
  <li>Items with Pretty Urls: PathToApp/articles/items</li>
</ul>


<h2>LIBRARIES NEEDED</h2>

<ul> 
  <li>Yii2 Grid: https://github.com/kartik-v/yii2-grid</li>
  <li>Yii2 Widget: https://github.com/kartik-v/yii2-widgets</li>
  <li>Yii2 MarkDown: https://github.com/kartik-v/yii2-markdown</li>
  <li>Yii2 CKEditor: https://github.com/2amigos/yii2-ckeditor-widget</li>
  <li>Yii2 TinyMCE: https://github.com/2amigos/yii2-tinymce-widget</li>
</ul> 