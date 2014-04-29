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
		
		// Languages allowed
		'languages' => array_merge([ "en-GB" => "en-GB" ],[ "it-IT" => "it-IT" ]),
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
  <li>Admin: path/to/app/index.php?r=articles</li>
  <li>Categories: path/to/app/index.php?r=articles/categories</li>
  <li>Items: path/to/app/index.php?r=articles/items</li>
</ul>


<h2>LIBRARIES NEEDED</h2>

Yii2 Widget: https://github.com/kartik-v/yii2-widgets
